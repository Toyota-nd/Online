<?php

class Application_Form_Login extends Zend_Form
{

/*
    public function init()
    {
        $this->setName("login");
        $this->setMethod('post');

        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim', 'StringToUpper'),
            'validators' => array(
                array('StringLength', false, array(0, 10)),
            ),
            'required'   => true,
            'size'   => 10,
            'label'      => '帳號',
        ));

        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 10)),
            ),
            'required'   => true,
            'size'   => 11,
            'label'      => '密碼',
        ));

        $this->addElement('submit', 'login', array(
            'required' => false,
            'ignore'   => true,
            'label'    => '登入',
        ));		
    }

*/

    public $checkboxDecorator = array(
                                    'ViewHelper',
                                    'Errors',
                                    'Description',
                                    array('HtmlTag',array('tag' => 'td')),
                                    array('Label',array('tag' => 'td','class' =>'element')),
                                    array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
    public $elementDecorators = array(
                                    'ViewHelper',
                                    'Errors',
                                    'Description',
                                    array('HtmlTag',array('tag' => 'td')),
                                    array('Label',array('tag' => 'td','class' =>'element')),
                                    array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
    public $buttonDecorators = array(
                                    'ViewHelper',
                                    array('HtmlTag',array('tag' => 'td')),
                                    //array('Label',array('tag' => 'td')), NO LABELS FOR BUTTONS
                                    array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
    public function init()
    {
        $this->setAction('');
        $this->setMethod('post');

/*		
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
 
        $this->addElement('text', 'age', array(
            'decorators' => $this->elementDecorators,
            'label'      => 'Age:',
            'required'   => true,
        ));
 
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
*/ 
        $this->addElement('text', 'user_id', array(
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim', 'StringToUpper'),
            'validators' => array(
                array('StringLength', false, array(0, 40)),
            ),
            'required'   => true,
            'size'   => 20,
            'title'      => '輸入帳號、電子郵件或身份證號均可',
            'label'      => '帳號:',
        ));
		
        $this->addElement('password', 'password', array(
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 40)),
            ),
            'required'   => true,
            'size'   => 20,
            'label'      => '密碼:',
        ));		
/* 
        $this->addElement('text', 'firstname', array(
            'decorators' => $this->elementDecorators,
            'label'      => 'First Name:',
            'required'   => true,
        ));
 
        $this->addElement('text', 'lastname', array(
            'decorators' => $this->elementDecorators,
            'label'       => 'Last Name:',
            'required'   => true,
        ));
 
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
 
        $checkboxDecorator = array(
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
/* 
        $this->addElement('submit', 'login', array(
            'decorators' => $this->buttonDecorators,
            'label'       => '登入',
        ));
*/
    }
    public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
            'Form',
            'Errors'
        ));
    }
	
	

}

