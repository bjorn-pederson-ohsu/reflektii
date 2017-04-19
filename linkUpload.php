<?php
include("db.php");
// Set local PHP vars from the POST vars sent from flash
$itemNum = $_POST['itemnum'];
$userID = $_POST['loginid'];
$timeStamp = $_POST['timestamp'];
$linkName = $_POST['linkname'];
$linkPlace = $_POST['linkplace'];
//entering into Database 
$query1 = "SELECT * FROM rvideo WHERE vidname = '$timeStamp'";
$result= mysql_query($query1);
$row = mysql_fetch_assoc($result);
$origVid=$row['id'];
$query2 = "INSERT INTO vidlinks (videoID,name,linkname,link,number) VALUES ('$origVid','$timeStamp','$linkName','$linkPlace','$itemNum')";
$result = mysql_query($query2);
// This section edits your log file, if you don't need a text log file just delete these lines
$myFile = "linklogFile.txt";
$fh = fopen($myFile, 'a') or die("can't open file");
$stringData = "\n\n todayDate: ".date('l jS \of F Y h:i:s A')."  \n Name: $userID \n video id: $origVid \n link name: $linkName\n URL: $linkPlace\n";
fwrite($fh, $stringData);
fclose($fh);
mysql_close();
// End log file edit

?>