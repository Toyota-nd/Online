<?php
//C:\AppServ\www\toyota\application\modules\exam\controllers\UserController.php

class Exam_UserController extends Zend_Controller_Action{ 

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

	public function indexAction() {
	    // action body
	}
	public function adduserAction() {
	    // action body
		/*
		$form = new Exam_Form_Adduser();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$user = new Exam_Model_User();
					$user_mapper = new Exam_Model_UserMapper();
					$values = $form->getValues();
					$user
					       ->setUser_id($values['user_id'])
					       ->setName($values['name'])
					       ;
					$user_mapper->save($user);
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
				}
			}
		}
		$this->view->form = $form;
		*/
		$this->view->message = '<span color="#FF0000">To submit successfully!!!!</span>';
		
	}
	public function updateuserAction() {
	    // action body
		$form = new Exam_Form_Updateuser();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$user = new Exam_Model_User();
					$user_mapper = new Exam_Model_UserMapper();
					$values = $form->getValues();
					$user
					       ->setUser_id($values['user_id'])
					       ->setName($values['name'])
					       ;
					$user_mapper->save($user);
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
				}
			}
		}
		$this->view->form = $form;
	}
	public function deleteuserAction() {
	    // action body
		$form = new Exam_Form_Deleteuser();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$user = new Exam_Model_User();
					$user_mapper = new Exam_Model_UserMapper();
					$values = $form->getValues();
					$user
					       ->setUser_id($values['user_id'])
					       ->setName($values['name'])
					       ;
					$user_mapper->save($user);
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
				}
			}
		}
		$this->view->form = $form;
	}
	public function listuserAction() {
	    // action body
		$form = new Exam_Form_Generic();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
				//	$user = new Exam_Model_User();
				//	$user_mapper = new Exam_Model_UserMapper();
					$values = $form->getValues();
					/*
					$columns = array(
						'user_id',
						'user.name',
					);
					$user_mapper = $user_mapper
					//->_select($tables,$columns)
				->_select(array('enrollment' => 'enrollment'),$columns)
				->_join(array('user' => 'user'),'enrollment.user_id = user.user_id')
					->_where($form->getValues())
					->_order(array('user.created'))
					//->_group(array('user.name'),array('count(*) > 1'))
					//	->_limit(10, 1)
					;
					$sql = $user_mapper->db->__toString();
				//	Zend_Debug::dump($sql);
					$data = $user_mapper->fetchAll($form->getValues());
					//$data = $user_mapper->_fetchAll($user_mapper);
					$this->view->paginator = 
					Zend_Paginator::factory($data)
					->setItemCountPerPage(10)
					->setCurrentPageNumber($this->_getParam('page',1));
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
					*/
				}
			}
		}
		$this->view->form = $form;
	}
	public function groupuserAction() {
	    // action body
		$form = new Exam_Form_Generic();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					//$user = new Exam_Model_User();
					//$user_mapper = new Exam_Model_UserMapper();
					$values = $form->getValues();
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
				}
			}
		}
		$this->view->form = $form;
	}
};
