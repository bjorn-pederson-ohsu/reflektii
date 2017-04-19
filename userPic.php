<?php
include("db.php");
//Assign the data passed from Flex to variables
$uID = $_GET["userID"];

$query ="SELECT * ,COUNT(primeid)FROM rvideo WHERE primeid ='$uID'&& vidType = 'original'";
$result =  mysql_query($query);
while($row = mysql_fetch_assoc($result)){
$numberofvideos=$row['COUNT(primeid)'];
}
if ($numberofvideos==0){
//Open XML
echo "<?xml version=\"1.0\"?>\n";
echo"<userpicdata>\n";
echo"<videopic>0</videopic>\n";
echo"</userpicdata>";
} else{
//Query the database to see if the given username/password combination is valid.
$query2 = "SELECT * FROM rvideo WHERE primeid = '$uID'&& vidType = 'original' ORDER BY `rvideo`.`id` DESC"; 
$result2 = mysql_query($query2);
$monthname = array("Jan","Feb","Mar","April","May","June","July","Aug","Sept","Oct","Nov","Dec");
//Open XML
echo "<?xml version=\"1.0\"?>\n";
echo"<userpicdata>\n";

//Create the XML
while($row = mysql_fetch_assoc($result2)){
echo"<videopic>\n";
echo"<picfolder>".$row ['primeid'] ."</picfolder>\n";
echo"<picid>".$row['vidname']."</picid>\n";
echo"<picdate>".$monthname[($row['month']-1)]." ".$row['day'].", ".$row['year']."</picdate>\n";
echo"</videopic>\n";
}
//Close XML
echo"</userpicdata>";
}
//Close the db

mysql_close();

?>