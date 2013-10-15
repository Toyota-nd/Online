<?php
class Zend_View_Helper_Chart extends Zend_View_Helper_Abstract {
	protected $db;
    public function Chart($mytype,$mytitle,$mydb,$mytable,$myname,$myfield,$mywhere) {	
		$db = Zend_Controller_Front::getInstance()
			->getParam("bootstrap")
			->getPluginResource("db")
			->getDbAdapter()
			;
			
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$user = $auth->getIdentity();
		}
		$mynames = explode(',',$myname);
		array_shift($mynames);
		$myfields = explode(',',$myfield);
		$mycategory = $db->query("select $myfield from exampart where $mywhere");
		
		$result = array(
						'title'=>$mytitle,
						'legend'=>$mynames,
						'color'=> array('red','green','blue'),     //category顏色
						'option'=> array("'ffcccc'","''",'0, 200')	//區塊顏色
						);		
		$legendOption = array(
						"'left',   0, 40,       'red', 'right'",
						"'left',  ['C'], [50],  'red', 'right'",
						"'right',  0, 150, 50,  'blue', 'left'",
						"'right', ['mm'], [50], 'blue', 'left'"
						);
						
		$result['category'][] = array();
		for($i=1;$i<count($myfields);$i++){
		$result['series'][$i-1] = array();
		}	
		while ($rows = $mycategory->fetch()){
			$result['category'][] = '"' . $rows['name'] . '"';
			for($i=1;$i<count($myfields);$i++){
				$result['series'][$i-1][] = $rows[$myfields[$i]]*100;
			}
		}
		for($i=1;$i<count($myfields);$i++){
				$result['series'][$i-1][] = $result['series'][$i-1][0];//小於五要補到五個
				$result['series'][$i-1][] = $result['series'][$i-1][0];
			}		
			
		$category = $result['category'];
		for ($i=0; $i < count($result['series']); $i++) {
			$myseries[$i] = $result['series'][$i];
			$color[$i]    = $result['color'][$i];
			$legend[$i]   = $result['legend'][$i];
			$option[$i]   = $result['option'][$i];
			
		}
		$str = "<script> \$(document).ready(function() {";
		//$str .= "exampaper_id";
		$str .= "
		\$('#gChart').gchart({type: '$mytype', maxValue: 40, 
		title: ";
		$str .= "'".$result['title'] ."'";
		$str .= ", titleColor: 'green',
		backgroundColor: $.gchart.gradient('horizontal', 'ccffff', 'ccffff00'), 
		series: ";
		$str .= "[";
		$strarray = array();
		for ($i=0; $i < count($myseries); $i++) {
			$strarray[$i] = "$.gchart.series('". $legend[$i] . 
						   "', [". implode(',',$myseries[$i]) ."], '" . 
							$color[$i] . "',". $option[$i] .")";
		}
		$str .= implode(',',$strarray);
		$str .= "],";
		$str .= "axes: [
			$.gchart.axis('bottom',[ ";
		$str .= implode(",",$category);
		$str .= "], 'black'),";
		$legendarray = array();
		for ($i=0; $i < count($legendOption); $i++) {
			$legendarray[$i] = "$.gchart.axis(". $legendOption[$i] .")";
		}
		$str .= implode(',',$legendarray);	
		$str .= "
			], 
			legend: 'right' 
		});		
		});
		</script>	
		";
		return $str;		
		
	}
/*
    
		
		
	\$('#gChart').gchart({type: 'line', maxValue: 40, 
    title: 'Weather for|Brisbane, Australia', titleColor: 'green', 
    backgroundColor: $.gchart.gradient('horizontal', 'ccffff', 'ccffff00'), 
    series: [$.gchart.series('Max', [29.1, 28.9, 28.1, 26.3, 
        23.5, 21.2, 20.6, 21.7, 23.8, 25.6, 27.3, 28.6], 'red', 'ffcccc'), 
        $.gchart.series('Min', [20.9, 20.8, 19.5, 16.9, 
        13.8, 10.9, 9.5, 10.0, 12.5, 15.6, 18.0, 19.8], 'green'), 
        $.gchart.series('Rainfall', [157.7, 174.6, 138.5, 90.4, 
        98.8, 71.2, 62.6, 42.7, 34.9, 94.4, 96.5, 126.2], 'blue', 0, 200)], 
    axes: [$.gchart.axis('bottom', ['Jan', 'Feb', 'Mar', 'Apr', 
        'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], 'black'), 
        $.gchart.axis('left', 0, 40, 'red', 'right'), 
        $.gchart.axis('left', ['C'], [50], 'red', 'right'), 
        $.gchart.axis('right', 0, 200, 50, 'blue', 'left'), 
        $.gchart.axis('right', ['mm'], [50], 'blue', 'left')], 
    legend: 'right' 
});		
	
		
*/	
/*	public function chart() {
//( $no, $index, $cnt, $type, $sql, $db, $table, $field, $key, $id, $value, $where)	

$result = array(
		'title'=>'南都汽車成績分析',
		'series'=>
			array(
			array(29.1, 21.7, 23.8, 25.6, 27.3, 28.6, 29.1),
			array(20.9, 10.0, 12.5, 15.6, 18.0, 19.8, 20.9),
			array(157.7, 42.7, 34.9, 94.4, 96.5, 126.2, 157.7)
			),
		'category'=>array("'服務'", "'出納'", "'引擎'", "'板金'", "'塗裝'", "'零件'"),
		'legend'=> array('最高','最低','分佈'),
		'color'=> array('red','green','blue'),
		'option'=> array("'ffcccc'","''",'0, 200')
		);		
	$legendOption = array(
			"'left',   0, 40,       'red', 'right'",
			"'left',  ['C'], [50],  'red', 'right'",
			"'right',  0, 200, 50,  'blue', 'left'",
			"'right', ['mm'], [50], 'blue', 'left'"
		);
		
	$category = $result['category'];
	for ($i=0; $i < count($result['series']); $i++) {
		$myseries[$i] = $result['series'][$i];
		$color[$i]    = $result['color'][$i];
		$legend[$i]   = $result['legend'][$i];
		$option[$i]   = $result['option'][$i];
	}
	$str = "<script> \$(document).ready(function() {";
	
	$str .= "
	\$('#gChart').gchart({type: 'r', maxValue: 40, 
    title: ";
	$str .= "'".$result['title'] ."'";
	$str .= ", titleColor: 'green',
    backgroundColor: $.gchart.gradient('horizontal', 'ccffff', 'ccffff00'), 
    series: ";
	$str .= "[";
	$strarray = array();
	for ($i=0; $i < count($myseries); $i++) {
		$strarray[$i] = "$.gchart.series('". $legend[$i] . 
					   "', [". implode(',',$myseries[$i]) ."], '" . 
						$color[$i] . "',". $option[$i] .")";
	}
	$str .= implode(',',$strarray);
	$str .= "],";
	$str .= "axes: [
		$.gchart.axis('bottom',[ ";
	$str .= implode(",",$category);
	$str .= "], 'black'),";
	$legendarray = array();
	for ($i=0; $i < count($legendOption); $i++) {
		$legendarray[$i] = "$.gchart.axis(". $legendOption[$i] .")";
	}
	$str .= implode(',',$legendarray);	
	$str .= "
		], 
		legend: 'right' 
	});		
	});
	</script>	
	";
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
	}		*/
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
