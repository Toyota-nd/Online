<?php
//C:\AppServ\www\cca\application\modules\system\forms\Adduser.php

class System_Form_Adduser extends ZendX_JQuery_Form{ 

	public $checkboxDecorator =  
		array(
			'ViewHelper',
			'Errors',
			'Description',
			array('HtmlTag',array('tag' => 'td')),
			array('Label',array('tag' => 'td','class' =>'element')),
			array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
	public $elementDecorators = 
		array(
			'ViewHelper',
			'Errors',
			'Description',
			array('HtmlTag',array('tag' => 'td')),
			array('Label',array('tag' => 'td','class' =>'element')),
			array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
	public $buttonDecorators = 
		array(
			'ViewHelper',
			array('HtmlTag',array('tag' => 'td')),
			//array('Label',array('tag' => 'td')), NO LABELS FOR BUTTONS
			array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
	public $formJQueryElements = array(
			array('UiWidgetElement', array('tag' => '')), // it necessary to include for jquery elements
			array('Errors'),
			array('Description', array('tag' => 'span')),
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td', 'class' =>'element')),
			array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
	);
	public $formJQueryElements2 = array(
			array('UiWidgetElement', array('tag' => '')), // it necessary to include for jquery elements
			array('Errors'),
			array('Description', array('tag' => 'span')),
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td', 'class' =>'element')),
			array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
	);
	public function init()
	{
	    $this->setAction('');
	    $this->setMethod('post');
	
	    $this->addElement('text', 'user__user_id', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 12,
	    'label'      => USER_USER_ID,
		));

	    $this->addElement('text', 'user__name', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 10,
	    'label'      => USER_NAME,
		));

	    $this->addElement('text', 'user__password', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 40,
	    'label'      => USER_PASSWORD,
		));

	    $this->addElement('text', 'user__cname', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 6,
	    'label'      => USER_CNAME,
		));

	    $this->addElement('text', 'user__ename', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 20,
	    'label'      => USER_ENAME,
		));

	    $this->addElement('text', 'user__email', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 40,
	    'label'      => USER_EMAIL,
		));

	    $this->addElement('text', 'user__pid', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 45,
	    'label'      => USER_PID,
		));

		$elem = new ZendX_JQuery_Form_Element_DatePicker('user__birthday', array(
	    'decorators' => $this->formJQueryElements,
		'label' => USER_BIRTHDAY,
		'required' => false,
		'validators' => array('Date'),
		'jQueryParams' => array(
		'dateFormat' => 'yy-mm-dd',
		)));
		$this->addElement($elem);

	    $this->addElement('text', 'user__role', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 10,
	    'label'      => USER_ROLE,
		));

		$elem = new ZendX_JQuery_Form_Element_DatePicker('user__created', array(
	    'decorators' => $this->formJQueryElements,
		'label' => USER_CREATED,
		'required' => false,
		'validators' => array('Date'),
		'jQueryParams' => array(
		'dateFormat' => 'yy-mm-dd',
		)));
		$this->addElement($elem);

	    $this->addElement('text', 'user__school', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 20,
	    'label'      => USER_SCHOOL,
		));

	    $this->addElement('text', 'user__type', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 8,
	    'label'      => USER_TYPE,
		));

	    $this->addElement('text', 'user__affiliation', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 20,
	    'label'      => USER_AFFILIATION,
		));

	    $this->addElement('text', 'user__department', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 20,
	    'label'      => USER_DEPARTMENT,
		));

	    $this->addElement('text', 'user__position', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 3,
	    'label'      => USER_POSITION,
		));

	    $this->addElement('text', 'user__fulltime', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 8,
	    'label'      => USER_FULLTIME,
		));

	    $this->addElement('text', 'user__supervisor', array(
	    'decorators' => $this->elementDecorators,
	    'filters'    => array('StringTrim'),
	    'validators' => array(
	        array('StringLength', true, 
	        ),
	    ),
	    'required'   => false,
	    'size'   => 10,
	    'label'      => USER_SUPERVISOR,
		));

	/*
// Email
	        $this->addElement('text', 'email', array(
	            'decorators' => $this->elementDecorators,
	            'label'       => 'Email:',
	            'required'   => true,
	            'validators'  => array(
	                            'EmailAddress',
	                            ),
	            'attribs' =>   array(
	                                'id'=>'email_id',
	                            'class'=>'email_class'
	                            ),
	        ));
//Combox 
	        $this->addElement('select', 'country', array(
	            'decorators' => $this->elementDecorators,
	            'label'      => 'Country:',
	            'required'   => true,
	            'attribs' =>   array(
								'id'=>'country_id',
	                            ),
	            'multioptions'   => array(
	                            'ph' => 'Philippines',
	                            'us' => 'USA',
	                            ),
	        ));
//Radio button
	        $this->addElement('radio', 'gender', array(
	            'decorators' => $this->elementDecorators,
	            'label'      => 'Gender:',
	            'required'   => true,
	            'attribs' =>   array(
	                                'id'=>'gender_id',
	                            ),
	            'multioptions'   => array(
	                            'male' => 'Male',
	                            'female' => 'Female',
	                            ),
	        ));
//Checkbox 
	        $checkboxDecorator = 
				array(
				'ViewHelper',
				'Errors',
				array(array('data' => 'HtmlTag'), array('tag' => 'span', 'class' => 'element')),
				array('Label', array('tag' => 'dt'),
				array(array('row' => 'HtmlTag'), array('tag' => 'span')),
	                            ));
	        $this->addElement('checkbox', 'agreement', array(
	            'decorators' => $checkboxDecorator,
	            'label'       => 'Agreement:',
	            'required'   => true,
	        ));
	*/
	        $this->addElement('submit', 'formsubmit', array(
	    'decorators' => $this->buttonDecorators,
	    'label'       => 'OK',
	));
	}
	public function loadDefaultDecorators(){ 

	    $this->setDecorators(array(
	        'FormElements',
	        array('HtmlTag', array('tag' => 'table')),
	        'Form',
	        'Errors'
	    ));
	}

}