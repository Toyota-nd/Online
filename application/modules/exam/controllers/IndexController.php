<?php

class Exam_IndexController extends Zend_Controller_Action
{
	protected $db;
	protected $user;

    public function init()
    {
        /* Initialize action controller here */
     	$this->_helper->layout()->setLayout('exam_layout');
		$this->view->module = $this->_request->getModuleName();
		$this->view->controller = $this->_request->getControllerName();
		$this->view->action = $this->_request->getActionName();
		$this->db = Zend_Controller_Front::getInstance()
			->getParam("bootstrap")
			->getPluginResource("db")
			->getDbAdapter()
			;
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$this->user = $auth->getIdentity();
			$this->view->user = $this->user;
			$this->view->status = 'Login OK';
		} else {
			$this->view->status = 'Not Login';
		}
		
    }

    public function indexAction()
    {

    }
	
    public function homeAction()
    {
		$msgs = array("k1"=>"即時消息1~from exam/index/home","k2"=>"即時消息2","k3"=>"test");
		$this->view->message = array();
		foreach($msgs as $key => $val) {
			$this->view->message[$key] = $val; 
		}

    }

    public function onlineAction()
    {
		$msgs = array("k1"=>"即時消息1~from exam/index/online","k2"=>"即時消息2","k3"=>"test");
		$this->view->message = array();
		foreach($msgs as $key => $val) {
			$this->view->message[$key] = $val; 
		}
    }

	public function permissionsAction()
    {

    }	

	public function mockAction()
    {

    }	

}

