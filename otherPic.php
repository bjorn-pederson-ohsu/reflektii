<?php
include("db.php");
//Assign the data passed from Flex to variables
$uID = $_GET["userID"];

//Query the database to see if the given username/password combination is valid.
$query = "SELECT * FROM rvideo WHERE primeid != '$uID' && vidType = 'original' && vidSet='public' ORDER BY `rvideo`.`id` DESC"; 
$result = mysql_query($query);
$monthname = array("Jan","Feb","Mar","April","May","June","July","Aug","Sept","Oct","Nov","Dec");
//Open XML
echo "<?xml version=\"1.0\"?>\n";
echo"<otherpicdata>\n";

//Create the XML
while($row = mysql_fetch_assoc($result)){
echo"<videopic>\n";
echo"<picfolder>".$row ['primeid'] ."</picfolder>\n";
echo"<picid>".$row['vidname']."</picid>\n";
echo"<picdate>".$monthname[($row['month']-1)]." ".$row['day'].", ".$row['year']."</picdate>\n";
echo"</videopic>\n";
}
//Close XML
echo"</otherpicdata>";
//Close the db

mysql_close();

?>