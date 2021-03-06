<?php

class IndexController extends Zend_Controller_Action {
	protected $db;
	protected $user;
	public function init() {
	    /* Initialize action controller here */
		//$this->_helper->layout()->setLayout('exam_layout');
		$this->_helper->layout()->setLayout('exam_layout');
		$this->view->module = $this->_request->getModuleName();
		$this->view->controller = $this->_request->getControllerName();
		$this->view->action = $this->_request->getActionName();		
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
		
    }

    public function indexAction()
    {
     	$this->_helper->layout()->setLayout('index_layout');
	
    }
	
	public function descriptionAction()
    {
     	$this->_helper->layout()->setLayout('directions_layout');
	
    }	
	
	public function aboutAction()
    {
     	$this->_helper->layout()->setLayout('about_layout');
	
    }
	
	 public function systemAction()
    {
     
    }
	
	public function listsqlAction(){
		$request = $this->getRequest();
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$page = $this->_request->getParam('page'); // get the requested page
		$limit = $this->_request->getParam('rows'); // get how many rows we want to have into the grid
		$sidx = $this->_request->getParam('sidx'); // get index row - i.e. user click to sort
		$sord = $this->_request->getParam('sord'); // get the direction
		
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

		//$result = $this->db->query("SELECT * FROM $db.$table");
		//$where = $this->_request->getParam('_where');


/*
		if ($where === 'undefined' || $where == '' || $where === null) {
			$where = str_replace("\'", '"', $this->_request->getParam('_where'));
			$result = $this->db->query("SELECT * FROM $db.$table");
		} else {
			$where = str_replace("\'", '"', $this->_request->getParam('_where'));
			$result = $this->db->query("SELECT * FROM $db.$table where $where");
		}
*/		
		$sql_command = "SELECT * FROM $db.$table " . $this->getWhere();
		$result = $this->db->query($sql_command);
		$rows = $result->fetchAll();
		$count = count($rows);
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) {
			$page=$total_pages;
		}		
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) {
			$start = 0;
		}

		$sql_command = "select $field from $db.$table " . $this->getWhere() . " order by $sidx $sord LIMIT $start , $limit";
		
		$this->view->debugLog($sql_command,1);
		$result = $this->db->query($sql_command);
		
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$i=0;
		while($row = $result->fetch()) {
			$responce->rows[$i]=$row; //Change there
			$i++;
		} 
		$this->_response->setBody(Zend_Json::encode($responce));

	}
	
	public function sqlAction(){
		$request = $this->getRequest();
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		//variable $menu must be defined before the function call
		$event = $this->_request->getParam('_event');
		$sid = $this->_request->getParam('_sid');
		$type = $this->_request->getParam('_type');
		$sql = $this->_request->getParam('_sql');
		$db = $this->_request->getParam('_db');
		$table = $this->_request->getParam('_table');
		$name = $this->_request->getParam('_name');
		$title = $this->_request->getParam('_title');
		$key = $this->_request->getParam('_key');
		$field = $this->_request->getParam('_field');
		$value = $this->_request->getParam('_value');
		$myvalue = $this->_request->getParam('_myvalue');
		$id = $this->_request->getParam('_id');
		
		$titles = explode(',',$title);
		$fields = explode(',',$field);
		if (count($fields) == 1) {
			$fields[1] = $fields[0];
		}
		$tables = explode(',',$table);
		if (count($tables) == 1) {
			$tables[1] = $tables[0];
		}
		$keys = explode(',',$key);

		$titles = explode(',',$title);
		/*
		SELECT statement,answer.name,answer.ans FROM exam join partition on exam.exam_id=partition.exam_id
		join question on partition.partition_id = question.partition_id
		join answer on question.question_id = answer.question_id
		*/
		/*
		if (empty($pk)) {
			return;
		}
		*/
		//$returnStr .=$sql;
		$returnStr .= ''; 		
		switch ($sql) {
		case 'upload':
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES["file"]["name"]);
			$extension = end($temp);
			if ((($_FILES["file"]["type"] == "image/gif")
				|| ($_FILES["file"]["type"] == "image/jpeg")
				|| ($_FILES["file"]["type"] == "image/jpg")
				|| ($_FILES["file"]["type"] == "image/pjpeg")
				|| ($_FILES["file"]["type"] == "image/x-png")
				|| ($_FILES["file"]["type"] == "image/png"))
				&& ($_FILES["file"]["size"] < 20000)
				&& in_array($extension, $allowedExts)) {
				if ($_FILES["file"]["error"] > 0) {
					echo "Return Code: " . 
						$_FILES["file"]["error"] . "<br>";
				} else {
					echo "Upload: " . $_FILES["file"]["name"] . "<br>";
					echo "Type: " . $_FILES["file"]["type"] . "<br>";
					echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
					echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
					if (file_exists("upload/" . $_FILES["file"]["name"])) {
						echo $_FILES["file"]["name"] . " already exists. ";
					} else {
					  move_uploaded_file($_FILES["file"]["tmp_name"],
					  "upload/" . $_FILES["file"]["name"]);
					  echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
					}
				}
			} else {
				echo "Invalid file";
			}		
			break;
		case 'insert':
			$pk = $this->_request->getParam('_pk');
			$sql_command = 
			"insert into " . $tables[0] ." (" . $field .
			") select " .  $myvalue . " from " . $tables[1] ." where " . 
			$keys[0] . " = " . "$pk";
			$result = $this->Update(stripslashes($sql_command));
			$returnStr = json_encode($result);
			break;
		case 'delete':
			switch ($type) {
			case 'treeview':
				$pk = $this->_request->getParam('_pk');
				$pk = explode(',',$pk);
				foreach ($keys as $k=>$v) {
					$keys[$k] = $keys[$k] . ' = ' . $pk[$k];
				}
				$sql_command = "delete from " . $tables[0] . " where " . 
						implode(' and ',$keys);
				$result = $this->Update(stripslashes($sql_command));
				$returnStr = json_encode($result);
				break;
			case 'jqgrid': //尚未套入jqgrid
				$sql_command = "delete from " . $tables[0] . $this->getWhere();
				$result = $this->Update(stripslashes($sql_command));
				$returnStr = json_encode($result);
				break;
			default:
			}
			break;
		case 'print':
			$join = $this->_request->getParam('_join');
			$report = new Application_Model_Report();
			$keys = explode(',',$key);
			if (strpos($join, ',') !== false) {
				$joins = explode(',',$join); //join不管存在與否，$joins至少有一空陣列
			} else {
				$joins = array();
			}
			if (!empty($joins)) {
				$sql_command = "select $field from " . $tables[0] . 
					" join " . $tables[1] . " on " . 
					$keys[0] . " = " . $keys[1] . $this->getWhere();
			} else {			
				$sql_command = "select $field from $table " . $this->getWhere();
			}	
			//$this->view->debugLog($sql_command,1);
			$result = $this->Select($sql_command);

			$data = array();
			$param = array();
			$table_name = array();
			foreach ($fields as $j => $field_name){
				$data[0][] = $titles[$j];
				//建立主檔 ID=名稱對照表，若符合_id及supervisor，存入對應之陣列
				if (strpos($field_name, ' as ') === false) {
					$pos = -1;
					$self_master = $tables[0] . '_id';
					$self_detail = $tables[1] . '_id';
				} else {
					$pos = strpos($field_name, ' as ');
					$self_master = $tables[0] . "__" . $tables[0] . '_id';
					$self_detail = $tables[1] . "__" . $tables[1] . '_id';
					$field_name = substr($field_name,$pos+4);
					$fields[$j] = $field_name;
				}	
				$param[] = $this->_request->getParam($field_name);
				
				if ($field_name == $self_master ||
					$field_name == $self_detail ) { //主檔與明細檔的ID都不需對照表轉換
					$lists[$field_name] = array();
				} else {
					$lists[$field_name] = $this->getNameFromTable($field_name,$tables[0]);
				}
			}	
			$i = 1;
			while ($row = $result->fetch()) {
				foreach ($fields as $field_name){
					if (count($lists[$field_name]) > 0) {
						$data[$i][] = $lists[$field_name][$row[$field_name]];
					} else {	
						$data[$i][] = $row[$field_name];
					}
				}	
				$i++;	
			}		
			$data['title'] = $myvalue;
			$data['param'] = $param;
			$returnStr = $report->setLayout($data);
			break;
		case 'editgrid':
				$type = $this->_request->getParam('oper');
			switch ($type) {
			case '':
				$sql_command = "select " . 
					$this->getDefaultParam('_modifier') . " " 
					. $fields[0] . "," . $fields[1] . 
					" from $db.$table " .
					$this->getWhere();
				$this->view->debugLog($sql_command,1);
				$result = $this->db->query($sql_command);
				/*
				$returnStr ="<ul class='ACTIVE_STYLE'>";
				while ($rows = $result->fetch()) {
					$returnStr .="<li selectValue='" . $rows[$fields[1]] . "'" .
					" extra='" .$rows[$fields[0]] . "'>1</li>";
				}
				$returnStr .="</ul>";
				*/
				$returnStr = "";
				while ($rows = $result->fetch()) {
					$returnStr .=  $rows[$fields[1]] . "|" .
						$rows[$fields[0]] . "\n";
				}
			break;
			case 'edit': //尚未完成，此處需判斷存在與否，若為新記錄應該insert
				$pk = $this->_request->getParam($key);
				$sql_command  = "select $key from $db.$table" . $this->getWhere();

				$result = $this->db->query($sql_command);
				$rows = $result->fetchAll();
				if (count($rows)==0) {
					$sql_cmd = array();
					$pk = $this->_request->getParam($key);
					foreach ($fields as $k=>$v) {
						$myvalue = $this->_request->getParam($v);
						$sql_cmd[$k] = "'$myvalue'";
					}
					$sql_insert  = "insert into $db.$table ($field) values (" ;
					$sql_insert  .=  implode(',',$sql_cmd);
					$sql_insert  .=  ")";
					$sql_command = $sql_insert;
					$this->view->debugLog("$sql_command",1);				
					$result = $this->db->query($sql_command);
				} else {
					$sql_cmd = array();
					$pk = $this->_request->getParam($key);
					foreach ($fields as $k=>$v) {
						$myvalue = $this->_request->getParam($v);
						$sql_cmd[$k] = $v . " = '$myvalue'";
					}
					$sql_update = "update $db.$table set " ;
					$sql_update .=  implode(',',$sql_cmd);
					$sql_update .=  " where $key = '$pk'";
					$sql_command = $sql_update;
					$this->view->debugLog("$sql_command",1);				
					$result = $this->db->query($sql_command);
				}
				$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"$result\" , \"text\" : \"$sql_command\"}";//json_encode($result);
			break;
			case 'add':
				$sql_cmd = array();
				$pk = $this->_request->getParam($key);
				foreach ($fields as $k=>$v) {
					$myvalue = $this->_request->getParam($v);
					$sql_cmd[$k] = "'$myvalue'";
				}
				$sql_command = "insert into $db.$table ($field) values (" ;
				$sql_command .=  implode(',',$sql_cmd);
				$sql_command .=  ")";
				$result = $this->db->query($sql_command);
				$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"$result\" , \"text\" : \"$sql_command\"}";//json_encode($result);
				//$this->view->debugLog("$returnStr",1);
			break;
			case 'del':
				$pk = explode(",",$this->_request->getParam("id"));
				$sql_command = "delete from $db.$table" ;
				foreach ($pk as $k=>$v) {
					$sql_cmd[$k] = "'$v'";
				}
				$pk = implode(",",$sql_cmd);
				$sql_command .=  " where  $key in ($pk)";
				$result = $this->db->query($sql_command);
				$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"$result\" , \"text\" : \"$sql_command\"}";//json_encode($result);
				//$this->view->debugLog("$returnStr",1);
			break;
			default:	
			}
			$this->view->debugLog("$returnStr",1);			
			break;
		case 'update':
			$myvalue = $value;
			if (is_array($myvalue)) {
				foreach ($myvalue as $value) {
					$sql_command = "update $db.$table set " . $fields[0] . 
					" = '$value' " . $this->getWhere();
					//$this->view->debugLog($sql_command,1);								
					$result = $this->Update($sql_command);
				}
			} else { //一定要重抓，預設tables至此必為2，
			/*
			更改此處一定要特別小心，一定要測SQL指令是否正確!
			錯誤可能造成update到不正確的欄位，若是改到id，可能會把
			階層LOGIC破壞掉，形成遞迴函數無窮迴路，以致產生XMLhttp 網路錯誤 Error2f78
			*/
				$tables = explode(',',$table);
				if (count($tables) > 1) { //單一KEY，雙表是用來找出明細表的PK，改其FK($tables[1].$key[0])指向主表新的PK
					$pk = $this->_request->getParam('_pk');
					$sql_command = "update " . $tables[1] .
					" set " . $tables[1] . "." . $key . " = '" . $value . "'" .
					" where " . $tables[1] . "." . $tables[1] . "_id" . " = '" . $pk . "'";
				} else { //單一KEY，單表
					$sql_command = "update $db.$table set " . 
					$fields[0] . " = '$value' "  . $this->getWhere();
				}
				$result = $this->Update($sql_command);
			}			
			$result['id'] = "$id";
//			$result = '1';
			$returnStr .=json_encode($result);
//			$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"$result\" , \"text\" : \"$sql_command\"}";//json_encode($result);
			break;
		case 'select':
			//$returnStr .="select distinct $field from $db.$table'";
			switch ($type) {
				case 'select':
					$sql_command = "select " . 
						$this->getDefaultParam('_modifier') . " " 
						. $fields[0] . "," . $fields[1] . 
						" from $db.$table " .
						$this->getWhere();
					//$this->view->debugLog($sql_command,1);
					$result = $this->db->query($sql_command);
					$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"2\" ,\"text\" : \""; //code = 2 is a 'select element' replaced
					$returnStr .="<select name='$name' id='$id' class='idatabase " . STYLE . "' type='select' sql='$sql' db='$db' table='$table' field='" . $fields[0] . "," . $fields[1] . "' key='$key' pk='$pk'>";
					while ($rows = $result->fetch()) {
						$returnStr .="<option value='" . $rows[$fields[1]] . "'>" 
							. $rows[$fields[0]] . '</option>';
					}
					$returnStr .="</select>";
					$returnStr .="<script src='" . $this->view->baseUrl() . "/js/jquery.easyui.min.js'</script>";
					$returnStr .="\"}";
					//$this->view->debugLog($returnStr,1);
					break;
				case 'button':
					$sql_command = "select * from $db.$table" . $this->getWhere();
					$result = $this->db->query($sql_command);
					$rows = $result->fetch();
					$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"3\" , \"text\" : ";//code = 3 is a 'button element' replaced
					$ret = array();
					$returnStr .='{';
					foreach($fields as $k =>$v) {
						$ret[] .= '"' . $v . '":"' . $rows[$v] . '"';
					}
					$returnStr .= implode(',',$ret) . '}';
					$returnStr .= '}';
					break;
				case 'label':
					$result = $this->db->query("select score.exampaper_id,round(sum(ans)) as score from
					(
					select questions.exampaper_id,exampaper.single*sum(question.singleans=questions.singleans)/count(question.singleans=questions.singleans) ans,question.mytype
					from
					(SELECT *  FROM `toyota`.`question` where mytype = 'radio' and singleans > 0) as question
					join
					(SELECT *  FROM `toyota`.`questions` where mytype = 'radio' and singleans > 0) as questions
					on  question.question_id  = questions.question_id
					join  `toyota`.`exampaper`
					on questions.exampaper_id = exampaper.exampaper_id
					group by exampaper_id,mytype,exampaper.multiple

					union all

					select exampaper_id,multiple*sum(ans)/count(ans),mytype from (
					select questions.exampaper_id,question.mytype,sum(question.multians=questions.multians)=max(questions.myorder) as ans, exampaper.multiple
					from (SELECT question.question_id, question.mytype, answer.multians,answer.myorder FROM `toyota`.`question` join `toyota`.`answer` on question.question_id = answer.question_id where mytype = 'checkbox') as question
					join (SELECT questions.exampaper_id,questions.questions_id,questions.question_id, answers.multians,answers.myorder FROM `toyota`.`questions` join `toyota`.`answers` on questions.questions_id = answers.questions_id where mytype = 'checkbox') as questions
					on  question.question_id  = questions.question_id and question.myorder  = questions.myorder
					join  `toyota`.`exampaper`
					on questions.exampaper_id = exampaper.exampaper_id
					group by questions.exampaper_id,questions.questions_id,question.question_id,question.mytype,exampaper.multiple
					) as mark1
					group by exampaper_id

					) as score
					where score.exampaper_id = '$pk'
					group by score.exampaper_id");
					$rows = $result->fetch();
					$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"4\" , \"text\" : ";//code = 4 is a 'label element' replaced
					$returnStr .='{"'.$fields[0].'":'.$rows[$fields[0]].',"'.$fields[1].'":'.$rows[$fields[1]].'}';
					$returnStr .="}";
					break;
				case 'autocomplete':
					$pk = $this->_request->getParam('_pk');
					$sql_command = "select * from $db.$table where " .
						$fields[0] . " like '" . trim($pk)  . "%' or " . 
						$fields[1] . " like '" . trim($pk)  . "%'";
					$this->view->debugLog($sql_command,1);
					$result = $this->db->query($sql_command);
					//code = 5 is a 'autocomplete element' replaced
					$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"5\" , \"text\" : ";
					$ret = array();
					$returnStr .= '{';
					while ($rows = $result->fetch()) {
						$ret[] = '"' . $rows[$fields[1]] . '"' . ":" .
								 '"' . $rows[$fields[0]] . '"';
					}
					$returnStr .= implode(',',$ret);
					$returnStr .= '}';
					$returnStr .= '}';
					/*
					$text = array("id" => $id, "code" => 5,
					"text" => array(
					  "1"=>"洪俊銘",
					  "2"=>"洪X銘",
					  "3"=>"AppleScript",
					  "4"=>"Asp",
					  "5"=>"BASIC",
					  "6"=>"C",
					  "7"=>"C++",
					  "8"=>"Clojure",
					  "9"=>"COBOL",
					  "10"=>"ColdFusion",
					  "11"=>"Erlang",
					  "12"=>"Fortran",
					  "13"=>"Groovy",
					  "14"=>"Haskell",
					  "15"=>"Java",
					  "16"=>"JavaScript",
					  "17"=>"Lisp",
					  "18"=>"Perl",
					  "19"=>"PHP",
					  "20"=>"Python",
					  "21"=>"Ruby",
					  "22"=>"Scala",
					  "23"=>"Scheme"));					  
					  */
					//$returnStr = json_encode($returnStr);
					//$this->view->debugLog($returnStr,1);
					break;					
				case 'radio':
					$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"1\" , \"text\" : \"\"}";;
					break;
				case 'checkbox':
					$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"1\" , \"text\" : \"\"}";;		
					break;
				case 'auto':
					$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"1\" , \"text\" : \"Auto response~\"}";;		
					break;
			default:	
					$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"1\" , \"text\" : \"Nothing!\"}";;		
			};
			break;
		default:	
			$result = "99";
			$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"$result\" , \"text\" : \"No valid sql command provided!\"}";
		};			
		$this->_response->setBody($returnStr);
	}
	public function treeviewAction(){
		$request = $this->getRequest();
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

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
		$where = $this->_request->getParam('_where');
		//$this->view->debugLog($where,1);		
		$data = $this->view->treeView( 0, 0, 0, $type, 
				$sql, $db, $table, $field, $key, $id ,
				$value, $where); //傳回字串
//		$data = json_decode($data,true);
//	    $this->_response->setBody($this->_helper->json($data));
//	    $this->_response->setBody(Zend_Json::encode($data));
	    $this->_response->setBody($data); //勿編碼，直接傳回JSON"字串"
		$this->view->debugLog($data,1);
	}
	public function simpletreeviewAction(){
		$request = $this->getRequest();
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$event = $this->_request->getParam('_event');
		$type = stripslashes($this->_request->getParam('_type'));
		$sql = stripslashes($this->_request->getParam('_sql'));
		$db = stripslashes($this->_request->getParam('_db'));
		$table = stripslashes($this->_request->getParam('_table'));
		$name = stripslashes($this->_request->getParam('_name'));
		$field = stripslashes($this->_request->getParam('_field'));
		$key = stripslashes($this->_request->getParam('_key'));
		$value = stripslashes($this->_request->getParam('_value'));
		$pk = stripslashes($this->_request->getParam('_pk'));
		$id = stripslashes($this->_request->getParam('_id'));
		$where = stripslashes($this->_request->getParam('_where'));
		
		$data = $this->view->simpleTreeView( 0, 0, 0, $type, 
				$sql, $db, $table, $field, $key, $id ,
				$value, $where, 'div_tags'); //傳回字串
				
		$this->view->debugLog($data,1);
				
//		$data = json_decode($data,true);
//	    $this->_response->setBody($this->_helper->json($data));
//	    $this->_response->setBody(Zend_Json::encode($data));
/*
		$data = '
		{"title" : "Fruit","items" : {
			"Apple節點":{"title" : "Apple","items" : {
				"Red Apple節點":{"title" : "Red Apple","items" : {
				"Red Apple說明":"Red Apple內容"}}
				}},
			"Banana節點":{"title" : "Banana","items" : {
				"Long Banan節點":{"title" : "Long Banan","items" : {
				"Long Banan說明":"Long Banan內容"}}
				}}
		}}'
		;	
*/
	    $this->_response->setBody($data); //勿編碼，直接傳回JSON"字串"
	}
	public function testsqlAction() {
		//.$_GET["a0table"]. 
		//$this->view->debugLog($_GET["Category"],1);
		//$this->view->debugLog($_GET["MASTERtype"],1);
		$request = $this->getRequest();
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$page = $this->_request->getParam('page'); // get the requested page
		$limit = $this->_request->getParam('rows'); // get how many rows we want to have into the grid
		$sidx = $this->_request->getParam('sidx'); // get index row - i.e. user click to sort
		$sord = $this->_request->getParam('sord'); // get the direction
		
		$MASTERtype = $this->_request->getParam('MASTERtype');
		$sql = $this->_request->getParam('_sql');
		$db = $this->_request->getParam('_db');
		$table = $this->_request->getParam('_table');
		$name = $this->_request->getParam('_name');
		$field = $this->_request->getParam('_field');
		$key = $this->_request->getParam('_key');
		$value = $this->_request->getParam('_value');
		$pk = $this->_request->getParam('_pk');
		$id = $this->_request->getParam('_id');

		$sql_command = "SELECT * FROM $db.$table " . $this->getWhere();
		$result = $this->db->query($sql_command);
		$rows = $result->fetchAll();
		$count = count($rows);
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) {
			$page=$total_pages;
		}		
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) {
			$start = 0;
		}
		
		
		if ($MASTERtype == "DETAIL") {
         	$detailSql = "select $field from $db.$table" . $this->getWhere();
			$this->view->debugLog($detailSql,1);
			$detailResult = $this->db->query($detailSql);
			$detailResponce->page = $page;
			$detailResponce->total = $total_pages;
			$detailResponce->records = $count;
			
			$j=0;
			while($rowend = $detailResult->fetch()) {
					$detailResponce->rows[$j]=$rowend;
					$j++;
			} 
			$this->_response->setBody(Zend_Json::encode($detailResponce));
		} //if
	} //public
	protected function getWhere() {
//		$this->getWhere();	
		$op = array( 
			 'eq' => '=', 
			 'ne' => '!=', 
			 'lt' => '<', 
			 'le' => '<=', 
			 'gt' => '>', 
			 'ge' => '>=', 
			 'bw' => 'like', 
			 'bn' => 'not like', 
			 'in' => 'in', 
			 'ni' => 'not in', 
			 'ew' => 'like', 
			 'en' => 'not like', 
			 'cn' => 'like', 
			 'nc' =>'not like');
		$preop = array( 
			 'eq' => "'", 
			 'ne' => "'", 
			 'lt' => "'", 
			 'le' => '', 
			 'gt' => '', 
			 'ge' => '', 
			 'bw' => "'", 
			 'bn' => "'", 
			 'in' => '(', 
			 'ni' => '(', 
			 'ew' => "'%", 
			 'en' => "'%", 
			 'cn' => "'%", 
			 'nc' => "'%");
		$postop = array( 
			 'eq' => "'", 
			 'ne' => "'", 
			 'lt' => '', 
			 'le' => '', 
			 'gt' => '', 
			 'ge' => '', 
			 'bw' => "%'", 
			 'bn' => "%'", 
			 'in' => ')', 
			 'ni' => ')', 
			 'ew' => "'", 
			 'en' => "'", 
			 'cn' => "%'", 
			 'nc' => "%'");

		$request = $this->getRequest();
		$key = $this->_request->getParam('_key');
		$keys = explode(',',$key);
		
		$pk = stripslashes($this->_request->getParam('_pk'));
		$where = stripslashes($this->_request->getParam('_where'));
		$search = $this->_request->getParam('_search');
		
		$retstr = '';
		if ($pk === 'undefined' ||
			$pk == '' ||
			$pk === null) {
			if ($where === 'undefined' ||
				$where == '' ||
				$where === null) {
				$retstr = '';
			} else {
				$retstr = ' where ' . $where;
			}
		} else {
			//檢查PK是否為複選
			$dataArray = explode(',',$pk);
			if (count($dataArray) > 1) {
				foreach($dataArray as $kk => $vv) {
					$dataArray[$kk] = "'" . $vv . "'";
					$data = implode(',',$dataArray);
				}
				$pk = $keys[0] . ' ' . 
					'in' . ' ' . 
					$preop['in'] . 
					$data .  
					$postop['in'] . ' ';		
				if ($where === 'undefined' ||
					$where == '' ||
					$where === null) {
					$retstr = '';
					$retstr = " where $pk";
				} else {
					$retstr = " where $pk" . " and $where";
				}
			} else {
				if ($where === 'undefined' ||
					$where == '' ||
					$where === null) {
					$retstr = '';
					$retstr = " where " . $keys[0] . " = '$pk'";
				} else {
					$retstr = " where " . $keys[0] . " = '$pk'" . " and $where";
				}
			}
		}
			 
		if ($search) {
			$filters = $this->_request->getParam('filters');
			$filters = stripslashes($filters);
			//$filterObj = json_decode($filters,false);
			$filterArray = json_decode($filters,true);
			$searchstr = '';
			if (in_array($filterArray['groupOp'],array('AND','OR'))) {
				foreach($filterArray['rules'] as $k => $v) {
					$dataArray = explode(',',$v['data']);
					if (count($dataArray) > 1) {
						foreach($dataArray as $kk => $vv) {
							$dataArray[$kk] = "'" . trim("$vv") . "'";
							$data = implode(',',$dataArray);
						}
					} else {
						$data = $v['data'];
					}
					$searchcondition[$k] = $v['field'] . ' ' . 
						$op[$v['op']] . ' ' . 
						$preop[$v['op']] . 
						$data .  
						$postop[$v['op']] . ' ';
				}
				$searchstr = implode(' ' . $filterArray['groupOp'] . ' ',$searchcondition);
			}
			//$where .= $filters['groupOp'];
			//$data ={\"groupOp\":\"AND\",\"rules\":[{\"field\":\"role\",\"op\":\"eq\",\"data\":\"助理教授\"}]}
			if ($searchstr === '') {
				if ($retstr === '') {
					$retstr = '';
				} else {
					$retstr = $retstr;
				}
			} else {
				if ($retstr === '') {
					$retstr = ' where ' .$searchstr;
				} else {
					$retstr = $retstr . ' and ' . $searchstr;
				}
			}			
		}	
			
		
/*
		filters = 
		   {
			"groupOp":"OR",
			"rules":[{"field":"a.id","op":"eq","data":"1"}],
			"groups":[
				 {
					 "groupOp":"AND",
					 "rules":[{"field":"a.id","op":"eq","data":"2"}],
					 "groups":[...]
				 }
			 ]
		}

		}
*/		
	return $retstr;
	}
	protected function getDefaultParam($params) {
		$request = $this->getRequest();
		$p = $this->_request->getParam($params);
		if ($p === 'undefined' || 
			$p == '' || 
			$p === null) {
			return '';
		} else {
			return $p;
		}	
	}
	protected function Select($sql_command) {
		//$this->view->debugLog($sql_command,1);	
		//$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"$result\" , \"text\" : \"$sql_command\"}";//json_encode($result);
		$result = array();
		try {
			$result = $this->db->query($sql_command);
		} catch (Exception $e) {
			$mydate = new Zend_Date();
			$error = 
			$mydate->get(Zend_Date::W3C) . " by " .
			$this->view->user->user_id . " from " .
			$this->name . "?" .
			$this->request ."\n" . $e->getMessage() . "\n" . $sql_command; 		
			$fid = fopen('debug.php','a');
			fwrite($fid, $error . "\n");
			fclose($fid);
			$result['code'] = '99';
			$result['text'] = $e->getMessage();
		}
		return $result;
	}	
	protected function Update($sql_command) {
		//$this->view->debugLog($sql_command,1);	
		//$returnStr .="{\"id\" : \"$id\" ,\"code\" : \"$result\" , \"text\" : \"$sql_command\"}";//json_encode($result);
		$result = array();
		try {
			$result['code'] = $this->db->query($sql_command);
			$result['text'] = $sql_command;
		} catch (Exception $e) {
			$mydate = new Zend_Date();
			$error = 
			$mydate->get(Zend_Date::W3C) . " by " .
			$this->view->user->user_id . " from " .
			$this->name . "?" .
			$this->request ."\n" . $e->getMessage(); 		
			$fid = fopen('debug.php','a');
			fwrite($fid, $e->getMessage() . "\n");
			fclose($fid);
			$result['code'] = '99';
			$result['text'] = $e->getMessage();
		}
		return $result;
	}	
	protected function getNameFromTable($field_name,$table) {
	//此處因使用內規:欄位_id前的名稱當表格名，所以必找到__，取出單純欄位之子字串
		if (strpos($field_name, '__') === false) {
			$pos = -1;
		} else {
			$pos = strpos($field_name, '__');
		}				
		$field_name = substr($field_name,$pos+2);
		$list = array();
		$ids = substr($field_name,-3);
		$table_name = '';
		if ( $ids === '_id') {
			$table_name = substr($field_name,0,strlen($field_name)-3);
		} elseif ($field_name === 'supervisor') {
			$table_name = $table;
		}
		if (!empty($table_name)) {
			$sql_command = 'select * from ' . $table_name;
			$result = $this->Select($sql_command);	
			while ($row = $result->fetch()) {
				$list[$row[$table_name . '_id']] = $row['name'];
			}
		}	
		return $list;
	}
}