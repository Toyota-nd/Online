<?php
class Zend_View_Helper_InstantMessage extends Zend_View_Helper_Abstract {
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
		$str .= "<span id ='instant'>";
		$str .= "<marquee>";
		$i = 1;
		while ($rows = $q->fetch()) {
				$str .= " $i:" . $rows['name'];
				$i++;
		}
		$str .= "</marquee>";
		$str .= "</span>";
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
}
?>
