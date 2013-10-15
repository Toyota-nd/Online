<?php
//C:\AppServ\www\cca\application\modules\system\controllers\EnrollmentController.php

class System_EnrollmentController extends Zend_Controller_Action{ 

	public function init() {
	    /* Initialize action controller here */
	    $acl = new My_Controller_Helper_Acl();
		$this->_helper->layout()->setLayout('system_layout');
	}
	public function indexAction() {
	    // action body
	}
	public function addenrollmentAction() {
	    // action body
		$form = new System_Form_Addenrollment();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$enrollment = new System_Model_Enrollment();
					$enrollment_mapper = new System_Model_EnrollmentMapper();
					$values = $form->getValues();
					$enrollment
					       ->setEnrollment_id($values['enrollment_id'])
					       ->setName($values['name'])
					       ->setMyabstract($values['myabstract'])
					       ->setType($values['type'])
					       ->setStatus($values['status'])
					       ->setAgreement($values['agreement'])
					       ->setCreated($values['created'])
					       ->setLastupdate($values['lastupdate'])
					       ->setCampaign_id($values['campaign_id'])
					       ->setUsers_id($values['users_id'])
					       ->setStudents_id($values['students_id'])
					       ->setGroup_id($values['group_id'])
					       ->setWorkflow_id($values['workflow_id'])
					       ->setMyresource_id($values['myresource_id'])
					       ->setEvent_id($values['event_id'])
					       ->setCharacter_id($values['character_id'])
					       ->setWorkpackage_id($values['workpackage_id'])
					       ->setCalendar_id($values['calendar_id'])
					       ->setMember_id($values['member_id'])
					       ->setSurvey_id($values['survey_id'])
					       ;
					$enrollment_mapper->save($enrollment);
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
				}
			}
		}
		$this->view->form = $form;
	}
	public function updateenrollmentAction() {
	    // action body
		$form = new System_Form_Updateenrollment();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$enrollment = new System_Model_Enrollment();
					$enrollment_mapper = new System_Model_EnrollmentMapper();
					$values = $form->getValues();
					$enrollment
					       ->setEnrollment_id($values['enrollment_id'])
					       ->setName($values['name'])
					       ->setMyabstract($values['myabstract'])
					       ->setType($values['type'])
					       ->setStatus($values['status'])
					       ->setAgreement($values['agreement'])
					       ->setCreated($values['created'])
					       ->setLastupdate($values['lastupdate'])
					       ->setCampaign_id($values['campaign_id'])
					       ->setUsers_id($values['users_id'])
					       ->setStudents_id($values['students_id'])
					       ->setGroup_id($values['group_id'])
					       ->setWorkflow_id($values['workflow_id'])
					       ->setMyresource_id($values['myresource_id'])
					       ->setEvent_id($values['event_id'])
					       ->setCharacter_id($values['character_id'])
					       ->setWorkpackage_id($values['workpackage_id'])
					       ->setCalendar_id($values['calendar_id'])
					       ->setMember_id($values['member_id'])
					       ->setSurvey_id($values['survey_id'])
					       ;
					$enrollment_mapper->save($enrollment);
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
				}
			}
		}
		$this->view->form = $form;
	}
	public function deleteenrollmentAction() {
	    // action body
		$form = new System_Form_Deleteenrollment();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$enrollment = new System_Model_Enrollment();
					$enrollment_mapper = new System_Model_EnrollmentMapper();
					$values = $form->getValues();
					$enrollment
					       ->setEnrollment_id($values['enrollment_id'])
					       ->setName($values['name'])
					       ->setMyabstract($values['myabstract'])
					       ->setType($values['type'])
					       ->setStatus($values['status'])
					       ->setAgreement($values['agreement'])
					       ->setCreated($values['created'])
					       ->setLastupdate($values['lastupdate'])
					       ->setCampaign_id($values['campaign_id'])
					       ->setUsers_id($values['users_id'])
					       ->setStudents_id($values['students_id'])
					       ->setGroup_id($values['group_id'])
					       ->setWorkflow_id($values['workflow_id'])
					       ->setMyresource_id($values['myresource_id'])
					       ->setEvent_id($values['event_id'])
					       ->setCharacter_id($values['character_id'])
					       ->setWorkpackage_id($values['workpackage_id'])
					       ->setCalendar_id($values['calendar_id'])
					       ->setMember_id($values['member_id'])
					       ->setSurvey_id($values['survey_id'])
					       ;
					$enrollment_mapper->save($enrollment);
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
				}
			}
		}
		$this->view->form = $form;
	}
	public function listenrollmentAction() {
	    // action body
		$form = new System_Form_Listenrollment();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$enrollment = new System_Model_Enrollment();
					$enrollment_mapper = new System_Model_EnrollmentMapper();
					$values = $form->getValues();
					/*	$campaign_mapper = $campaign_mapper
								->_select(array('enrollment' => 'enrollment'),array('enrollment_id'))
								->_where($form->getValues())
								//->_order(array('enrollment.created'))
								//->_group(array('enrollment.name'),array('count(*) > 1'))
								;
						$id_list = $enrollment_mapper->fetchArray($form->getValues()); */
						$tables = array(
									'enrollment' => 'enrollment',
									'' => '',

									'' => '',

									);
						$columns = array(
									'enrollment_id',
									'enrollment.name',
									'._id'
									);
						$enrollment_mapper = $enrollment_mapper
								->_select($tables,$columns)
								->_where($form->getValues())
								->_order(array('enrollment.created'))
								->_group(array('enrollment.name'),array('count(*) > 1'))
							//	->_limit(10, 1)
								;
						$sql = $enrollment_mapper->db->__toString();
						//Zend_Debug::dump($sql);
						//$data = $enrollment_mapper->fetchAll($form->getValues());
						$data = $enrollment_mapper->_fetchAll($enrollment_mapper);
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
	public function groupenrollmentAction() {
	    // action body
		$form = new System_Form_Groupenrollment();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$enrollment = new System_Model_Enrollment();
					$enrollment_mapper = new System_Model_EnrollmentMapper();
					$values = $form->getValues();
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
				}
			}
		}
		$this->view->form = $form;
	}
};
