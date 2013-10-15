<?php
//C:\AppServ\www\cca\application\modules\system\controllers\UserController.php

class System_UserController extends Zend_Controller_Action{ 

	public function init() {
	    /* Initialize action controller here */
	    $acl = new My_Controller_Helper_Acl();
		$this->_helper->layout()->setLayout('system_layout');
	}
	public function indexAction() {
	    // action body
	}
	public function adduserAction() {
	    // action body
		$form = new System_Form_Adduser();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$user = new System_Model_User();
					$user_mapper = new System_Model_UserMapper();
					$values = $form->getValues();
					$user
					       ->setUser_id($values['user_id'])
					       ->setName($values['name'])
					       ->setPassword($values['password'])
					       ->setCname($values['cname'])
					       ->setEname($values['ename'])
					       ->setEmail($values['email'])
					       ->setPid($values['pid'])
					       ->setBirthday($values['birthday'])
					       ->setRole($values['role'])
					       ->setCreated($values['created'])
					       ->setSchool($values['school'])
					       ->setType($values['type'])
					       ->setAffiliation($values['affiliation'])
					       ->setDepartment($values['department'])
					       ->setPosition($values['position'])
					       ->setFulltime($values['fulltime'])
					       ->setSupervisor($values['supervisor'])
					       ;
					$user_mapper->save($user);
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
				}
			}
		}
		$this->view->form = $form;
	}
	public function updateuserAction() {
	    // action body
		$form = new System_Form_Updateuser();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$user = new System_Model_User();
					$user_mapper = new System_Model_UserMapper();
					$values = $form->getValues();
					$user
					       ->setUser_id($values['user_id'])
					       ->setName($values['name'])
					       ->setPassword($values['password'])
					       ->setCname($values['cname'])
					       ->setEname($values['ename'])
					       ->setEmail($values['email'])
					       ->setPid($values['pid'])
					       ->setBirthday($values['birthday'])
					       ->setRole($values['role'])
					       ->setCreated($values['created'])
					       ->setSchool($values['school'])
					       ->setType($values['type'])
					       ->setAffiliation($values['affiliation'])
					       ->setDepartment($values['department'])
					       ->setPosition($values['position'])
					       ->setFulltime($values['fulltime'])
					       ->setSupervisor($values['supervisor'])
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
		$form = new System_Form_Deleteuser();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$user = new System_Model_User();
					$user_mapper = new System_Model_UserMapper();
					$values = $form->getValues();
					$user
					       ->setUser_id($values['user_id'])
					       ->setName($values['name'])
					       ->setPassword($values['password'])
					       ->setCname($values['cname'])
					       ->setEname($values['ename'])
					       ->setEmail($values['email'])
					       ->setPid($values['pid'])
					       ->setBirthday($values['birthday'])
					       ->setRole($values['role'])
					       ->setCreated($values['created'])
					       ->setSchool($values['school'])
					       ->setType($values['type'])
					       ->setAffiliation($values['affiliation'])
					       ->setDepartment($values['department'])
					       ->setPosition($values['position'])
					       ->setFulltime($values['fulltime'])
					       ->setSupervisor($values['supervisor'])
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
		$form = new System_Form_Listuser();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$user = new System_Model_User();
					$user_mapper = new System_Model_UserMapper();
					$values = $form->getValues();
					/*	$campaign_mapper = $campaign_mapper

								->_where($form->getValues())
								//->_order(array('user.created'))
								//->_group(array('user.name'),array('count(*) > 1'))
								;
						$id_list = $user_mapper->fetchArray($form->getValues()); */
						$tables = array(
									'user' => 'user',

									);
						$columns = array(
									'user_id',
									'user.name',
									);
						$user_mapper = $user_mapper
								->_select($tables,$columns)
								->_where($form->getValues())
								->_order(array('user.created'))
								->_group(array('user.name'),array('count(*) > 1'))
							//	->_limit(10, 1)
								;
						$sql = $user_mapper->db->__toString();
						//Zend_Debug::dump($sql);
						//$data = $user_mapper->fetchAll($form->getValues());
						$data = $user_mapper->_fetchAll($user_mapper);
						$this->view->paginator = 
							Zend_Paginator::factory($data)
							->setItemCountPerPage(10)
							->setCurrentPageNumber($this->_getParam('page',1));
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
				}
			}
		}
		$this->view->form = $form;
	}
	public function groupuserAction() {
	    // action body
		$form = new System_Form_Groupuser();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$user = new System_Model_User();
					$user_mapper = new System_Model_UserMapper();
					$values = $form->getValues();
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
				}
			}
		}
		$this->view->form = $form;
	}
};
