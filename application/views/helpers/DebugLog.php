<?php
class Zend_View_Helper_DebugLog extends Zend_View_Helper_Abstract {
	protected $mydate;
	protected $msg;
	protected $name;
	protected $request;
    public function __construct() {
		$moduleName = Zend_Controller_Front::getInstance()->
				getRequest()->getModuleName();
		$controllerName = Zend_Controller_Front::getInstance()->
				getRequest()->getControllerName();
		$actionName = Zend_Controller_Front::getInstance()->
				getRequest()->getActionName();
		$this->name = $moduleName . '/' . 
					  $controllerName . '/' . 
					  $actionName;		
		$this->request = Zend_Controller_Front::getInstance()->
				getRequest()->getRawBody();

		$this->mydate = new Zend_Date();
		$this->msg = "<?php \n//". str_repeat("=", 80) . 
			"\n//Logging at " . 
			$this->mydate->get(Zend_Date::W3C) . " by " .
			$this->view->user->user_id . "\n//from " .
			$this->name . "?" .
			$this->request .
			"\n \$data =";
	}	
	public function debugLog($data, $newOpen) {
	// Usage: $this->view->debugLog($data, 1);
	// Setting of a new time
	// $date->set('13:00:00',Zend_Date::TIMES);
		if ($this->view->mydebug) {
			if ($newOpen == 0) {  // new open 
				$fid = fopen($this->view->logfile,'w');
				fwrite($fid, $this->msg);
			} elseif ($newOpen == 1){
				$fid = fopen($this->view->logfile,'a');
				fwrite($fid, $this->msg);
			} else {
				$fid = fopen($this->view->logfile,'a');
			}
			if (is_array($data)) {
				foreach ($data as $mykey => $myvalue) {
					if (is_array($myvalue)) {
						fwrite($fid,"\n\"$mykey\" => array(");
						$this->debugLog($myvalue, -1);
						fwrite($fid,")");
					} else {
						fwrite($fid,"\n\"$mykey\" => \"$myvalue\"");
					}
				}
				fwrite($fid,")");			
			} else {
				fwrite($fid, "$data\n");
			}
			fclose($fid);
		}
	}
}
?>
