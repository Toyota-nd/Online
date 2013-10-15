<?php
//C:\AppServ\www\cca\application\modules\campaign\Bootstrap.php
class Exam_Bootstrap extends Zend_Application_Module_Bootstrap{ 

	protected function _initDoctype() { 
	define("STYLE", "ui-state-default");
	define("HIGHLIGHT_STYLE", "ui-state-highlight");
	define("ACTIVE_STYLE", "ui-state-active");
	define("FOCUS_STYLE", "ui-state-focus");
	define("HOVER_STYLE", "ui-state-hover");
	define("ERROR_STYLE", "ui-state-error");
	define("EXAMPAPER_NAME", "考卷名稱");
	define("EXAMPART_EXAMPART_ID", "代號");
	define("CAMPAIGN_CAMPAIGN_ID", "Campaign_id");
	define("EXAMPART_NAME", "考卷名稱");
	define("CAMPAIGN_NAME", "Name");
	define("EXAMPART_YEAR", "年度");
	define("CAMPAIGN_YEAR", "Year");
	define("CAMPAIGN_ENROLLMENT", "Enrollment");
	define("CAMPAIGN_FINALIST", "Finalist");
	define("CAMPAIGN_WINNER", "Winner");
	define("CAMPAIGN_SUBMIT", "Submit");
	define("CAMPAIGN_DUE", "Due");
	define("CAMPAIGN_ACCEPT", "Accept");
	define("CAMPAIGN_PUBLISHED", "Published");
	define("CAMPAIGN_CREATED", "Created");
	define("FN_CAMPAIGN", "Campaign");
	define("FN_ADD_CAMPAIGN", "Campaign Add");
	define("FN_UPDATE_CAMPAIGN", "Campaign Update");
	define("FN_DELETE_CAMPAIGN", "Campaign Delete");
	define("FN_LIST_CAMPAIGN", "Campaign List");
	define("FN_GROUP_CAMPAIGN", "Campaign Group");
	define("ENROLLMENT_CAMPAIGN", "Campaign");
	define("ENROLLMENT_ENROLLMENT_ID", "Enrollment_id");
	define("ENROLLMENT_NAME", "Name");
	define("ENROLLMENT_MYABSTRACT", "Myabstract");
	define("ENROLLMENT_TYPE", "Type");
	define("ENROLLMENT_STATUS", "Status");
	define("ENROLLMENT_AGREEMENT", "Agreement");
	define("ENROLLMENT_CREATED", "Created");
	define("ENROLLMENT_LASTUPDATE", "Lastupdate");
	define("ENROLLMENT_CAMPAIGN_ID", "Campaign_id");
	define("ENROLLMENT_USERS_ID", "Users_id");
	define("ENROLLMENT_STUDENTS_ID", "Students_id");
	define("ENROLLMENT_GROUP_ID", "Group_id");
	define("ENROLLMENT_WORKFLOW_ID", "Workflow_id");
	define("ENROLLMENT_MYRESOURCE_ID", "Myresource_id");
	define("ENROLLMENT_EVENT_ID", "Event_id");
	define("ENROLLMENT_CHARACTER_ID", "Character_id");
	define("ENROLLMENT_WORKPACKAGE_ID", "Workpackage_id");
	define("ENROLLMENT_CALENDAR_ID", "Calendar_id");
	define("ENROLLMENT_MEMBER_ID", "Member_id");
	define("ENROLLMENT_SURVEY_ID", "Survey_id");
	define("FN_ENROLLMENT", "Enrollment");
	define("FN_ADD_ENROLLMENT", "Enrollment Add");
	define("FN_UPDATE_ENROLLMENT", "Enrollment Update");
	define("FN_DELETE_ENROLLMENT", "Enrollment Delete");
	define("FN_LIST_ENROLLMENT", "Enrollment List");
	define("FN_GROUP_ENROLLMENT", "Enrollment Group");
	}
}
