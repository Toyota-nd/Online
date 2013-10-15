<?php
//C:\AppServ\www\cca\library\My\Controller\Helper\Acl.php
class My_Controller_Helper_Acl{ 

	public $acl;
	public function __construct() {
		$this->acl = new Zend_Acl();
		$user_mapper = new Application_Model_UserMapper();
		$tables = array(
					'user' => 'user',
					'task' => 'task',
					'role' => 'role',
					'privilege' => 'privilege',
					'myresource' => 'myresource'
					);
		$columns = array(
					'tcode'=>'user.user_id',
					'name'=>'user.cname',
					'role'=>'role.role_id',
					'role'=>'role.name',
					'action'=>'privilege.name',
					'control'=>'myresource.name',
					'allow'=>'privilege.action'
					);
					
		$user_mapper = $user_mapper
				->_select(array('department' => 'department'),array('department'=>'department_id'))
				->_join(array('task' => 'task'),'department.department_id = task.department_id')
				->_join(array('user' => 'user'),'task.user_id = user.user_id')
				->_join(array('role' => 'role'),'task.role_id = role.role_id')
				->_join(array('privilege' => 'privilege'),'role.role_id = privilege.role_id')
				->_join(array('myresource' => 'myresource'),'privilege.myresource_id = myresource.myresource_id')
				->_where(array('user.user_id'=> $user_id))
				->_where(array('role.role_id'=> $role_id))
				->_order(array('myresource.name'))
			//	->_group(array('user.name'),array('count(*) > 1'))
			//	->_limit(10, 1)
				;
		$sql = $user_mapper->db->__toString();
		Zend_Debug::dump($sql);
		//$data = $user_mapper->fetchAll($form->getValues());
		$data = $user_mapper->_fetchAll($user_mapper);
		// Add a role called user, which inherits from guest
		// $this->addRole(new Zend_Acl_Role('user'), 'guest');
	$this->acl->addRole(new Zend_Acl_Role($values['role']));
	foreach ($data as $values) {
		$this->acl->add(new Zend_Acl_Resource($values['control'] . '::' . $values['action'] . $values['control']));
		if ($values['allowed']) {
			$this->acl->allow($values['role'],null,$values['control'] . '::' . $values['action'] . $values['control']);
		}
	}
	$this->acl->addRole(new Zend_Acl_Role('guest'));
	$this->acl->add(new Zend_Acl_Resource('Auth::addcampaign'));	
	$this->acl->allow('guest',null,'Auth::addcampaign');	
	Zend_Registry::set('acl',$this->acl);
	}
}
