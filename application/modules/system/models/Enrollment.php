<?php
//C:\AppServ\www\cca\application\modules\system\models\Enrollment.php

class System_Model_Enrollment{ 

	protected $_enrollment_id;
	protected $_name;
	protected $_myabstract;
	protected $_type;
	protected $_status;
	protected $_agreement;
	protected $_created;
	protected $_lastupdate;
	protected $_campaign_id;
	protected $_users_id;
	protected $_students_id;
	protected $_group_id;
	protected $_workflow_id;
	protected $_myresource_id;
	protected $_event_id;
	protected $_character_id;
	protected $_workpackage_id;
	protected $_calendar_id;
	protected $_member_id;
	protected $_survey_id;

	public function __construct(array $options = null)
	{
	    if (is_array($options)) {
	        $this->setOptions($options);
	    }
	}
	public function __set($name, $value)
	{
	    $method = 'set' . $name;
	    if (('mapper' == $name) || !method_exists($this, $method)) {
	        throw new Exception('Invalid enrollment property'); 
	   }
	    $this->$method($value);
	}
	public function __get($name)
	{
	    $method = 'get' . $name;
	    if (('mapper' == $name) || !method_exists($this, $method)) {
	        throw new Exception('Invalid enrollment property'); 
	    };
	    return $this->$method();
	}
	public function setOptions(array $options)
	{
	    $methods = get_class_methods($this);
	    foreach ($options as $key => $value) {
	        $method = 'set' . ucfirst($key);
	        if (in_array($method, $methods)) {
	            $this->$method($value);
	        }
	    }
	    return $this;
	}
	

	public function setEnrollment_id($text){ 
		$this->_enrollment_id=$text;
	return $this;
	}

	public function getEnrollment_id(){ 
	return $this->_enrollment_id;
	}

	public function setName($text){ 
		$this->_name=$text;
	return $this;
	}

	public function getName(){ 
	return $this->_name;
	}

	public function setMyabstract($text){ 
		$this->_myabstract=$text;
	return $this;
	}

	public function getMyabstract(){ 
	return $this->_myabstract;
	}

	public function setType($text){ 
		$this->_type=$text;
	return $this;
	}

	public function getType(){ 
	return $this->_type;
	}

	public function setStatus($text){ 
		$this->_status=$text;
	return $this;
	}

	public function getStatus(){ 
	return $this->_status;
	}

	public function setAgreement($text){ 
		$this->_agreement=$text;
	return $this;
	}

	public function getAgreement(){ 
	return $this->_agreement;
	}

	public function setCreated($text){ 
		$this->_created=$text;
	return $this;
	}

	public function getCreated(){ 
	return $this->_created;
	}

	public function setLastupdate($text){ 
		$this->_lastupdate=$text;
	return $this;
	}

	public function getLastupdate(){ 
	return $this->_lastupdate;
	}

	public function setCampaign_id($text){ 
		$this->_campaign_id=$text;
	return $this;
	}

	public function getCampaign_id(){ 
	return $this->_campaign_id;
	}

	public function setUsers_id($text){ 
		$this->_users_id=$text;
	return $this;
	}

	public function getUsers_id(){ 
	return $this->_users_id;
	}

	public function setStudents_id($text){ 
		$this->_students_id=$text;
	return $this;
	}

	public function getStudents_id(){ 
	return $this->_students_id;
	}

	public function setGroup_id($text){ 
		$this->_group_id=$text;
	return $this;
	}

	public function getGroup_id(){ 
	return $this->_group_id;
	}

	public function setWorkflow_id($text){ 
		$this->_workflow_id=$text;
	return $this;
	}

	public function getWorkflow_id(){ 
	return $this->_workflow_id;
	}

	public function setMyresource_id($text){ 
		$this->_myresource_id=$text;
	return $this;
	}

	public function getMyresource_id(){ 
	return $this->_myresource_id;
	}

	public function setEvent_id($text){ 
		$this->_event_id=$text;
	return $this;
	}

	public function getEvent_id(){ 
	return $this->_event_id;
	}

	public function setCharacter_id($text){ 
		$this->_character_id=$text;
	return $this;
	}

	public function getCharacter_id(){ 
	return $this->_character_id;
	}

	public function setWorkpackage_id($text){ 
		$this->_workpackage_id=$text;
	return $this;
	}

	public function getWorkpackage_id(){ 
	return $this->_workpackage_id;
	}

	public function setCalendar_id($text){ 
		$this->_calendar_id=$text;
	return $this;
	}

	public function getCalendar_id(){ 
	return $this->_calendar_id;
	}

	public function setMember_id($text){ 
		$this->_member_id=$text;
	return $this;
	}

	public function getMember_id(){ 
	return $this->_member_id;
	}

	public function setSurvey_id($text){ 
		$this->_survey_id=$text;
	return $this;
	}

	public function getSurvey_id(){ 
	return $this->_survey_id;
	}

}