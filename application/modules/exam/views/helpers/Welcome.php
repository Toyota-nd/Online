<?php
	class Zend_View_Helper_Welcome extends Zend_View_Helper_Abstract {
	public function welcome() {
		$db = Zend_Controller_Front::getInstance()
			->getParam("bootstrap")
			->getPluginResource("db")
			->getDbAdapter()
			;
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$user = $auth->getIdentity();
		}
		$q = $db->query("select * from system where name = 'welcome'");
		
		$imgurl1 = '/toyota/public/images/backend.jpg';
		if ($rows = $q->fetch()) {
			$imgurl2 = $rows['imgurl'];
			$str .= "<script>";
			$str .= "\$('#backlogo').attr('src',function(i,e){
				return e.replace('$imgurl1','$imgurl2');
				})";
			$str .= "</script>";
			$str .= "<td>" .$rows['description'] .
					"</td>";		
			$str .= "<tr>";
		} else {
			$str .= "<script>";
			$str .= "\$('#backlogo').attr('src',function(i,e){
				return e.replace('$imgurl1','$imgurl2');
				})";
			$str .= "</script>";
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