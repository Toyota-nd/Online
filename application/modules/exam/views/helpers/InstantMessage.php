<?php
class Zend_View_Helper_InstantMessage extends Zend_View_Helper_Abstract {
	public function instantMessage() {
		$status = $this->view->status;
		if ($status == 'Not Login') {
			$str = "<script>window.location.href='" . $this->view->baseURL() .  "/auth/index';</script>";
			return $str;
		}
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
		$str .= "<span title='按一下即可繼續播放訊息' 
			id ='instant' class='". ACTIVE_STYLE."'>";
		$str .= "<marquee scrolldelay='200'>";
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
