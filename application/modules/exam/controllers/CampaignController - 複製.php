<?php
//C:\AppServ\www\cca\application\modules\campaign\controllers\CampaignController.php

class Campaign_CampaignController extends Zend_Controller_Action{ 

	public function init() {
	    /* Initialize action controller here */
		$this->_helper->layout()->setLayout('campaign_layout');
		//Zend_Dojo::enableView($this->view);
	}
	public function indexAction() {
	    // action body
	}
	public function addcampaignAction() {
	    // action body
		$form = new Campaign_Form_Addcampaign();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
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
				}
			}
		}
		$this->view->form = $form;
	}
	public function updatecampaignAction() {
	    // action body
		$form = new Campaign_Form_Updatecampaign();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
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
				}
			}
		}
		$this->view->form = $form;
	}
	public function deletecampaignAction() {
	    // action body
		$form = new Campaign_Form_Deletecampaign();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
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
				}
			}
		}
		$this->view->form = $form;
	}
    public function  viewAction()
    {
    }
    /*
    public function  recordsAction()
    {
		$campaign_mapper = new Campaign_Model_CampaignMapper();
		$data = $campaign_mapper->_fetchAll();
		$dojoData= new Zend_Dojo_Data('campaign_id',$data,'campaign_id');
		$jdata = $dojoData->toJson();
		echo $jdata;
		//Zend_Debug::dump($jdata);
		exit();
    }
	*/
	public function listcampaignAction() {
	    // action body

		$form = new Campaign_Form_Listcampaign();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					$campaign_mapper = new Campaign_Model_CampaignMapper();
					$campaign_mapper = $campaign_mapper
							->_select(
									array(
									'campaign',
									'enrollment',
									))
							->_where($form->getValues())
							->_order(array('create'))
							->_group(array('name'))
							->_having('count(*) > 1'))
							;
					$sql = $campaign_mapper->select->__toString();
					Zend_Debug::dump($sql);

					$data = $campaign_mapper->fetchAll($form->getValues());
					$this->view->paginator = 
						Zend_Paginator::factory($data)
						->setItemCountPerPage(10)
						->setCurrentPageNumber($this->_getParam('page',1));
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
				}
			}
		}
					
/*		
		if ($request->isPost()) {
//			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
					$campaign = new Campaign_Model_Campaign();
					$campaign_mapper = new Campaign_Model_CampaignMapper();
					$values = $form->getValues();
					//Zend_Debug::dump($campaign);
					$this->view->paginator = 
					$campaign_mapper->fetchAll(
						$campaign->setCampaign($values['campaign_id'],1,10
						));
					
					$this->view->message = '<span color="#FF0000">To submit successfully!</span>';
				} 
//			}
		}
*/		
		$this->view->form = $form;
	}
	public function groupcampaignAction() {
	    // action body
		$form = new Campaign_Form_Groupcampaign();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated and to write any code where you want!
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
				}
			}
		}
		$this->view->form = $form;
	}
};
