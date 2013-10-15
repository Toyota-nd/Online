<?php
//C:\AppServ\www\cca\application\modules\system\models\Campaign.php

class System_Model_Campaign{ 

	protected $_campaign_id;
	protected $_name;
	protected $_year;
	protected $_enrollment;
	protected $_finalist;
	protected $_winner;
	protected $_submit;
	protected $_due;
	protected $_accept;
	protected $_published;
	protected $_created;

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
	        throw new Exception('Invalid campaign property'); 
	   }
	    $this->$method($value);
	}
	public function __get($name)
	{
	    $method = 'get' . $name;
	    if (('mapper' == $name) || !method_exists($this, $method)) {
	        throw new Exception('Invalid campaign property'); 
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
	

	public function setCampaign_id($text){ 
		$this->_campaign_id=$text;
	return $this;
	}

	public function getCampaign_id(){ 
	return $this->_campaign_id;
	}

	public function setName($text){ 
		$this->_name=$text;
	return $this;
	}

	public function getName(){ 
	return $this->_name;
	}

	public function setYear($text){ 
		$this->_year=$text;
	return $this;
	}

	public function getYear(){ 
	return $this->_year;
	}

	public function setEnrollment($text){ 
		$this->_enrollment=$text;
	return $this;
	}

	public function getEnrollment(){ 
	return $this->_enrollment;
	}

	public function setFinalist($text){ 
		$this->_finalist=$text;
	return $this;
	}

	public function getFinalist(){ 
	return $this->_finalist;
	}

	public function setWinner($text){ 
		$this->_winner=$text;
	return $this;
	}

	public function getWinner(){ 
	return $this->_winner;
	}

	public function setSubmit($text){ 
		$this->_submit=$text;
	return $this;
	}

	public function getSubmit(){ 
	return $this->_submit;
	}

	public function setDue($text){ 
		$this->_due=$text;
	return $this;
	}

	public function getDue(){ 
	return $this->_due;
	}

	public function setAccept($text){ 
		$this->_accept=$text;
	return $this;
	}

	public function getAccept(){ 
	return $this->_accept;
	}

	public function setPublished($text){ 
		$this->_published=$text;
	return $this;
	}

	public function getPublished(){ 
	return $this->_published;
	}

	public function setCreated($text){ 
		$this->_created=$text;
	return $this;
	}

	public function getCreated(){ 
	return $this->_created;
	}

}