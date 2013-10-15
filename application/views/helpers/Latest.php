<?php
class Zend_View_Helper_Latest extends Zend_View_Helper_Abstract {
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




/* class Zend_View_Helper_InstantMessage extends Zend_View_Helper_Abstract {
	public function instantMessage() {
		$db = Zend_Controller_Front::getInstance()
			->getParam("bootstrap")
			->getPluginResource("db")
			->getDbAdapter()
			;
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$user = $auth->getIdentity();
		}
		$q = $db->query("select name from news where user_id='" .
				$user->user_id . "'");
		$str .= $user->user_id;
		$str .= $user->cname;
		$str .= $user->role;
		$str .= "<table border='1'>";
		while ($rows = $q->fetch()) {
				$str .= "<tr>";
				$str .= "<td><marquee>" .$rows['name'] .
						"</marquee></td>";
				$str .= "</tr>";
		}
		$str .= "</table>";	
		$str .= '<script>	
			$("marquee").hover(function () { 
				this.stop();
			}, function () {
				//this.stop();
			});';		
		$str .= '	
			$("marquee").mouseup(function (event) { 
				this.start();
			});
			</script>';	

		return $str;
	}
} */
?>