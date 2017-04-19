<?php
include("db.php");
//Assign the data passed from Flex to variables
//$uID = $_GET["userID"];
$videofolder = $_GET["videofolder"];
$videoID = $_GET["videoID"];
$query = "SELECT * FROM rvideo WHERE primeid='$videofolder' && vidname='$videoID'";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$orivid= $row['id'];
$querya ="SELECT rvideo.primeid,COUNT(rvideo.primeid) FROM vidrelation INNER JOIN rvideo ON vidrelation.responsevidid = rvideo.id WHERE vidrelation.originalvidid='$orivid'";
$resulta = mysql_query($querya);
$rowa = mysql_fetch_assoc($resulta);
$numberofvideos = $rowa['COUNT(rvideo.primeid)'];

if ($numberofvideos==0){
//Open XML
echo "<?xml version=\"1.0\"?>\n";
echo"<userResdata>\n";
echo"<userResponse>0</userResponse>\n";
echo"</userResdata>";
} else {
$query2 ="SELECT rvideo.primeid,rvideo.vidname,rvideo.month,rvideo.day,rvideo.year FROM vidrelation INNER JOIN rvideo ON vidrelation.responsevidid = rvideo.id WHERE vidrelation.originalvidid='$orivid'";
$result2 = mysql_query($query2);
$monthname = array("Jan","Feb","Mar","April","May","June","July","Aug","Sept","Oct","Nov","Dec");
//Open XML
echo "<?xml version=\"1.0\"?>\n";
echo"<userresdata>\n";

//Create the XML
while($row = mysql_fetch_assoc($result2)){
echo"<videorespic>\n";
echo"<resfolder>".$row ['primeid'] ."</resfolder>\n";
echo"<resid>".$row['vidname']."</resid>\n";
echo"<picdate>".$monthname[($row['month']-1)]." ".$row['day'].", ".$row['year']."</picdate>\n";
echo"</videorespic>\n";
}
//Close XML
echo"</userresdata>";
}
//Close the db

mysql_close();

?>