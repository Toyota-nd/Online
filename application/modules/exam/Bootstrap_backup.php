<?php
//C:\AppServ\www\cca\application\modules\campaign\Bootstrap.php
class Campaign_Bootstrap extends Zend_Application_Module_Bootstrap{ 

	protected function _initDoctype() { 
	define("VW_START", "第一頁");
	define("VW_PREVIOUS", "前一頁");
	define("VW_NEXT", "下一頁");
	define("VW_END", "最末頁");
	define("VW_PAGE", "頁次");
	define("VW_OF", "的");
	define("CAMPAIGN_CAMPAIGN_ID", "年度");
	define("CAMPAIGN_NAME", "競賽名稱");
	define("CAMPAIGN_YEAR", "報名開始日");
	define("CAMPAIGN_ENROLLMENT", "報名隊伍數");
	define("CAMPAIGN_FINALIST", "入圍隊伍數");
	define("CAMPAIGN_WINNER", "得獎隊伍數");
	define("CAMPAIGN_SUBMIT", "報名截止日");
	define("CAMPAIGN_DUE", "作品繳交日");
	define("CAMPAIGN_ACCEPT", "得獎公布日");
	define("CAMPAIGN_PUBLISHED", "頒獎日");
	define("CAMPAIGN_CREATED", "建檔日");
	define("FN_CAMPAIGN", "競賽管理");
	define("FN_ADD_CAMPAIGN", "新增競賽");
	define("FN_UPDATE_CAMPAIGN", "更新競賽");
	define("FN_DELETE_CAMPAIGN", "刪除競賽");
	define("FN_LIST_CAMPAIGN", "查詢競賽");
	define("FN_GROUP_CAMPAIGN", "競賽統計分析");
	define("ENROLLMENT_ENROLLMENT_ID", "報名編號");
	define("ENROLLMENT_NAME", "隊伍名稱");
	define("ENROLLMENT_MYABSTRACT", "摘要");
	define("ENROLLMENT_TYPE", "競賽種類");
	define("ENROLLMENT_STATUS", "狀態");
	define("ENROLLMENT_AGREEMENT", "個資同意使用");
	define("ENROLLMENT_CREATED", "建檔日");
	define("ENROLLMENT_LASTUPDATE", "更新日");
	define("ENROLLMENT_CAMPAIGN_ID", "所屬競賽編號");
	define("ENROLLMENT_USERS_ID", "指導老師代號");
	define("ENROLLMENT_STUDENTS_ID", "學生代號");
	define("ENROLLMENT_GROUP_ID", "團隊代號");
	define("ENROLLMENT_WORKFLOW_ID", "工作流程代號");
	define("ENROLLMENT_MYRESOURCE_ID", "可用資源代號");
	define("ENROLLMENT_EVENT_ID", "事件代號");
	define("ENROLLMENT_CHARACTER_ID", "題目特質代號");
	define("ENROLLMENT_WORKPACKAGE_ID", "工作包代號");
	define("ENROLLMENT_CALENDAR_ID", "資源行事曆代號");
	define("ENROLLMENT_MEMBER_ID", "關係人代號");
	define("ENROLLMENT_SURVEY_ID", "所屬研究案代號");
	define("FN_ENROLLMENT", "報名管理");
	define("FN_ADD_ENROLLMENT", "新增報名");
	define("FN_UPDATE_ENROLLMENT", "更新報名");
	define("FN_DELETE_ENROLLMENT", "刪除報名");
	define("FN_LIST_ENROLLMENT", "查詢報名");
	define("FN_GROUP_ENROLLMENT", "報名統計分析");
	}
}
