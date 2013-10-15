<?php
//C:\AppServ\www\cca\application\models\UserMapper.php

class Application_Model_UserMapper{ 

   protected $_dbTable;
   protected $db;
   public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalusername table data gateway provusernameed');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_User');
        }
        return $this->_dbTable;
    }
    public function selectTables()
    {
        if (null === $this->_dbTable) {
        }
        return $this->_dbTable;
    }
	public function save(Application_Model_User $user) { 

		$data = array(
		'user_id'=>$user->getUser_id(),
		'name'=>$user->getName(),
		'password'=>$user->getPassword(),
		'cname'=>$user->getCname(),
		'ename'=>$user->getEname(),
		'email'=>$user->getEmail(),
		'pid'=>$user->getPid(),
		'birthday'=>$user->getBirthday(),
		'role'=>$user->getRole(),
		'created'=>date('Y-m-d H:i:s'),
		'school'=>$user->getSchool(),
		'type'=>$user->getType(),
		'affiliation'=>$user->getAffiliation(),
		'department'=>$user->getDepartment(),
		'position'=>$user->getPosition(),
		'fulltime'=>$user->getFulltime(),
		'supervisor'=>$user->getSupervisor(),
		);
		if (count($this->getDbTable()->find($user->getUser_id())) == 0) {
		    unset($data['User_id']);
		    $this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('user_id = ?' => $user->getUser_id()));
		}
	}
	public function find($user_id, Application_Model_User $user)
	{
	    $result = $this->getDbTable()->find($user_id);
	    if (0 == count($result)) {
	        return;
	    }
	    $row = $result->current();
		$user
			->setUser_id($row->user_id)
			->setName($row->name)
			->setPassword($row->password)
			->setCname($row->cname)
			->setEname($row->ename)
			->setEmail($row->email)
			->setPid($row->pid)
			->setBirthday($row->birthday)
			->setRole($row->role)
			->setCreated($row->created)
			->setSchool($row->school)
			->setType($row->type)
			->setAffiliation($row->affiliation)
			->setDepartment($row->department)
			->setPosition($row->position)
			->setFulltime($row->fulltime)
			->setSupervisor($row->supervisor)
		;
	}
	public function fetchAll($values)
	{
	    $select = $this->getDbTable()->select();
		foreach ($values as $element) {
			if (!empty($element)) {
				if (preg_match('/^_1/',key($values))) { // greater than
					$colname =  preg_replace('/_1([a-zA-Z]+)__(\w+)/', '`$1`.`$2`', key($values));
					$select = $select->where($colname . ' >= ?' , current($values));
					next($values);
				} elseif (preg_match('/^_2/',key($values))) { // less than
					$colname =  preg_replace('/_2([a-zA-Z]+)__(\w+)/', '`$1`.`$2`', key($values));
					$select = $select->where($colname . ' <= ?' , current($values));
					next($values);
				} elseif (preg_match('/^_3/',key($values))) { //like 
					$colname =  preg_replace('/_3([a-zA-Z]+)__(\w+)/', '`$1`.`$2`', key($values));
					$select = $select->where($colname . ' like ?*' , value($values));
					next($values);
				} elseif (preg_match('/^__/',key($values))) { // non-column variable
					next($values);
				} elseif (preg_match('/__/',key($values))) { 
					$colname =  preg_replace('/([a-zA-Z]+)__(\w+)/', '`$1`.`$2`', key($values));
					$this->db = $this->db->where($colname . ' = ?' , $element);
					next($values);
				} else {
					$select = $select->where(key($values) . ' = ?' , $element);
					next($values);
				}
			} else {
				next($values);
			}
		}
		$resultSet = $this->getDbTable()->fetchAll($select);
	    $entries   = array();
	    foreach ($resultSet as $row) {
	        $entry = new Application_Model_User();
	        $entry
			->setUser_id($row->user_id)
			->setName($row->name)
			->setPassword($row->password)
			->setCname($row->cname)
			->setEname($row->ename)
			->setEmail($row->email)
			->setPid($row->pid)
			->setBirthday($row->birthday)
			->setRole($row->role)
			->setCreated($row->created)
			->setSchool($row->school)
			->setType($row->type)
			->setAffiliation($row->affiliation)
			->setDepartment($row->department)
			->setPosition($row->position)
			->setFulltime($row->fulltime)
			->setSupervisor($row->supervisor)
		;
		$entries[] = $entry;
		}
		return $entries;
	}
	public function _fetchAll($select)
	{
		//$select = $this->getDbTable()->select();
		$resultSet = $this->getDbTable()->fetchAll($select);
	    $entries   = array();
	    foreach ($resultSet as $row) {
	        $entry = new Application_Model_User();
	        $entry
			->setUser_id($row->user_id)
			->setName($row->name)
			->setPassword($row->password)
			->setCname($row->cname)
			->setEname($row->ename)
			->setEmail($row->email)
			->setPid($row->pid)
			->setBirthday($row->birthday)
			->setRole($row->role)
			->setCreated($row->created)
			->setSchool($row->school)
			->setType($row->type)
			->setAffiliation($row->affiliation)
			->setDepartment($row->department)
			->setPosition($row->position)
			->setFulltime($row->fulltime)
			->setSupervisor($row->supervisor)
		;
		$entries[] = $entry;
		}
		return $entries;
	}
	public function _join($table,$on) {
		$this->db = $this->db
				->join($table,$on)
				;
		return $this;
	}
	public function _select($tables,$columns) {
		$this->db = Zend_Controller_Front::getInstance()
				->getParam("bootstrap")
				->getResource("db")
				->select()
				->from($tables,$columns)
				;
		return $this;
	}
	public function _where($values) {
		foreach ($values as $element) {
			if (!empty($element)) {
				if (preg_match('/^_1/',key($values))) { // greater than
					$colname =  preg_replace('/_1([a-zA-Z]*)__(\w+)/', '`$1`.`$2`', key($values));
					$this->db = $this->db->where($colname . ' >= ?' , current($values));
					next($values);
				} elseif (preg_match('/^_2/',key($values))) { // less than
					$colname =  preg_replace('/_2([a-zA-Z]+)__(\w+)/', '`$1`.`$2`', key($values));
					$this->db = $this->db->where($colname . ' <= ?' , current($values));
					next($values);
				} elseif (preg_match('/^_3/',key($values))) { //like 
					$colname =  preg_replace('/_3([a-zA-Z]+)__(\w+)/', '`$1`.`$2`', key($values));
					$this->db = $this->db->where($colname . ' like ?*' , value($values));
					next($values);
				} elseif (preg_match('/^__/',key($values))) { // non-column variable
					next($values);
				} elseif (preg_match('/__/',key($values))) { 
					$colname =  preg_replace('/([a-zA-Z]+)__(\w+)/', '`$1`.`$2`', key($values));
					$this->db = $this->db->where($colname . ' = ?' , $element);
					next($values);
				} else {
					$this->db = $this->db->where(key($values) . ' = ?' , $element);
					next($values);
				}
			} else {
				$this->db = $this->db->where(key($values) . ' = ?' , $element);
				next($values);
			}
		}
		return $this;
	}
	public function _order($values) {
		foreach ($values as $element) {
			if (!empty($element)) {
					$this->db = $this->db->order($element);
			}
		}
		return $this;
	}
	public function _group($groups,$having) {
		foreach ($groups as $element) {
			if (!empty($element)) {
				$this->db = $this->db->group($element);
			}
		}
		foreach ($having as $element) {
			if (!empty($element)) {
				$this->db = $this->db->having($element);
			}
		}
		return $this;
	}
	public function _limit($records, $offset) {
		$this->db = $this->db->limit($records, $offset);
		return $this;
	}
	public function _delete($table, $where) {
		$this->db = Zend_Controller_Front::getInstance()
					->getParam("bootstrap")
					->getResource("db");
		$n = 0;
		foreach ($where as $element) {
			$cnt = $this->db->delete($table, $element);
			$n = $n + $cnt;
		}
		return $n;
	}
	public function _getKey($values) {
	}
	public function _print($resultSet) {
	    $entries   = array();
	    foreach ($resultSet as $row) {
	        $entry = new Application_Model_User();
	        $entry
			->setUser_id($row->user_id)
			->setName($row->name)
			->setPassword($row->password)
			->setCname($row->cname)
			->setEname($row->ename)
			->setEmail($row->email)
			->setPid($row->pid)
			->setBirthday($row->birthday)
			->setRole($row->role)
			->setCreated($row->created)
			->setSchool($row->school)
			->setType($row->type)
			->setAffiliation($row->affiliation)
			->setDepartment($row->department)
			->setPosition($row->position)
			->setFulltime($row->fulltime)
			->setSupervisor($row->supervisor)
		;
	       $entries[] = $entry;
	    }
	    return $entries;
	}
}