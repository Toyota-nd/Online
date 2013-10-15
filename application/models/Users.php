<?php
<?php

class Application_Model_Users
{
    protected $_username;
    protected $_password;
    protected $_cname;
    protected $_ename;
    protected $_email;
    protected $_pid;
    protected $_role;
    protected $_birthday;
    protected $_created;
    protected $_system;
    protected $_type;
    protected $_affiliation;
    protected $_department;
    protected $_position;
    protected $_fulltime;
	protected $_supervisor;
	protected $_logindate;
	
 
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
            throw new Exception('資料表欄位的set方法不存在或未宣告protected _欄位名稱!' .
			' 請程式設計人員檢查\models\' . "內是否有set' . $name);
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('資料表欄位的set方法不存在或未宣告protected _欄位名稱!' .
			' 請程式設計人員檢查\models\' . "內是否有get' . $name);
        }
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

    public function setUsername($text)
    {
        $this->_username = $text;
        return $this;
    }
 
    public function getUsername()
    {
        return $this->_username;
    }
	
    public function setPassword($text)
    {
        $this->_password = $text;
        return $this;
    }
 
    public function getPassword()
    {
        return $this->_password;
    }	
	
    public function setCname($text)
    {
        $this->_cname = $text;
        return $this;
    }
 
    public function getCname()
    {
        return $this->_cname;
    }	

    public function setEname($text)
    {
        $this->_ename = $text;
        return $this;
    }
 
    public function getEname()
    {
        return $this->_ename;
    }	

    public function setPid($text)
    {
        $this->_pid = $text;
        return $this;
    }
 
    public function getPid()
    {
        return $this->_pid;
    }	
	
    public function setBirthday($ts)
    {
        $this->_birthday = $ts;
        return $this;
    }
 
    public function getBirthday()
    {
        return $this->_birthday;
    }
 
    public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }
 
    public function getEmail()
    {
        return $this->_email;
    }

    public function setRole($text)
    {
        $this->_role = $text;
        return $this;
    }
 
    public function getRole()
    {
        return $this->_role;
    }
	
    public function setCreated($ts)
    {
        $this->_created = $ts;
        return $this;
    }
 
    public function getCreated()
    {
        return $this->_created;
    }

    public function setSystem($text)
    {
        $this->_system = $text;
        return $this;
    }
 
    public function getSystem()
    {
        return $this->_system;
    }

    public function setType($text)
    {
        $this->_type = $text;
        return $this;
    }
 
    public function getType()
    {
        return $this->_type;
    }
	
    public function setAffiliation($text)
    {
        $this->_affiliation = $text;
        return $this;
    }
 
    public function getAffiliation()
    {
        return $this->_affiliation;
    }

    public function setDepartment($text)
    {
        $this->_department = $text;
        return $this;
    }
 
    public function getDepartment()
    {
        return $this->_department;
    }
	
    public function setPosition($text)
    {
        $this->_position = $text;
        return $this;
    }
 
    public function getPosition()
    {
        return $this->_position;
    }

    public function setFulltime($text)
    {
        $this->_fulltime = $text;
        return $this;
    }
 
    public function getFulltime()
    {
        return $this->_fulltime;
    }
	
}

