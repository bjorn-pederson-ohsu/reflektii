<?php
include("db.php");

$query = "SELECT * FROM rcat";
$result = mysql_query($query);

//Open XML
echo "<?xml version=\"1.0\"?>\n";
echo "<notes>\n";
//Create the XML
while($row = mysql_fetch_array($result)){
echo "<noteType>\n";
echo "<noteid>" . $row['id'] . "</noteid>\n";
echo "<noteLabel>" . $row['scaffoldcat'] . "</noteLabel>\n";
echo "</noteType>\n";
}
//Close XML
echo "</notes>\n";
mysql_close();

?>