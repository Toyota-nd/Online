<?
function tree_set($no, $index, $cnt, $type, $sql, $db, $table, $field, $key, $id, $value, $where) {
	//$value : 	從HTML元件送來的value=$value，用於checkbox的成對值(checked, value)
	//，只適合獨立一(UI)對一(DB)值的設定，JQTreeView所包含的多層次子元件結構並不適用
	//$myvalue : php程序抓DB出來的value=$myvalue，用於text, radio等單一值設定(value)
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

    $q=mysql_query("select * from " . $tables[0] ." where supervisor ='$index' and $where");
	//echo "select * from " . $tables[0] ." where supervisor ='$index' and $where";
    if(mysql_num_rows($q) === 0)
    {
        return;
    }
    // User $tree instead of the $menu global as this way there shouldn't be any data duplication
    //$tree = $index > 0 ? "{ 'title' : 'mydata'," . : ; 
	//"節點A": {'title': "節點標題",'items': {"節點說明": "節點內容"}}
    //$mycomma = $index > 0 ? "," : "";
	if (!isset($tree)) {
		$flag = 0;
		$tree = '';
		$label = '';
	}

    while($arr=mysql_fetch_assoc($q))
    {
		$id = $arr[$key];
        $subFileCount=mysql_query("select * from " . $tables[0] ." where supervisor = '$id' and $where");
		if ($flag > 0) {
			$tree .= ','; 
		}
        if(mysql_num_rows($subFileCount) > 0) {
            //'folder'
			$expain = "";
        } else {
			//'file'
			$label = $no+1;
			$expain = '"' . $arr["description"] . ':' . $arr[$tables[0].'_id'] .'":"'. 
					ui_helper ($type, $sql, $db, $tables, $fields, $key, $id, $no+1, $arr['url'], $value) 
					. '"';
			$no++;
        }
		if ($index > 0) {
			$tree .= '"' .$arr[$fields[0]] . '節點' . '":{"title" : ';
		} else {
			$tree .= '{"title" : ';
		}
		$tree .= '"' . $label . ' ' . $arr[$fields[0]] . '",'; //
		$tree .= '"items" : {';
		$tree .= $expain; 
		//print_r("[" . $flag . "]" .  $arr[$fields[0]]);
		$flag = 0;
		$tree .= tree_set($no, "".$arr[$key]."",$flag, $type, $sql, $db, $table, $field, $key, $id, $value, $where);
		$flag = $flag + 1;
		$tree .=  "}";
        $tree .= '}';
    }
    //$tree .= $index > 0 ? '}' . : ; // If we are on index 0 then we don't need the enclosing ul

    return $tree;
}
function ui_helper ($type, $sql, $db, $tables, $fields, $key, $id, $label, $url ,$value) {
	$str = "<table border='0'>";
	/*
	echo '<select class="database" type="$type" sql="$sql" db="$db" table="$table" name="$field" key="$key" id="$id">';
	while ($rows = mysql_fetch_row($result)) {
		echo '<option value="' . $rows[0] . '">' 
			. $rows[0] . '</option>';
	}
	echo '</select><br>';
	*/
	$table = $tables[0]; //Default, recording the ans in qustion table (parent node)
	switch ($sql) {
	case "select":
		switch ($type) {
			case "auto":
				$result = mysql_query("select type from $db" . '.' . $tables[0] . ' where ' . $key . " = '$id'");
				$rows = mysql_fetch_assoc($result);
				switch ($rows["type"]) {
					case "select": //下拉選單-單選
						$str .= marker($db,$tables,$key,$id);
						$result = mysql_query("select * from $db." . $tables[0] . ' join ' . "$db." . $tables[1] . 
									' on ' . $tables[0] . '.' . $tables[0] . '_id = ' . $tables[1] . '.' . $tables[0] . 
									'_id where ' . $tables[0] . '.' . $key . ' = ' . "'$id'");
						$fields[1] = "singleans";
						$str .= "<div id='div_" . $id . "'>";
						$str .= "<select id='select_" . $id . "' class='database' type='select' sql='update' db='$db' table='". $tables[0] . "' field= '" . $fields[1] ."' key='" . $tables[0] . "_id' pk='$id'>";
						$myvalue = 1;
						while ($rows = mysql_fetch_assoc($result)) {
							if ($rows[$fields[1]]==$myvalue) { 
								$checked = "selected";
							} else {
								$checked = "";
							}
							$str .= "<option $checked value='" . $myvalue . "'>" 
							. $rows[$fields[0]] . '</option>';
							$myvalue++;
						}
						$str .= '</select>';
						$str .= '</div>';
						$str .= "	</td>";
						break;
					case "radio":
						//Recording the ans in qustion table (parent node)
						$fields[1] = "singleans";
						$str .= marker($db,$tables,$key,$id);
						$result = mysql_query("select * from $db." . $tables[0] . ' join ' . "$db." . $tables[1] . 
									' on ' . $tables[0] . '.' . $tables[0] . '_id = ' . $tables[1] . '.' . $tables[0] . 
									'_id where ' . $tables[0] . '.' . $key . ' = ' . "'$id'");
						$myvalue = 1;
						while ($rows = mysql_fetch_assoc($result)) {
							if ($rows[$fields[1]]==$myvalue) { 
								$checked = "checked";
							} else {
								$checked = "";
							}
							$str .= "		<label for='" . "radio_" . $rows[$tables[0]."_id"] . "_" . $myvalue . "'>";
							$str .= "			<input type='radio' " . $checked . " field='" . $fields[1] . "' name='radio".
												$id . "' id='radio_" . $rows[$tables[0]."_id"] . "_" . $myvalue . "' value='". $myvalue ."'"; 
							$str .= "			class='database' sql='update' db='".$db."' table='" . 
														$tables[0] . "' key='" . $tables[0] . "_id' pk='" . $rows[$tables[0]."_id"] . "'/>";
							$str .= "			" . $rows[$fields[0]];
							$str .= "		</label>";
							$str .= "		<br />";
							$myvalue ++;
						}
						$str .= "	<td width='25%'>";
						if (isset($url)) {
							$str .= "	<img class='image_class' width='300' height='200' src='" . $url . "'>";	
						};
						$str .= "	</td>";
						$str .= "		<br />";
						$str .= "	</td>";
						$str .= "</tr>";
						break;
					case "checkbox":
						//Recording the ans in answer table (child node)
						$fields[1] = "multians";
						$table = $tables[1];
						$str .= marker($db,$tables,$key,$id);
						$result = mysql_query("select * from $db." . $tables[0] . ' join ' . "$db." . $tables[1] . 
									' on ' . $tables[0] . '.' . $tables[0] . '_id = ' . $tables[1] . '.' . $tables[0] . 
									'_id where ' . $tables[0] . '.' . $key . ' = ' . "'$id'");
						while ($rows = mysql_fetch_assoc($result)) {
							$label0 = $rows[$tables[0]."_id"];  // Different
							$label1 = $rows[$tables[1]."_id"];  // Different
							if ($rows[$fields[1]]) { 
								$checked = "checked";
								$myvalue = "1";
							} else {
								$checked = "unchecked";
								$myvalue = "0";
							}
							$str .= "		<label for='" . "checkbox_". $label0 . "_" . $label1 . "'>";
							$str .= "			<input type='checkbox' " . $checked . " field='" . $fields[1] . "' name='checkbox".  $id . "[]" . 
									"' id='" ."checkbox_". $label0 . "_" . $label1 . "' value='" . $myvalue ."'"; 
							$str .= "			class='database' sql='update' db='".$db."' table='" . 
														$tables[1] . "' key='" . $tables[1] . "_id' pk='" . $label1 . "'/>";
							$str .= "			" . $rows[$fields[0]];
							$str .= "		</label>";
							$str .= "		<br/>";
						}
						$str .= "</td>";
						$str .= "	<td width='25%'>";
						if (isset($url)) {
							$str .= "	<img class='image_class' width='300' height='200' src='" . $url . "'>";	
						};
						$str .= "	</td>";
						$str .= "</tr>";		
						break;
					case "text":
						//Recording the ans in qustion table (parent node)
						$str .= marker($db,$tables,$key,$id);
						$result = mysql_query("select * from $db." . $tables[0] . ' join ' . "$db." . $tables[1] . 
									' on ' . $tables[0] . '.' . $tables[0] . '_id = ' . $tables[1] . '.' . $tables[0] . 
									'_id where ' . $tables[0] . '.' . $key . ' = ' . "'$id'");
						while ($rows = mysql_fetch_assoc($result)) {
							$myvalue = $rows[$fields[0]];
							$length = strlen($myvalue);
							$str .= "		<label for='" . "text_" . $rows[$tables[1]."_id"] . "'>";
							$str .= "			<input type='text' " . "size='" . $length . "' field='" . $fields[0] . "' name='text".
												$id . "' id='text_" . $rows[$tables[1]."_id"] . "' value='". $myvalue ."'"; 
							$str .= "			class='database' sql='update' db='".$db."' table='" . 
														$tables[1] . "' key='" . $tables[1] . "_id' pk='" . $rows[$tables[1]."_id"] . "'/>";
							$str .= "		</label>";
							$str .= "		<br />";
						}
						$str .= "	<td width='25%'>";
						if (isset($url)) {
							$str .= "	<img class='image_class' width='300' height='200' src='" . $url . "'>";	
						};
						$str .= "	</td>";
						$str .= "		<br />";
						$str .= "	</td>";
						$str .= "</tr>";
						break;

				default:	
						$str = "Auto type failed! type = " . $rows["type"] . "sql: ";
						$str .= "select type from $db" . '.' . $tables[0] . ' where ' . $key . " = '$id'";
				};
				break;
			case "select":
				$str .= marker($db,$tables,$key,$id);
				$result = mysql_query("select * from $db." . $tables[0] . ' join ' . "$db." . $tables[1] . 
							' on ' . $tables[0] . '.' . $tables[0] . '_id = ' . $tables[1] . '.' . $tables[0] . 
							'_id where ' . $tables[0] . '.' . $key . ' = ' . "'$id'");
				$fields[1] = "singleans";
				$str .= "<div id='div_" . $id . "'>";
				$str .= "<select id='select_" . $id . "' class='database' type='select' sql='update' db='$db' table='". $tables[0] . "' field= '" . $fields[1] ."' key='" . $tables[0] . "_id' pk='$id'>";
				$myvalue = 1;
				while ($rows = mysql_fetch_assoc($result)) {
					if ($rows[$fields[1]]==$myvalue) { 
						$checked = "selected";
					} else {
						$checked = "";
					}
					$str .= "<option $checked value='" . $myvalue . "'>" 
					. $rows[$fields[0]] . '</option>';
					$myvalue++;
				}
				$str .= '</select>';
				$str .= '</div>';
				$str .= "	</td>";
				break;
			case "radio":
				//Recording the ans in qustion table (parent node)
				$str .= marker($db,$tables,$key,$id);				
				$result = mysql_query("select * from $db." . $tables[0] . ' join ' . "$db." . $tables[1] . 
							' on ' . $tables[0] . '.' . $tables[0] . '_id = ' . $tables[1] . '.' . $tables[0] . 
							'_id where ' . $tables[0] . '.' . $key . ' = ' . "'$id'");
				$myvalue = 1;
				while ($rows = mysql_fetch_assoc($result)) {
					if ($rows[$fields[1]]==$myvalue) { 
						$checked = "checked";
					} else {
						$checked = "";
					}
					$str .= "		<label for='" . "radio_" . $rows[$tables[0]."_id"] . "_" . $myvalue . "'>";
					$str .= "			<input type='radio' " . $checked . " field='" . $fields[1] . "' name='radio".
										$id . "' id='radio_" . $rows[$tables[0]."_id"] . "_" . $myvalue . "' value='". $myvalue ."'"; 
					$str .= "			class='database' sql='update' db='".$db."' table='" . 
												$tables[0] . "' key='" . $tables[0] . "_id' pk='" . $rows[$tables[0]."_id"] . "'/>";
					$str .= "			" . $rows[$fields[0]];
					$str .= "		</label>";
					$str .= "		<br />";
					$myvalue ++;
				}
				$str .= "	<td width='25%'>";
				if (isset($url)) {
					$str .= "	<img class='image_class' width='300' height='200' src='" . $url . "'>";	
				};
				$str .= "	</td>";
				$str .= "		<br />";
				$str .= "	</td>";
				$str .= "</tr>";
				break;
			case "checkbox":
				$table = $tables[1]; //Recording the ans in answer table (child node)
				$str .= marker($db,$tables,$key,$id);
				$result = mysql_query("select * from $db." . $tables[0] . ' join ' . "$db." . $tables[1] . 
							' on ' . $tables[0] . '.' . $tables[0] . '_id = ' . $tables[1] . '.' . $tables[0] . 
							'_id where ' . $tables[0] . '.' . $key . ' = ' . "'$id'");
				while ($rows = mysql_fetch_assoc($result)) {
					$label0 = $rows[$tables[0]."_id"];  // Different
					$label1 = $rows[$tables[1]."_id"];  // Different
					if ($rows[$fields[1]]) { 
						$checked = "checked";
						$myvalue = "1";						
					} else {
						$checked = "unchecked";
						$myvalue = "0";						
					}
					$str .= "		<label for='" . "checkbox_". $label0 . "_" . $label1 . "'>";
					$str .= "			<input type='checkbox' " . $checked . " field='" . $fields[1] . "' name='checkbox".  $id . "[]" . 
							"' id='" ."checkbox_". $label0 . "_" . $label1 . "' value='" . $myvalue . "'"; 
					$str .= "			class='database' sql='update' db='".$db."' table='" . 
												$tables[1] . "' key='" . $tables[1] . "_id' pk='" . $label1 . "'/>";
					$str .= "			" . $rows[$fields[0]];
					$str .= "		</label>";
					$str .= "		<br/>";
				}
				$str .= "</td>";
				$str .= "	<td width='25%'>";
				if (isset($url)) {
					$str .= "	<img class='image_class' width='300' height='200' src='" . $url . "'>";	
				};
				$str .= "	</td>";
				$str .= "</tr>";		
				break;
			case "text":
				//Recording the ans in qustion table (parent node)
				$str .= marker($db,$tables,$key,$id);
				$result = mysql_query("select * from $db." . $tables[0] . ' join ' . "$db." . $tables[1] . 
							' on ' . $tables[0] . '.' . $tables[0] . '_id = ' . $tables[1] . '.' . $tables[0] . 
							'_id where ' . $tables[0] . '.' . $key . ' = ' . "'$id'");
				while ($rows = mysql_fetch_assoc($result)) {
					$myvalue = $rows[$fields[0]];
					$length = strlen($myvalue);
					$str .= "		<label for='" . "text_" . $rows[$tables[1]."_id"] . "'>";
					$str .= "			<input type='text' " . "size='" . $length . "' field='" . $fields[0] . "' name='text".
										$id . "' id='text_" . $rows[$tables[1]."_id"] . "' value='". $myvalue ."'"; 
					$str .= "			class='database' sql='update' db='".$db."' table='" . 
												$tables[1] . "' key='" . $tables[1] . "_id' pk='" . $rows[$tables[1]."_id"] . "'/>";
					$str .= "		</label>";
					$str .= "		<br />";
				}
				$str .= "	<td width='25%'>";
				if (isset($url)) {
					$str .= "	<img class='image_class' width='300' height='200' src='" . $url . "'>";	
				};
				$str .= "	</td>";
				$str .= "		<br />";
				$str .= "	</td>";
				$str .= "</tr>";
				break;
		default:	
				$str = "No valid type of UI provided!";
		};
		break;
	default:	
		$str = "No valid sql command provided!";
		//echo json_encode($result);
	};	
	$str .= "</table>";
	return $str;
}
function marker($db,$tables,$key,$id){
	$result = mysql_query("select * from $db." . $tables[0] . ' join ' . "$db." . $tables[1] . 
				' on ' . $tables[0] . '.' . $tables[0] . '_id = ' . $tables[1] . '.' . $tables[0] . 
				'_id where ' . $tables[0] . '.' . $key . ' = ' . "'$id'");
	$rows = mysql_fetch_assoc($result);
	$str = "";
	$str .= "<tr>";
	$str .= "	<td  width='2%'>";
	$str .= "	<label for='mark1_" . $id . "'>";
	if ($rows['subject']) {
		$checked = "checked";
		$myvalue = 1;
	} else {
		$checked = "unchecked";
		$myvalue = 0;
	}
	$str .= "	<input $checked value='$myvalue' type='checkbox' name='Mark' id='mark1_$id' class='database' sql='update' db='toyota' table='questions' field='subject' key='questions_id' pk='$id'/>";
	$str .= "	待答";
	$str .= "	<br/>";
	$str .= "	</label>";
	$str .= "	<label for='mark2_" . $id . "'>";
	if ($rows['uncertainty']) {
		$checked = "checked";
		$myvalue = 1;
	} else {
		$checked = "unchecked";
		$myvalue = 0;
	}
	$str .= "	<input $checked value='$myvalue' type='checkbox' name='Mark' id='mark2_$id' class='database' sql='update' db='toyota' table='questions' field='uncertainty' key='questions_id' pk='$id'/>";
	$str .= "	不確定";
	$str .= "	</label>";
	$str .= "	<br/>";
	$str .= "	</td>";
	$str .= "	<td>";
	return $str;
}
/*連線資料庫*/
//variable $menu must be defined before the function call
$level[0] = 0;
$type = $_POST['type'];
$sql = $_POST['sql'];
$db = $_POST['db'];
$table = $_POST['table'];
$field = $_POST['field'];
$key = $_POST['key'];
$value =$_POST['value'];
$id = $_POST['id'];
$where = $_POST['where'];
$link = mysql_connect("localhost","root","bio1234") or die("連接失敗");
mysql_select_db($db);
mysql_query("SET NAMES 'utf8'");
$data = tree_set(0, 0, 0, $type, $sql, $db, $table, $field, $key, $id ,$value, $where);
echo $data;

$fid=fopen('mylog','w');
fwrite($fid,$data);
fclose($fid);

?>
