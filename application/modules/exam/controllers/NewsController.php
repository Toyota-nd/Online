<?php
//C:\AppServ\www\toyota\application\modules\exam\controllers\NewsController.php

class Exam_NewsController extends Zend_Controller_Action{ 

	protected $db;
	protected $user;
	public function init() {
	    /* Initialize action controller here */
	    $acl = new My_Controller_Helper_Acl();
		//$this->_helper->layout()->setLayout('exam_layout');
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
	public function addenrollmentAction() {
	    // action body
		$form = new Campaign_Form_Addenrollment();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$enrollment = new Campaign_Model_Enrollment();
					$enrollment_mapper = new Campaign_Model_EnrollmentMapper();
					$values = $form->getValues();
					$enrollment
					       ->setCampaign($values['campaign'])
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
		$form = new Campaign_Form_Updateenrollment();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$enrollment = new Campaign_Model_Enrollment();
					$enrollment_mapper = new Campaign_Model_EnrollmentMapper();
					$values = $form->getValues();
					$enrollment
					       ->setCampaign($values['campaign'])
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
		$form = new Campaign_Form_Deleteenrollment();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$enrollment = new Campaign_Model_Enrollment();
					$enrollment_mapper = new Campaign_Model_EnrollmentMapper();
					$values = $form->getValues();
					$enrollment
					       ->setCampaign($values['campaign'])
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
		$form = new Campaign_Form_Listenrollment();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$enrollment = new Campaign_Model_Enrollment();
					$enrollment_mapper = new Campaign_Model_EnrollmentMapper();
					$values = $form->getValues();
					$columns = array(
						'enrollment_id',
						'enrollment.name',
					);
					$enrollment_mapper = $enrollment_mapper
					//->_select($tables,$columns)
				->_select(array('enrollment' => 'enrollment'),$columns)
				->_join(array('campaign' => 'campaign'),'enrollment.campaign_id = campaign.campaign_id')
					->_where($form->getValues())
					->_order(array('enrollment.created'))
					//->_group(array('enrollment.name'),array('count(*) > 1'))
					//	->_limit(10, 1)
					;
					$sql = $enrollment_mapper->db->__toString();
					//Zend_Debug::dump($sql);
					$data = $enrollment_mapper->fetchAll($form->getValues());
					//$data = $enrollment_mapper->_fetchAll($enrollment_mapper);
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
	public function instantAction() {
	    // action body
		//$form = new Exam_Form_Instantnews();
		$request = $this->getRequest();
		//if ($request->isPost()) {
			//if ($form->isValid($request->getPost())) {
				//if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$q = $this->db->query("select name from news where user_id='" . $this->user->user_id . "'");
					$this->view->message = array();
					while ($rows = $q->fetch()) {
						$this->view->message[] = $rows['name'];
					}
				//}
			//}
		//}
		//$this->view->form = $form;
	}
};
