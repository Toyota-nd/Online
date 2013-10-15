<?php 
//C:\AppServ\www\cca\library\My\Controller\Plugin\Acl.php
class My_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract{ 

protected $_defaultRole = RO_GUEST;
public function preDispatch(Zend_Controller_Request_Abstract $request) {

$ccc=1																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
	$resource = $request->getModuleName() . '_' . $request->getControllerName() . '::' . $request->getActionName();
	$mvc = $request->getModuleName() . '/' . $request->getControllerName() . '/' . $request->getActionName();
$ccc=$mvc																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
$ccc=2																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
	$acl = $_SESSION['mysession']['acl'];
	//$acl = unserialize(base64_decode($_SESSION['acl']));\



$ccc=gettype($acl)																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
$ccc=3																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
	if (empty($acl)) {
$ccc=4																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
		$aclObj = new My_Controller_Helper_Acl();
$ccc=5																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
		$acl = $_SESSION['acl'];
	}
	
$ccc=6																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
	//$acl = new My_Controller_Helper_Acl();
	//$acl = Zend_Registry::get('acl');
	$auth = Zend_Auth::getInstance();
$ccc=7																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);

	if($auth->hasIdentity()) {
$ccc=8																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
$ccc=$mvc																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
		if ($mvc = 'default/auth/privilege') {
			return;
		}
		$user = $auth->getIdentity();
		if(!$acl->isAllowed($user->role, $resource)) {
$ccc=9																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
			$test = ($acl->isAllowed($user->role, $resource))?'allowed':'denied';
			Zend_Debug::dump($user->role . 'accesses the ' . $resource . ' is ' . $test);
			$mysession->destination_url = $request->getPathInfo();
			$mysession->acl = $acl;
$ccc=10																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);

			//Redirect之ZEND相對URL也再次檢查，導致遞迴檢查
			//$this->_response->setRedirect('/cc/test.php')->sendResponse();
			$this->_response->setRedirect('auth/privilege')->sendResponse();
			exit;		
			//return Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')
			//	->setGotoUrl('auth/privilege');
		}
	} else {
$ccc=11																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
		if(!$acl->isAllowed($this->_defaultRole, $resource)) {
$ccc=12																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
			$mysession->destination_url = $request->getPathInfo();
			return Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')
			->setGotoUrl('auth/index');
$ccc=13																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
		}
	}
	
$ccc=14																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
	
	}

}
