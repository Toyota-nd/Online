<?php
//C:\AppServ\www\cca\library\My\Controller\Helper\Acl.php
class My_Controller_Helper_Acl{ 

	public $acl;
	protected $db;
	protected $user;

public function __construct() {
	/* Initialize action controller here */
	//$acl = new My_Controller_Helper_Acl();
/*
	$mymodule = $this->_request->getModuleName();
	$mycontroller = $this->_request->getControllerName();
	$myaction = $this->_request->getActionName();		
$fid = fopen('debug.php','a');fwrite($fid, "$mymodule_$mycontroller::$myaction\n");fclose($fid);
*/
	
	$this->db = Zend_Controller_Front::getInstance()
		->getParam("bootstrap")
		->getPluginResource("db")
		->getDbAdapter()
		;
	$auth = Zend_Auth::getInstance();
	if ($auth->hasIdentity()) {
		$this->user = $auth->getIdentity();
		$this->view->user = $this->user;
		$this->view->status = 'Login OK';
	} else {
		$this->view->status = 'Not Login';
	}
	$guest_allow_list = array (
		'default_index::index',
		'default_error::error',
		'default_auth::index',
		'default_index::description',
		'default_index::about',		
		'default_auth::logout',
		'default_auth::privilege',
		'default_auth::changepw',
		'default_index::treeview',
		'default_index::simpletreeview',
		'default_index::sql',
		'default_index::listsql',
		'default_index::testsql',
		'default_index::system',
//		'exam_exam::listsql',
		'exam_user::adduser',
		'exam_index::home',
		'exam_index::online',
		'exam_index::mock',
		'exam_news::instant',
		'exam_exam::account',
		'exam_exam::addexam',
		'exam_exam::monitor',
		'exam_exam::remainder',
		'exam_exam::step1',
		'exam_exam::step2',
		'exam_exam::step3',
		'exam_exam::step4',
		'exam_user::listuser',
		'exam_user::groupuser',
		'exam_index::permissions',
		'exam_post::latest',
		'exam_post::welcome',
		'exam_post::news',
		'exam_score::achievement',
		'exam_score::rank',
		'exam_score::radarchart',		
		'exam_score::inqueryscore',		
		'exam_score::portfolio',
		'exam_score::statistic',
		'index_layout',
		'exam_layout',
		'auth_layout',
		'user_layout',
	);
	$this->acl = new Zend_Acl();
	if($auth->hasIdentity()) {
		$user = $auth->getIdentity();
		/*
		$user_mapper = new Application_Model_UserMapper();
		$columns = array(
	                'tcode'=>'user.user_id',
					'name'=>'user.cname',
					'role'=>'role.name',
					'module'=>'myresource.module',
					'action'=>'privilege.name',
					'control'=>'myresource.name',
					'allow'=>'privilege.allow'
				);
		$data = $user_mapper
				->_select(array('department' => 'department'),$columns)
				->_join(array('task' => 'task'),'department.department_id = task.department_id')
				->_join(array('user' => 'user'),'task.user_id = user.user_id')
				->_join(array('role' => 'role'),'task.role_id = role.role_id')
				->_join(array('privilege' => 'privilege'),'role.role_id = privilege.role_id')
				->_join(array('myresource' => 'myresource'),'privilege.myresource_id = myresource.myresource_id')
				->_where(array('user.user_id'=>$user->user_id))
				->_where(array('role.name'=>$user->role))
				->_order(array('myresource.name'))
		//		->_group(array('user.name'),array('count(*) > 1'))
		//		->_limit(10, 1)
				->_fetchAll()
				;
		$sql = $user_mapper->db->__toString();
		*/
		$this->acl->addRole(new Zend_Acl_Role($user->role));
//¦³°ÝÃD
		$result = $this->db->query('select * from toyota.acl where role_id = 4');
//$ccc=$row['allow']																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
$ccc="===>".$resource																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
//$ccc=$row['role']																																	;$fid = fopen('debug.php','a');fwrite($fid, "$ccc\n");fclose($fid);
		while ($row = $result->fetch()) {
			$resource = $row['module'] . '_' . $row['control'] . '::' . $row['action'];
			if ($row['allow']) {
				$this->acl->add(new Zend_Acl_Resource($resource));
				$this->acl->allow($row['role'],$resource);
			}
		}
		
		//$data = $user_mapper->fetchAll($form->getValues());
		// Add a role called user, which inherits from guest
		// $this->addRole(new Zend_Acl_Role('user'), 'guest');
/*
		foreach ($guest_allow_list as $values) {
			$this->acl->add(new Zend_Acl_Resource($values));
			$this->acl->allow($user->role,$values);
		}
*/		
	} else {
		$this->acl->addRole(new Zend_Acl_Role(RO_GUEST));
		foreach ($guest_allow_list as $values) {
			$this->acl->add(new Zend_Acl_Resource($values));
			$this->acl->allow(RO_GUEST,$values);
		}
	}
	//var_dump($this->acl);	
	$mysession = new Zend_Session_Namespace('mysession');
	$mysession->acl = $this->acl;
$fid = fopen('debug.php','a');fwrite($fid, "Helper/ACL\n");fclose($fid);
}
}
