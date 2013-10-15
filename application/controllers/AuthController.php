<?php

class AuthController extends Zend_Controller_Action {

	public function init()
	{

		/* Initialize action controller here */
		
	}

	public function indexAction()
	{
		$user_id = $this->_request->getParam('user_id');
		$password = $this->_request->getParam('password');
//		$this->view->debugLog($user_id,1);
//		$this->view->debugLog($password,1);
		$this->_helper->layout()->setLayout('auth_layout');
		$form = new Application_Form_Login();
		$request = $this->getRequest();
		if ($request->isPost()) {
			//Ajax 抑制原有頁面layout輸出至對應的Action,把顯示工作交由javascript處理
			$this->view->layout()->disableLayout();
			$this->_helper->viewRenderer->setNoRender(true);
			if ($form->isValid($request->getPost())) {
				/*注意:
				1.新增Crontoller/Action一定要有授權，(Internal Error 500主要原因)。
				2. 授權表放在library\My\Controller\Helper\Acl.php。
				3. 帳號一定要先存在
				4. 密碼一定要與資料相符
				5._process沒有授權成功會導致程式無故中斷，故使用try catch攔截錯誤。
				6. 資料庫一定要有myresource.module(varchar(20))，privillege.allow(Boolean)兩個欄位
				7. 而且資料庫user.role角色內容一定先授權，目前設為助理教授
				*/
				$user_mapper = new Application_Model_UserMapper();
				$user = new Application_Model_User();
				$user_id = $user_mapper->checkAccount($user_id);
				if ($user_mapper->isExisted($user_id)) {
					$user_mapper->find($user_id, $user);
					//$this->view->debugLog($form->getValues(),1);
					$input = $form->getValues();
					$input['user_id'] = $user_id;
					if ($this->_process($input,0)) { // 0:for Toyota(Normal), other:KSU check Tcode of XML Web Service
						// We're authenticated! Redirect to the home page
						//add parameters 
						/*
						$controller = 'index';
						$action = 'home';
						$module = 'exam';
						//$parameters = array('para1' => 'test1',    'para2' => 'test2' ); 
						$parameters = array(); 
						$this->_helper->redirector($action , $controller , $module, $parameters ); 
						*/
						$result = '1';
						$text = "";
						$user->setLogindate(date('Y-m-d H:i:s'));
						$user_mapper->save($user);
					} else {	
						$result = '2';
						$text = "密碼錯誤!";
					}
				} else {
					$result = '3';
					$text = "帳號未通過檢查找不到!";
				}
				$returnStr = "{\"user_id\" : \"$user_id\" ,\"code\" : \"$result\" , \"text\" : \"$text\"}";//json_encode($result);
				$this->_response->setBody($returnStr);
			} 
		}
		$this->view->form = $form;
		
			/*
			$this->view->entries = $title;
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
		*/
	
	}

	public function changepwAction() {
		$user_id = $this->_request->getParam('user_id');
		$password = $this->_request->getParam('password');
		$new_password = $this->_request->getParam('new_password');
		$this->_helper->layout()->setLayout('auth_layout');
		$form = new Application_Form_Password();
		$request = $this->getRequest();
		if ($request->isPost()) {
			//Ajax 抑制原有頁面layout輸出至對應的Action,把顯示工作交由javascript處理
			$this->view->layout()->disableLayout();
			$this->_helper->viewRenderer->setNoRender(true);
			if ($form->isValid($request->getPost())) {
				$user_mapper = new Application_Model_UserMapper();
				$user = new Application_Model_User();
				if ($user_mapper->isExisted($user_id)) {
					$user_mapper->find($user_id, $user);
					$old_password = $user->getPassword();
					//檢查舊密碼的是否合法
					if ($old_password==$password) {
						$user->setPassword($new_password);
						$user_mapper->save($user);
						$this->_response->setBody("密碼已變更!");
						//$this->view->message = '密碼已變更!';
					} else {
						$this->_response->setBody("原密碼錯誤，無法更改!");
						//$this->view->message = '原密碼錯誤，無法更改!';
					}
				} else {
					$this->_response->setBody("帳號找不到!");
					//$this->view->message = '帳號找不到!' ;
				}		
				//if ($this->_process($form->getValues(),0)) { // 0:for Toyota(Normal), other:KSU check Tcode of XML Web Service
					// We're authenticated! Redirect to the home page
					//add parameters 
					/*
					$controller = 'auth';
					$action = 'changepw';
					$module = 'exam';
					//$parameters = array('para1' => 'test1',    'para2' => 'test2' ); 
					$parameters = array(); 
					$this->_helper->redirector($action , $controller , $module, $parameters ); 					
					*/
				//}
			}
		}
		$this->view->form = $form;
		
			/*
			$this->view->entries = $title;
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
		*/

	}
	
