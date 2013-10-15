<?php
$con = mysql_connect("localhost","root","bio1234");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  
mysql_query('SET NAMES utf8');
  mysql_select_db("test", $con);

$sql="INSERT INTO cca_notice (name, created_at)
VALUES
('$_POST[name]','$_POST[created_at]')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
echo "1 record added";

mysql_close($con)



?>