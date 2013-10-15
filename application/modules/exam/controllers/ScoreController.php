<?php

class Exam_ScoreController extends Zend_Controller_Action
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
	
	public function achievementAction()
    {
	
    }  
	public function radarchartAction() {
		$form = new Exam_Form_Generic();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					$values = $form->getValues();
					
					//$this->view->debugLog($request,0);	
				    $this->view->exampaper_id = $this->_request->getParam('exampaper_id');
					// We're authenticated and to write any code where you want!
/*
					$campaign = new Campaign_Model_Campaign();
					$campaign_mapper = new Campaign_Model_CampaignMapper();
					$values = $form->getValues();
					$campaign
					       ->setCampaign_id($values['campaign_id'])
					       ->setName($values['name'])
					       ->setYear($values['year'])
					       ->setEnrollment($values['enrollment'])
					       ->setFinalist($values['finalist'])
					       ->setWinner($values['winner'])
					       ->setSubmit($values['submit'])
					       ->setDue($values['due'])
					       ->setAccept($values['accept'])
					       ->setPublished($values['published'])
					       ->setCreated($values['created'])
					       ;
					$campaign_mapper->save($campaign);
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
*/					
				}
			}
		}
		$this->view->form = $form;
	
    }  
	public function rankAction()
    {
	
    }  
	
	public function inqueryscoreAction()
    {
	
    }  
	
	public function portfolioAction()
    {
	
    }  
	
	public function statisticAction()
    {
	
    }  
}

