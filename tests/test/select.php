<?php
$con = mysql_connect("localhost","root","bio1234");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("test", $con);

$result = mysql_query("SELECT * FROM cca_notice");

echo "<table border='1'>
<tr>
<th>name</th>
<th>created_at</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['Name'] . "</td>";
  echo "<td>" . $row['Created_at'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);
?>