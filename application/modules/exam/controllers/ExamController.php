<?php

class Exam_ExamController extends Zend_Controller_Action
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
		$form = new Exam_Form_Generic();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					$values = $form->getValues();
					//$this->view->debugLog($request,0);	
				    $this->view->exam_id = $this->_request->getParam('exam_id');
					$examid = $this->view->exam_id;
					$examid = 11;
					$sql_command = "CALL randpicker($examid, @questions_count);";
					$this->view->debugLog($sql_command,0);	
					$this->db->query($sql_command);
					// We're authenticated and to write any code where you want!
				}
			}
		}
		$this->view->form = $form;
	
    } 	
	
	public function step2Action()
    {
		$form = new Exam_Form_Generic();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					$values = $form->getValues();
					//$this->view->debugLog($request,0);	
				    $this->view->exam_id = $this->_request->getParam('exam_id');
					$examid = $this->view->exam_id;
					$examid = 11;
					$sql_command = "CALL randpicker($examid, @questions_count);";
					$this->view->debugLog($sql_command,0);	
					$this->db->query($sql_command);
					// We're authenticated and to write any code where you want!
				}
			}
		}
		$this->view->form = $form;
	
    }
	
	public function step3Action()
    {
		$form = new Exam_Form_Addexampaper();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					$values = $form->getValues();
					//$this->view->debugLog($request,0);	
				    //$this->view->exam_id = $this->_request->getParam('exam_id');
					$examid = $this->view->exam_id;
					$examid = 11;
					$userid = $this->user->user_id;
					$db = 'toyota';
					$table = 'exampaper';
					$sql_command = "Insert into $db.$table 
					(name, supervisor, exam_id,
					user_id, department_id, remainder, limittime,
					score, title, mark) values 
					('第五次考試',0,$examid,'$userid',17,3600,3600,default,'',2);";
					$this->view->debugLog($sql_command,0);	
					$this->db->query($sql_command);
					// We're authenticated and to write any code where you want!
				}
			}
		}
		$this->view->form = $form;
	
    }
	public function step4Action()
    {
		$form = new Exam_Form_Generic();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					$values = $form->getValues();
					//$this->view->debugLog($request,0);	
				    $this->view->exam_id = $this->_request->getParam('exam_id');
					$examid = $this->view->exam_id;
					$examid = 11;
					$sql_command = "CALL randpicker($examid, @questions_count);";
					$this->view->debugLog($sql_command,0);	
					$this->db->query($sql_command);
					// We're authenticated and to write any code where you want!
				}
			}
		}
		$this->view->form = $form;
	
    }
	public function monitorAction()
    {
		$form = new Exam_Form_Generic();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					$values = $form->getValues();
				    $this->view->exam_id = $this->_request->getParam('exam_id');
					$examid = $this->view->exam_id;
					$sql_command = "update exampaper set mark = 4 where exam_id = $examid and mark < 4;";
					$this->view->debugLog($sql_command,1);	
					$this->db->query($sql_command);
					// We're authenticated and to write any code where you want!
				}
			}
		}
		$this->view->form = $form;
	
    }
	public function remainderAction()
    {
		$form = new Exam_Form_Generic();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					$values = $form->getValues();
				    $this->view->exam_id = $this->_request->getParam('exam_id');
					$examid = $this->view->exam_id;
					$sql_command = "update exampaper set mark = 4 where exam_id = $examid and mark < 4;";
					$this->view->debugLog($sql_command,1);	
					//$this->db->query($sql_command);
					// We're authenticated and to write any code where you want!
				}
			}
		}
		$this->view->form = $form;
	
    }
	public function limittimeAction()
    {
	
    }


}

