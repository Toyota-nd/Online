<?php

class Exam_ExamController extends Zend_Controller_Action
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
		}

    }

    public function indexAction()
    {

    }
	
    public function accountAction()
    {
	
    }  
	public function addexamAction()
    {
	
    }  
	
	public function newsAction()
    {
	
    }  
	public function listAction()
    {
	
    }  
	public function step1Action()
    {
	
    } 	
	
	public function step2Action()
    {
	
    }
	
	public function step3Action()
    {
	
    }
	public function step4Action()
    {
	
    }
	public function limittimeAction()
    {
	
    }

}

