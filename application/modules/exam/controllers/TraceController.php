<?php

class Campaign_TraceController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        
    }

    public function addAction()
    {
        // action body
		$this->_helper->layout()->setLayout('layout');
		$form = new Campaign_Form_Add();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Zend_Auth::getInstance()->hasIdentity()) {
					// We're authenticated! Redirect to the home page
					$this->view->message = '謝謝您的參與~ 請收EMAIL確認已登記參賽!';
				}
			}
		}
		$this->view->form = $form;
	
    }

    public function updateAction()
    {
        // action body
    }

    public function listAction()
    {
        // action body
    }

    public function groupAction()
    {
        // action body
    }


}









