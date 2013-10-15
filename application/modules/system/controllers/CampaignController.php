<?php
//C:\AppServ\www\cca\application\modules\system\controllers\CampaignController.php

class System_CampaignController extends Zend_Controller_Action{ 

	public function init() {
	    /* Initialize action controller here */
	    $acl = new My_Controller_Helper_Acl();
		$this->_helper->layout()->setLayout('system_layout');
	}
	public function indexAction() {
	    // action body
	}
	public function addcampaignAction() {
	    // action body
		$form = new System_Form_Addcampaign();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$campaign = new System_Model_Campaign();
					$campaign_mapper = new System_Model_CampaignMapper();
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
				}
			}
		}
		$this->view->form = $form;
	}
	public function updatecampaignAction() {
	    // action body
		$form = new System_Form_Updatecampaign();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$campaign = new System_Model_Campaign();
					$campaign_mapper = new System_Model_CampaignMapper();
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
				}
			}
		}
		$this->view->form = $form;
	}
	public function deletecampaignAction() {
	    // action body
		$form = new System_Form_Deletecampaign();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$campaign = new System_Model_Campaign();
					$campaign_mapper = new System_Model_CampaignMapper();
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
				}
			}
		}
		$this->view->form = $form;
	}
	public function listcampaignAction() {
	    // action body
		$form = new System_Form_Listcampaign();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$campaign = new System_Model_Campaign();
					$campaign_mapper = new System_Model_CampaignMapper();
					$values = $form->getValues();
					/*	$campaign_mapper = $campaign_mapper
								->_select(array('campaign' => 'campaign'),array('campaign_id'))
								->_where($form->getValues())
								//->_order(array('campaign.created'))
								//->_group(array('campaign.name'),array('count(*) > 1'))
								;
						$id_list = $campaign_mapper->fetchArray($form->getValues()); */
						$tables = array(
									'campaign' => 'campaign',
									'' => '',

									'' => '',

									);
						$columns = array(
									'campaign_id',
									'campaign.name',
									'._id'
									);
						$campaign_mapper = $campaign_mapper
								->_select($tables,$columns)
								->_where($form->getValues())
								->_order(array('campaign.created'))
								->_group(array('campaign.name'),array('count(*) > 1'))
							//	->_limit(10, 1)
								;
						$sql = $campaign_mapper->db->__toString();
						//Zend_Debug::dump($sql);
						//$data = $campaign_mapper->fetchAll($form->getValues());
						$data = $campaign_mapper->_fetchAll($campaign_mapper);
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
	public function groupcampaignAction() {
	    // action body
		$form = new System_Form_Groupcampaign();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$campaign = new System_Model_Campaign();
					$campaign_mapper = new System_Model_CampaignMapper();
					$values = $form->getValues();
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
				}
			}
		}
		$this->view->form = $form;
	}
};
