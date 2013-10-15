<?php
$link = mysql_connect("localhost","root","bio1234") or die("連接失敗");
	mysql_select_db("toyota");
	mysql_query("SET NAMES 'utf8'");
		$id = $_POST['id'];
		$pw = $_POST['pw'];
		

//搜尋資料庫資料

$sql = "SELECT empno,password FROM user where empno = '$id'and password='$pw'";
$result = mysql_query($sql);
$row = @mysql_fetch_row($result);

//判斷帳號與密碼是否為空白
//以及MySQL資料庫裡是否有這個會員
if($id != null && $pw != null && $row[0] == $id && $row[1] == $pw)
//if($rowid == $id && $rowpw == $pw)
{
        echo '登入成功!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=backstage.html>';
}
else
{
        echo '登入失敗!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=index.html>';
}
mysql_close($link);

?>
