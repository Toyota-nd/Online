<?
class My_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {
public function preDispatch(Zend_Controller_Request_Abstract $request) {
	 $acl = Zend_Registry::get('acl');
	 $usersNs = new Zend_Session_NameSpace('user');
	 If($usersNs->userType==''){
		$roleName= RO_GUEST;
	 } else {
		$roleName=$userType;
	 }
	 $privilageName=$request->getActionName();
	 if(!$acl->isAllowed($roleName,null,$privilageName)){
		 $request->setControllerName('Error');
		 $request->setActionName('index');
	 }
	 }
}
?>