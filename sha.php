<?php
/*$con = mysql_connect("localhost","root","bio1234");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("test", $con);

mysql_query("UPDATE Persons SET Age = '36'
WHERE FirstName = 'Peter' AND LastName = 'Griffin'");

mysql_close($con);
*/
$sha = $_GET['sha'];
$id = $_GET['id'];
echo sha1('3' . '+' . $id)==$sha?'驗證成功':'無法驗證';
?>