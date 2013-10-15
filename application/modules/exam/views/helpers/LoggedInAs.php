<?php
class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract 
{
    public function loggedInAs ()
    {
        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {
            $user = $auth->getIdentity();
            $logoutUrl = $this->view->url(array('module' =>'default','controller'=>'auth', 'action'=>'logout'), null, true);
			$mytitle = $user->cname . $user->role;
            return '歡迎 ' . $mytitle . '<br>' . '<span style="color: #FFFF00;">按此</span><span style="color: #FFFF00;"><a href="'.$logoutUrl.'">登出</a></span>';
        } 

        $request = Zend_Controller_Front::getInstance()->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        if($controller == 'auth' && $action == 'index') {
            return '登入資訊';
        }
        $loginUrl = $this->view->url(array('module' => 'default', 'controller'=>'auth', 'action'=>'index'));
        return '<a href="'.$loginUrl.'">按此登入</a>';
    }
    public function inPrivate ()
    {
	/*
        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {
            return true;
        } 
    */
        return true;
    }
}
