<?php
//C:\AppServ\www\cca\application\modules\system\Bootstrap.php
class System_Bootstrap extends Zend_Application_Module_Bootstrap{ 

	protected function _initDoctype() { 

	define("VW_START", "Start");
	define("VW_PREVIOUS", "Previous");
	define("VW_NEXT", "Next");
	define("VW_END", "End");
	define("VW_PAGE", "Page");
	define("VW_OF", "Of");
	define("RO_GUEST", "Guest");
	define("USER_USER_ID", "User_id");
	define("USER_NAME", "Name");
	define("USER_PASSWORD", "Password");
	define("USER_CNAME", "Cname");
	define("USER_ENAME", "Ename");
	define("USER_EMAIL", "Email");
	define("USER_PID", "Pid");
	define("USER_BIRTHDAY", "Birthday");
	define("USER_ROLE", "Role");
	define("USER_CREATED", "Created");
	define("USER_SYSTEM", "System");
	define("USER_TYPE", "Type");
	define("USER_AFFILIATION", "Affiliation");
	define("USER_DEPARTMENT", "Department");
	define("USER_POSITION", "Position");
	define("USER_FULLTIME", "Fulltime");
	define("USER_SUPERVISOR", "Supervisor");
	define("FN_USER", "User");
	define("FN_ADD_USER", "User Add");
	define("FN_UPDATE_USER", "User Update");
	define("FN_DELETE_USER", "User Delete");
	define("FN_LIST_USER", "User List");
	define("FN_GROUP_USER", "User Group");
	}
}