	protected function _process($values,$code)
	{
		if ($code == 0) {
			$user_id = strtoupper($values['user_id']);
			// Get our authentication adapter and check credentials
			$adapter = $this->_getAuthAdapter(); //From  User' table of local DB
			$adapter->setIdentity($user_id); // From GUI input
			$adapter->setCredential($values['password']);// From GUI input
			$auth = Zend_Auth::getInstance();
			//注意:沒有授權成功會導致程式無故中斷

			try {
				$result = $auth->authenticate($adapter); // Compare GUI input vs. local DB
			} catch (Exception $e) {
				return false;
			}
			if ($result->isValid()) {
				$user = $adapter->getResultRowObject();
				$auth->getStorage()->write($user);
				return true;
			}
		} else {
			$user_id = strtoupper($values['user_id']);
			$result_xml = $this->_checkTcode($user_id,$values['password']);
			if ($this->_isXmlAuthWriteDB($result_xml,$user_id,$values['password'])) {// From KSU Office
				// Get our authentication adapter and check credentials
				$adapter = $this->_getAuthAdapter(); //From  User' table of local DB
				$adapter->setIdentity($user_id); // From GUI input
				$adapter->setCredential($values['password']);// From GUI input
				$auth = Zend_Auth::getInstance();
				$result = $auth->authenticate($adapter); // Compare GUI input vs. local DB
				if ($result->isValid()) {
					$user = $adapter->getResultRowObject();
					$auth->getStorage()->write($user);
					return true;
				}
			}
		}
		return false;
	}

	protected function _getAuthAdapter()
	{
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
		
		$authAdapter->setTableName('user')
		->setIdentityColumn('user_id')
		->setCredentialColumn('password')
		->setCredentialTreatment('?'); //'SHA1(?)'  OR 'SHA1(CONCAT(?,salt))'

		return $authAdapter;
	}

