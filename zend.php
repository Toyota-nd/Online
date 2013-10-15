<?
/*連線資料庫*/
$link = mysql_connect("localhost","root","bio1234") or die("連接失敗");
mysql_select_db("toyota");
mysql_query("SET NAMES 'utf8'");
//variable $menu must be defined before the function call
$event = $_POST['event'];
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
$fields = explode(',',$field);
if (count($fields) == 1) {
	$fields[1] = $fields[0];
}
print_r($_POST);
$str = "insert $db.$table ($field) values ('$pk')";
$result = '1';
echo "{\"id\" : \"$id\" ,\"code\" : \"$result\" , \"text\" : \"$str\"}";//json_encode($result);
?>