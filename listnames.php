<?php
include("db.php");

//Query the database to see if the given username/password combination is valid.
$query = "SELECT * FROM rcat";
$result = mysql_query($query);

//Open XML
echo "<?xml version=\"1.0\"?>\n";
echo"<catadata>\n";
//Create the XML
while($row = mysql_fetch_assoc($result)){
echo"<idnum>". $row['id'] ."</idnum>\n";
echo"<catagories>". $row['scaffoldcat'] ."</catagories>\n";
}

//Close XML
echo"</catadata>";

//echo $output;
//Close the db
mysql_close();

?>
