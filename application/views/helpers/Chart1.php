<?
/*連線資料庫*/
class Zend_View_Helper_Chart extends Zend_View_Helper_Abstract {
	public function chart() {
		$db = Zend_Controller_Front::getInstance()
			->getParam("bootstrap")
			->getPluginResource("db")
			->getDbAdapter()
			;
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$user = $auth->getIdentity();
		}
/*$link = mysql_connect("localhost","root","bio1234") or die("連接失敗");
mysql_select_db("toyota");
$videoRow = mysql_query("SELECT r.name title, s.myvalue myvalue, s.gchart_id gchart FROM `toyota`.`radarchart` r
join gchart g
on r.radarchart_id = g.radarchart_id
join gchart_series s
on g.gchart_id = s.gchart_id",$link)or die("連接失敗");*/  
//variable $menu must be defined before the function call*/
$event = $this->_request->getParam('_event');
		$type = $this->_request->getParam('_type');
		$sql = $this->_request->getParam('_sql');
		$db = $this->_request->getParam('_db');
		$table = $this->_request->getParam('_table');
		$name = $this->_request->getParam('_name');
		$field = $this->_request->getParam('_field');
		$key = $this->_request->getParam('_key');
		$value = $this->_request->getParam('_value');
		$pk = $this->_request->getParam('_pk');
		$id = $this->_request->getParam('_id');
		$fields = explode(',',$field);
		if (count($fields) == 1) {
			$fields[1] = $fields[0];
		}	
		$tables = explode(',',$table);
		if (count($tables) == 1) {
			$tables[1] = $tables[0];
		}
		
/*$event = $_POST['event'];
$type = $_POST['type'];
$sql = $_POST['sql'];
$db = $_POST['db'];
$table = $_POST['table'];
$name = isset($_POST['name'])?$_POST['name']:'';
//$name = substr($name,0,9);
//$checkbox = $_POST[$name];
$field = $_POST['field'];
$key = $_POST['key'];
$value =$_POST['value'];
$pk = isset($_POST['pk'])?$_POST['pk']:'';
$id = $_POST['id'];
$fields = explode(',',$field);*/
//$dateCount = mysql_num_rows($videoRow); 計算SQL語法篩選出來的筆數有幾筆
if (count($fields) == 1) {
	$fields[1] = $fields[0];
}
	
	/*$result = array(
		'title'=>'南都汽車成績分析',
		'series'=>
			array(
			array(29.1, 28.9, 28.1, 26.3,23.5, 21.2, 29.1),
			array(20.9, 20.8, 19.5, 16.9, 13.8, 10.9, 20.9),
			array(157.7, 174.6, 138.5, 90.4, 98.8, 71.2, 157.7)
			),
		'category'=>array('服務', '出納', '引擎', '板金', '塗裝', '零件')
		);*/
	$result = array();
	$title = array();
	$series = array();
	$category = array();
	$categoryTable = $tables[0];
	$categoryRow = mysql_query("SELECT $field FROM `$db`.`$categoryTable`");
	$categoryTable1 = $tables[1];
	$lengthRow = mysql_query("SELECT count(*) $field FROM `$db`.`$categoryTable1` GROUP BY gchart_id");
	while ($row = mysql_fetch_assoc($videoRow)) {
	//while ($row = mysql_fetch_row($videoRow)) {	
		if($title != $row['title']){
			$title['title'] = $row['title'] ;
		}
		print_r($title);
		for($i = 1; $i <= mysql_num_rows($lengthRow); $i++){  //計算總筆數
				if($row['gchart']==$i) {
					$series['series'][$i-1][] =  $row['myvalue'] ;
				}
		}
		//echo json_encode($row['title'].$row['name']);
	}
	
	while ($row = mysql_fetch_assoc($categoryRow)) {
			$category['category'][] =  $row['name'] ;
	}
	$result = array_merge((array)$title,$series,$category);
	//print_r($result);
	echo json_encode($result);
	
	/*foreach($title as $key => $value){
		echo $value."<br />";
	}*/
	
	//print_r(mysql_fetch_assoc($videoRow));
	/*foreach($series as $value1) {			//顯示二維陣列中存放的內容
		foreach ($value1 as $value2) {
			echo $value2."   ;"; 
		}
    echo "<br>"
	;}*/
	
	//echo $series[2];
	/*for($i = 1; $i <$videoRow_length; $i++){	
		echo $row[$i].",".'<br>';
	}*/
		//print_r($result['series']);
	//echo json_encode($result);
	//print_r($result);
	/*$result=mysql_fetch_array($videoRow);
	
	echo "<script>"; 
	echo "maxframe = ".$result[array1[0]].";";
	echo "</script>";*/ 
?>	