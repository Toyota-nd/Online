<?php

class Application_Model_Email extends Zend_Email
{
/*
    public function noticeUser() {

        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {
            $username = $auth->getIdentity()->username;
            $logoutUrl = $this->view->url(array('controller'=>'auth', 'action'=>'logout'), null, true);
			$users_mapper = new Application_Model_UsersMapper();
			$users = new Application_Model_Users();
			$pos = $users_mapper->getDbTable()->find($username);
			$mytitle = $pos['data']['cname'] . $pos['data']['position'];
			//Prepare email

			$email = $pos['data']['email'];
			//$subject = "=?UTF-8?B?".base64_encode('�w�� ' . $mytitle)."?=" ;
			$subject = '�w�� ' . $mytitle;
			$message = $mytitle . '<span style="color=#FF00000">�z�n:</span><br>�п�J:<input type="text" size="10"/><br>';
			$mail = new Zend_Mail('utf-8');
			$mail->addTo($email);
			$mail->setSubject($subject);
			$mail->setBodyHtml($message,'utf-8',Zend_Mime::ENCODING_BASE64);
			$mail->setFrom('cca01@mail.ksu.edu.tw', '�X�s��ޤj�ǳ��W���عq�H�зs�����v�ɺ޲z�t��');
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
		}
	}
*/	
}

