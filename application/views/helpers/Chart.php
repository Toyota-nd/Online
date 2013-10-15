<?php
class Zend_View_Helper_Chart extends Zend_View_Helper_Abstract {
	protected $db;
    public function __construct() {
/*	
			$this->db = Zend_Controller_Front::getInstance()
				->getParam("bootstrap")
				->getPluginResource("db")
				->getDbAdapter()
				;
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$user = $auth->getIdentity();
		}				
*/		
	}
	public function chart() {
//( $no, $index, $cnt, $type, $sql, $db, $table, $field, $key, $id, $value, $where)	
	return "1234";
	$str =
	"\$('#scoreChart').gchart({
		type: 'r', maxValue: 40,
		title: r.title, titleColor: 'green',
		backgroundColor: $.gchart.gradient('horizontal', 'ccffff', 'ccffff00'),
		series: dataset,
		axes: [
		$.gchart.axis('bottom', r.category, 'black'),
		$.gchart.axis('left', 0, 40, 'red', 'right'),
		$.gchart.axis('left', ['題數'], [50], 'red', 'right'),
		$.gchart.axis('right', 0, 200, 50, 'blue', 'left'),
		$.gchart.axis('right', ['分'], [50], 'blue', 'left')
		],
		legend: 'right'
		});";
	return $str;
	
    $cr = "\n";
    $tab = "\t";
	$tables = explode(',',$table);
	if (count($tables) == 1) {
		$tables[1] = $tables[0];
	}
	$fields = explode(',',$field);
	if (count($fields) == 1) {
		$fields[1] = $fields[0];
	}		
/*	
	$sqlCommand = "SELECT r.name title, s.myvalue myvalue, 
			s.gchart_id gchart FROM `$db`.`radarchart` r
			join gchart g
			on r.radarchart_id = g.radarchart_id
			join gchart_series s
			on g.gchart_id = s.gchart_id";
	
	$videoRow = $this->db->query($sqlCommand);

	if ($where === null) {
		$sql_command = "select * from " . $tables[0] ." where supervisor ='$index'";
	} else {
		$sql_command = "select * from " . $tables[0] ." where supervisor ='$index' and $where";
	}
	
	//$this->view->debugLog($sql_command,1);	
    $q = $this->db->query($sql_command);
	$result = array();
	$title = array();
	$series = array();
	$category = array();
	$categoryTable = $tables[0];
	$categoryRow = $this->db->query("SELECT $field FROM `$db`.`$categoryTable`");
	$categoryTable1 = $tables[1];
	$lengthRow = $this->db->query("SELECT count(*) $field FROM `$db`.`$categoryTable1` GROUP BY gchart_id");
	while ($row = $videoRow->fetch()) {
		if($title != $row['title']){
			$title['title'] = $row['title'] ;
		}
		print_r($title);
		for($i = 1; $i <= count($lengthRow->fetchAll()); $i++){  //計算總筆數
				if($row['gchart']==$i) {
					$series['series'][$i-1][] =  $row['myvalue'] ;
				}
		}
	}
	while ($row = $categoryRow->fetch()) {
			$category['category'][] =  $row['name'] ;
	}
	$result = array_merge((array)$title,$series,$category);
	echo json_encode($result);
	*/
	//echo json_encode($row['title'].$row['name']);
}
?>
