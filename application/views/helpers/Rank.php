<?php
	class Zend_View_Helper_Rank extends Zend_View_Helper_Abstract {
	public function rank() {
		$db = Zend_Controller_Front::getInstance()
			->getParam("bootstrap")
			->getPluginResource("db")
			->getDbAdapter()
			;
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$user = $auth->getIdentity();
		}
		$q = $db->query("select d_name,sumscore from examall 
						order by sumscore desc");
		
		$str = "";
		while ($rows = $q->fetch()) {
			$str .= "<tr>";
			$str .= "<td>" .$rows['d_name'] . "</td>";
			$str .= "<td>" .$rows['sumscore'] . "</td>";
			$str .= "</tr>";
		}
		return $str;
	}
} 
/*class Zend_View_Helper_Latest extends Zend_View_Helper_Abstract {
	public function latest() {
		$db = Zend_Controller_Front::getInstance()
			->getParam("bootstrap")
			->getPluginResource("db")
			->getDbAdapter()
			;
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$latest = $auth->getIdentity();
		}
		$q = $db->query("select name,latest_id from latest");
		
		
		
		while ($rows = $q->fetch()) {
				$str .= $rows['latest_id']. ":";
				$str .= $rows['name'];
				$str .="<br>";
				
		}

		return $str;
	}
}
*/
?>