<?php
//C:\AppServ\www\cca\application\modules\system\models\CampaignMapper.php

class System_Model_CampaignMapper{ 

   protected $_dbTable;
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
            $this->setDbTable('System_Model_DbTable_Campaign');
        }
        return $this->_dbTable;
    }
    public function selectTables()
    {
        if (null === $this->_dbTable) {
        }
        return $this->_dbTable;
    }
	public function save(System_Model_Campaign $campaign) { 

		$data = array(
		'campaign_id'=>$campaign->getCampaign_id(),
		'name'=>$campaign->getName(),
		'year'=>$campaign->getYear(),
		'enrollment'=>$campaign->getEnrollment(),
		'finalist'=>$campaign->getFinalist(),
		'winner'=>$campaign->getWinner(),
		'submit'=>$campaign->getSubmit(),
		'due'=>$campaign->getDue(),
		'accept'=>$campaign->getAccept(),
		'published'=>$campaign->getPublished(),
		'created'=>date('Y-m-d H:i:s'),
		);
		if (count($this->getDbTable()->find($campaign->getCampaign_id())) == 0) {
		    unset($data['Campaign_id']);
		    $this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('campaign_id = ?' => $campaign->getCampaign_id()));
		}
	}
	public function find($campaign_id, System_Model_Campaign $campaign)
	{
	    $result = $this->getDbTable()->find($campaign_id);
	    if (0 == count($result)) {
	        return;
	    }
	    $row = $result->current();
		$campaign
			->setCampaign_id($row->campaign_id)
			->setName($row->name)
			->setYear($row->year)
			->setEnrollment($row->enrollment)
			->setFinalist($row->finalist)
			->setWinner($row->winner)
			->setSubmit($row->submit)
			->setDue($row->due)
			->setAccept($row->accept)
			->setPublished($row->published)
			->setCreated($row->created)
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
	        $entry = new System_Model_Campaign();
	        $entry
			->setCampaign_id($row->campaign_id)
			->setName($row->name)
			->setYear($row->year)
			->setEnrollment($row->enrollment)
			->setFinalist($row->finalist)
			->setWinner($row->winner)
			->setSubmit($row->submit)
			->setDue($row->due)
			->setAccept($row->accept)
			->setPublished($row->published)
			->setCreated($row->created)
		;
		$entries[] = $entry;
		}
		return $entries
	}
	public function _fetchAll($select)
	{
		//$select = $this->getDbTable()->select();
		$resultSet = $this->getDbTable()->fetchAll($select);
	    $entries   = array();
	    foreach ($resultSet as $row) {
	        $entry = new System_Model_Campaign();
	        $entry
			->setCampaign_id($row->campaign_id)
			->setName($row->name)
			->setYear($row->year)
			->setEnrollment($row->enrollment)
			->setFinalist($row->finalist)
			->setWinner($row->winner)
			->setSubmit($row->submit)
			->setDue($row->due)
			->setAccept($row->accept)
			->setPublished($row->published)
			->setCreated($row->created)
		;
		$entries[] = $entry;
		}
		return $entries
	}
	public function _select($tables,$columns) {
		$first= $tables[key($tables)];
		$others = array_slice($tables,1,count($tables)-1);
		$this->db = Zend_Controller_Front::getInstance()
				->getParam("bootstrap")
				->getResource("db")
				->select()
				->from(array(key($tables)=>$first),$columns)
				;
		if (count($tables) > 1) {
			$previous = $first;
			foreach ($others as $table) {
				if (!empty($table)) {
					$this->db = $this->db
						 ->joinUsing(array(key($others)=>$table), $previous . '_id')
						 ;
					$previous = $table;
					next($others);
				}
			}
		}
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
	        $entry = new System_Model_Campaign();
	        $entry
			->setCampaign_id($row->campaign_id)
			->setName($row->name)
			->setYear($row->year)
			->setEnrollment($row->enrollment)
			->setFinalist($row->finalist)
			->setWinner($row->winner)
			->setSubmit($row->submit)
			->setDue($row->due)
			->setAccept($row->accept)
			->setPublished($row->published)
			->setCreated($row->created)
		;
	       $entries[] = $entry;
	    }
	    return $entries;
	}
}