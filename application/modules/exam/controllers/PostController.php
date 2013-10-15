<?php

class Exam_PostController extends Zend_Controller_Action
{
	protected $db;
	protected $user;

    public function init()
    {
        /* Initialize action controller here */
     	$this->_helper->layout()->setLayout('exam_layout');
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
	
	public function newsAction()
    {
	
    }

    public function latestAction()
    {

    }	
	
	public function welcomeAction()
    {

    }	

}

