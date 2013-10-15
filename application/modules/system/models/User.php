<?php
//C:\AppServ\www\cca\application\modules\system\models\User.php

class System_Model_User{ 

	protected $_user_id;
	protected $_name;
	protected $_password;
	protected $_cname;
	protected $_ename;
	protected $_email;
	protected $_pid;
	protected $_birthday;
	protected $_role;
	protected $_created;
	protected $_school;
	protected $_type;
	protected $_affiliation;
	protected $_department;
	protected $_position;
	protected $_fulltime;
	protected $_supervisor;

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
	        throw new Exception('Invalid user property'); 
	   }
	    $this->$method($value);
	}
	public function __get($name)
	{
	    $method = 'get' . $name;
	    if (('mapper' == $name) || !method_exists($this, $method)) {
	        throw new Exception('Invalid user property'); 
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
	

	public function setUser_id($text){ 
		$this->_user_id=$text;
	return $this;
	}

	public function getUser_id(){ 
	return $this->_user_id;
	}

	public function setName($text){ 
		$this->_name=$text;
	return $this;
	}

	public function getName(){ 
	return $this->_name;
	}

	public function setPassword($text){ 
		$this->_password=$text;
	return $this;
	}

	public function getPassword(){ 
	return $this->_password;
	}

	public function setCname($text){ 
		$this->_cname=$text;
	return $this;
	}

	public function getCname(){ 
	return $this->_cname;
	}

	public function setEname($text){ 
		$this->_ename=$text;
	return $this;
	}

	public function getEname(){ 
	return $this->_ename;
	}

	public function setEmail($text){ 
		$this->_email=$text;
	return $this;
	}

	public function getEmail(){ 
	return $this->_email;
	}

	public function setPid($text){ 
		$this->_pid=$text;
	return $this;
	}

	public function getPid(){ 
	return $this->_pid;
	}

	public function setBirthday($text){ 
		$this->_birthday=$text;
	return $this;
	}

	public function getBirthday(){ 
	return $this->_birthday;
	}

	public function setRole($text){ 
		$this->_role=$text;
	return $this;
	}

	public function getRole(){ 
	return $this->_role;
	}

	public function setCreated($text){ 
		$this->_created=$text;
	return $this;
	}

	public function getCreated(){ 
	return $this->_created;
	}

	public function setSchool($text){ 
		$this->_school=$text;
	return $this;
	}

	public function getSchool(){ 
	return $this->_school;
	}

	public function setType($text){ 
		$this->_type=$text;
	return $this;
	}

	public function getType(){ 
	return $this->_type;
	}

	public function setAffiliation($text){ 
		$this->_affiliation=$text;
	return $this;
	}

	public function getAffiliation(){ 
	return $this->_affiliation;
	}

	public function setDepartment($text){ 
		$this->_department=$text;
	return $this;
	}

	public function getDepartment(){ 
	return $this->_department;
	}

	public function setPosition($text){ 
		$this->_position=$text;
	return $this;
	}

	public function getPosition(){ 
	return $this->_position;
	}

	public function setFulltime($text){ 
		$this->_fulltime=$text;
	return $this;
	}

	public function getFulltime(){ 
	return $this->_fulltime;
	}

	public function setSupervisor($text){ 
		$this->_supervisor=$text;
	return $this;
	}

	public function getSupervisor(){ 
	return $this->_supervisor;
	}

}