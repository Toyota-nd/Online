<?php

class AuthController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		$this->_helper->layout()->setLayout('auth_layout');
		$form = new Application_Form_Login();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if ($this->_process($form->getValues())) {
					// We're authenticated! Redirect to the home page
					$this->_helper->redirector('index', 'index');
				}
			}
		}
		$this->view->form = $form;
	}

	protected function _process($values)
	{
		$username = strtoupper($values['username']);
		$result_xml = $this->_checkTcode($username,$values['password']);
		if ($this->_isXmlAuthWriteDB($result_xml,$username,$values['password'])) {// From KSU Office
			// Get our authentication adapter and check credentials
			$adapter = $this->_getAuthAdapter(); //From  Users' table of local DB
			$adapter->setIdentity($username); // From GUI input
			$adapter->setCredential($values['password']);// From GUI input
			$auth = Zend_Auth::getInstance();
			$result = $auth->authenticate($adapter); // Compare GUI input vs. local DB
			if ($result->isValid()) {
				$user = $adapter->getResultRowObject();
				$auth->getStorage()->write($user);
				return true;
			}
		}
		return false;
	}

	protected function _getAuthAdapter()
	{
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

		$authAdapter->setTableName('users')
		->setIdentityColumn('username')
		->setCredentialColumn('password')
		->setCredentialTreatment('SHA1(?)'); // Or 'SHA1(CONCAT(?,salt))'

		return $authAdapter;
	}

	public function logoutAction()
	{
		Zend_Auth::getInstance()->clearIdentity();
		$this->_helper->redirector('index'); // back to login page
	}
	protected function _checkTcode($username,$password)
	{
		//		return simplexml_load_file('http://www.ksu.edu.tw/utility/login/IDCertification.aspx?Acc=' .
		return simplexml_load_file('http://cca.ksu.edu.tw/gateway.php?Acc=' .
				strtoupper($username) . '&Pwd=' . sha1($password));
	}
	protected function _isXmlAuthWriteDB($xml,$username,$password)
	{
		$check = $xml->passed[0];
		if ($check=="true") {
			$chinese_name =
			(string) $xml->personal_data->name[0] .
			(string) $xml->personal_data->name[1] ;
			$english_name =	(string) $xml->personal_data->name[2]	;
			$i = 0;
			$role = 0;
			foreach ($xml->personal_identity->part as $part):
			$parts = (string)$part;
			$attrib = explode("|", $parts);
			$title[$i] =  $attrib[2] . $attrib[3] . $chinese_name . $attrib[4];
			if ($xml->personal_identity->part[$i]->attributes()->property == 'prime') {
				$role = $i;
				$prime_system = $attrib[0];
				$prime_type = $attrib[1];
				$prime_affiliation = $attrib[2];
				$prime_department = $attrib[3];
				$prime_position = $attrib[4];
				$prime_fulltime = $attrib[5];
			}
			$i++;
			//print $title . "<br/>";
			endforeach;
			
			$this->view->entries = $title;
				
			$users_mapper = new Application_Model_UsersMapper();
			$users = new Application_Model_Users();
			$users->setUsername($username);
			$users->setPassword(sha1($password));
			$users->setCname($chinese_name);
			$users->setEname($english_name);
			$users->setEmail((string)$xml->personal_data->email);
			$users->setPid((string)$xml->personal_data->id);
			$users->setBirthday((string)$xml->personal_data->birthday);
			$users->setRole($role);
			$users->setCreated(date('Y-m-d H:i:s'));
			$users->setSystem((string)$prime_system);
			$users->setType((string)$prime_type);
			$users->setAffiliation((string)$prime_affiliation);
			$users->setDepartment((string)$prime_department);
			$users->setPosition((string)$prime_position);
			$users->setFulltime((string)$prime_fulltime);
			$users_mapper->save($users); 
			$mytitle = $chinese_name . $prime_position;
			$email = (string)$xml->personal_data->email;
			//$subject = "=?UTF-8?B?".base64_encode('歡迎 ' . $mytitle)."?=" ;
			$subject = '歡迎 ' . $mytitle;
			$message = $mytitle . '<span style="color=#FF00000">您好:</span><br>請輸入:<input type="text" size="10"/><br>即日起至2013/4/1，請各系專題製作同學至競賽追踪平台填報「2013中華電信創意應用大賽」構想。2013電信創新應用大賽將因應多螢趨勢與流行風潮，推出多項全新競賽項目，邀全民加入數位學習與創新研發。中華電信董事長呂學錦表示，創新要有紮實的基本功，如全壘打王王貞治苦練的金雞獨立揮棒方式；或是iPhone、iPad，連2、3歲的小孩子也會玩。下一個憤怒鳥可遇不可求，但中華電信希望打造一個創新的環境，給年輕人去發揮。';
			$mail = new Zend_Mail('utf-8');
			$mail->addTo($email);
			$mail->setSubject($subject);
			$mail->setBodyHtml($message,'utf-8',Zend_Mime::ENCODING_BASE64);
			$mail->setFrom('ccad01@mail.ksu.edu.tw', '崑山科技大學報名中華電信創新應用競賽管理系統');
			//Send it!
			$sent = true;
			try {
				$mail->send();
			} catch (Exception $e){
				$sent = false;
			}

			//Do stuff (display error message, log it, redirect user, etc)
			if($sent){
				//Mail was sent successfully.
			} else {
				//Mail failed to send.
			}	
		} else {
			return false;
		}
		return true;
	}
}


