<?php
include("db.php");

//Assign the data passed from Flex to variables
$cataname = mysql_real_escape_string($_POST["tempname"]);

//Query the database to see if the given username/password combination is valid.
$query = "SELECT * FROM rformat WHERE question_cat = '$cataname'";
$result = mysql_query($query);
//Open XML
echo "<?xml version=\"1.0\"?>\n";
echo"<mydata>\n";
echo"<question>\n";
//Create the XML
while($row = mysql_fetch_assoc($result)){
echo"<p>".$row ['question_number'] .". ".$row['questions'] ."</p>\n";
}
//Close XML
echo"</question>";
echo"</mydata>";
//Close the db
mysql_close();

?>