	public function logoutAction()
	{
		Zend_Auth::getInstance()->clearIdentity();
		$this->_helper->redirector('index'); // back to login page
	}

public function _privilegeAction() {
    // Get the ACL - its stored in the session:
	$acl = $_SESSION['mysession']['acl'];
	if (!isset($acl)) {
		return Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')
				->setGotoUrl('auth/logout');
	}
	$this->_helper->layout()->setLayout('message_layout');
    $this->view->content_title = "Access Rules:";
	/*
    $service = $this->service()->acl();
    $acl = $service->getAcl();
	*/
    $roles = $acl->getRoles();
    $resources = $acl->getResources();
    $results = array();

    // load XML to get all rules & roles & actions
    //$configdata = $service->getConfigdata();
	Zend_Debug::dump($roles);
	Zend_Debug::dump($resources);
	$cont = $this->_getParam('cont');
	Zend_Debug::dump($acl);

    $actions = array();
    foreach ($configdata['rules']['rule'] as $rule){
        if(isset($rule['action'])){
            if(!is_array($rule['action']))
                $rule['action'] = array($rule['action']);
            foreach($rule['action'] as $action){
                $actions[$rule['resource']][$action] = $action;
            }
        }

    }

    $results[] =
    '<thead>'
    .   '<tr>'
    .       '<th>Resource</th>'
    .       '<th>Action</th>'
    .       '<th colspan="'.count($roles).'">Roles</th>'
    .   '</tr>'
    .   '<tr>'
    .       '<th></th>'
    .       '<th></th>';

    foreach ($roles as $role){
        $results[] = '<th>'.$role.'</th>' . PHP_EOL;
    }
    $results[] = '</tr></thead>' . PHP_EOL;
    $results[] = '<tbody>';

    foreach ($resources as $resource){

        $results[] = '<tr><th>'.$resource.'</th><td>-</td>';
        foreach ($roles as $role){
            $test = $acl->isAllowed($role, $resource);
            $results[] = '<td'.($test?' class="green"':' class="red"').'>'.($test?'YES':'NO').'</td>';
        }
        $results[] = '</tr>';

        if(isset($actions[$resource])){
            foreach ($actions[$resource] as $action){

                $results[] = '<tr><th>&rarr;</th><td>'.$action.'</td>';
                foreach ($roles as $role){
                    $test = $acl->isAllowed($role, $resource, $action);
                    $results[] = '<td'.($test?' class="green"':' class="red"').'>'.($test?'YES':'NO').'</td>';
                }
                $results[] = '</tr>';
            }
        }
    }
	$this->view = $results;
}

public function privilegeAction() {
    // Get the ACL - its stored in the session:
	$acl = $_SESSION['mysession']['acl'];
	if (!isset($acl)) {
		return Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')
				->setGotoUrl('auth/logout');
	}
	$this->_helper->layout()->setLayout('message_layout');
    $this->view->content_title = "Access Rules:";

    // List all Roles in the ACL:
    $roles = $acl->getRoles();
    // Pass the roles to the view:
    $this->view->roles = $roles;

    // Check if a role has been clicked on:
    $role = $this->_getParam('role');
    if(!is_null($role))
    {
        // Pass the role to the view:
        $this->view->role = $role;

        // Get all the resources (controllers) from the ACL, don't add roles:
        $controllers = array();
        foreach ($acl->getResources() as $res)
        {
            if (!in_array($res, $roles))
            {
                $controllers[] = $res;
            }
        }
        // Create a Rules Model:
        //$rules = new Model_ACLrules();
        // Store controllers + access:
        $all_controllers = array();
        // Check if the controller has been passed:
        $cont = $this->_getParam('cont');
        // Loop through each controller:
        foreach ($controllers as $controller)
        {
            // Get all actions for the controller:
            // THIS IS THE PART I DON'T LIKE - BUT I SEE NO WAY TO GET
            // THE RULES FROM THE ACL - THERE LOOKS TO BE A METHOD
            // BUT IT IS A PROTECTED METHOD - SO I AM GETTING THE ACTIONS 
            // FROM THE DB, BUT THIS MEANS TWO SQL QUERIES - ONE TO FIND
            // THE RESOURCE FROM THE DB TO GET ITS ID THEN ONE TO FIND
            // ALL THE EXTRAS FOR IT:
            //$all_rules = $rules->findAllActions($controller);

            // Store if the role is allowed access somewhere in the controller:
            $allowed = false;

            // Store selected controller actions:
            $cont_actions = array();

            // Loop through all returned row of actions for the resource:
            /*foreach ($all_rules as $rule)
            {
                // Split the extras field:
                $extras = explode(",", $rule->extras); 

                // Check if the role has access to any of the actions:
                foreach ($extras as $act)
                {
                    // Store matching selected controller:
                    $match = ($cont==$controller)?true:false;

                    // Store the action if we are looking at a resource:
                    if ($match)$temp = array("action"=>$act,"allowed"=>false);

                    // Check if the role is allowed:
                    if ($acl->isAllowed($role,$controller,$act))
                    {
                        // Change the controllers allowed to ture as at least one item is allowed:
                        $allowed = true;

                        // Change the matched controllers action to true:
                        if ($match)$temp = array("action"=>$act,"allowed"=>true);
                    }

                    // Check if the action has already been added if we are looking at a resource:
                    if ($match)
                    {
                        $add = true;
                        // This is done because there could be several rows of extras, for example
                        // login is allowed for guest, then on another row login is denied for member,
                        // this means the login action will be found twice for the resource,
                        // no point in showing login action twice:
                        foreach ($cont_actions as $a)
                        {
                            // Action already in the array, don't add it again:
                            if ($a['action'] == $act) $add = false;
                        }
                        if($add) $cont_actions[] = $temp;
                    }
                }
            }*/

            // Pass a list of controllers to the view:
            $all_controllers[] = array("controller" => $controller, "allowed" => $allowed);

            // Check if we had a controller:
            if(!is_null($cont))
            {
                // Pass the selected controller to the view:
                $this->view->controller = $cont;

                // Check if this controller in the loop is the controller selected:
                if ($cont == $controller)
                {
                    // Add the controller + actions to the all rules:
                    $this->view->actions = $cont_actions;
                }
            }
        }

        // Pass the full controller list to the view:
        $this->view->controllers = $all_controllers;
        $this->view->controllers = $controllers;
    }   
}
	protected function _checkTcode($user_id,$password)
	{
		//		return simplexml_load_file('http://www.ksu.edu.tw/utility/login/IDCertification.aspx?Acc=' .
		return simplexml_load_file('http://cca.ksu.edu.tw/gateway.php?Acc=' .
				strtoupper($user_id) . '&Pwd=' . $password);
	}
	protected function _isXmlAuthWriteDB($xml,$user_id,$password) {
		Zend_Debug::dump($xm);
		$check = $xml->passed[0];
		if ($check=="true") {
			$chinese_name =
			(string) $xml->personal_data->name[0] .
			(string) $xml->personal_data->name[1] ;
			$english_name =	(string) $xml->personal_data->name[2]	;
			$i = 0;
			$position = 0;
			foreach ($xml->personal_identity->part as $part):
			$parts = (string)$part;
			$attrib = explode("|", $parts);
			$title[$i] =  $attrib[2] . $attrib[3] . $chinese_name . $attrib[4];
			if ($xml->personal_identity->part[$i]->attributes()->property == 'prime') {
				$position = $i;
				$prime_school = $attrib[0];
				$prime_type = $attrib[1];
				$prime_affiliation = $attrib[2];
				$prime_department = $attrib[3];
				$prime_role = $attrib[4];
				$prime_fulltime = $attrib[5];
			}
			$i++;
			//print $title . "<br/>";
			endforeach;
			
			$this->view->entries = $title;
				
			$user_mapper = new Application_Model_UserMapper();
			$user = new Application_Model_User();
			$user->setUser_id($user_id);			
			$user->setName($name);
			$user->setPassword($password);
			$user->setCname($chinese_name);
			$user->setEname($english_name);
			$user->setEmail((string)$xml->personal_data->email);
			$user->setPid((string)$xml->personal_data->id);
			$user->setBirthday((string)$xml->personal_data->birthday);
			$user->setRole((string)$prime_role);
			$user->setCreated(date('Y-m-d H:i:s'));
			$user->setSchool((string)$prime_school);
			$user->setType((string)$prime_type);
			$user->setAffiliation((string)$prime_affiliation);
			$user->setDepartment((string)$prime_department);
			$user->setPosition($position);
			$user->setFulltime((string)$prime_fulltime);
			$user->setLogindate(date('Y-m-d H:i:s'));
			$user_mapper->save($user); 
			/*
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
		*/
		} else {
			return false;
		}
		return true;
		
	}
		
}