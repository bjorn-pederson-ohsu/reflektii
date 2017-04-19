<?php
include("db.php");
// Set local PHP vars from the POST vars sent from flash
$itemNum = $_POST['itemnum'];
$userID = $_POST['loginid'];
$timeStamp = $_POST['timestamp'];
$filename = $_FILES['Filedata']['name'];	
$filetmpname = $_FILES['Filedata']['tmp_name'];	
$fileType = $_FILES['Filedata']['type'];
$fileSizeMB = ($_FILES['Filedata']['size'] / 1024 / 1000);
//$info = print_r($_FILES)

function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
$filename = stripslashes($_FILES['Filedata']['name']);
$extension = getExtension($filename);
$extension = strtolower($extension);


if (file_exists('docs/'.$userID)) {
    echo "The directory exists";
} else {
//if not, then php creates the directory. The permissions number is ignored by
//Windows.    
	mkdir('docs/'.$userID,0777);
}
if (file_exists('docs/'.$userID.'/'.$timeStamp)) {
    echo "The directory exists";
} else {
//if not, then php creates the directory. The permissions number is ignored by
//Windows.    
	mkdir('docs/'.$userID.'/'.$timeStamp,0777);
}
$target_path = "docs/".$userID."/".$timeStamp."/";
$target_path = $target_path . $timeStamp.'_'.$itemNum.'.'.$extension; 


// Place file on server, into the images folder
move_uploaded_file($_FILES['Filedata']['tmp_name'], $target_path);
//entering into Database 
$query1 = "SELECT * FROM rvideo WHERE vidname = '$timeStamp'";
$result= mysql_query($query1);
$row = mysql_fetch_assoc($result);
$origVid=$row['id'];
$query2 = "INSERT INTO viddocs (videoID,name,title,extension,number) VALUES ('$origVid','$timeStamp','$filename','$extension','$itemNum')";
$result = mysql_query($query2);
// This section edits your log file, if you don't need a text log file just delete these lines
$myFile = "doclogFile.txt";
$fh = fopen($myFile, 'a') or die("can't open file");
$stringData = "\n\n todayDate: ".date('l jS \of F Y h:i:s A')."  \n Name: $userID \n video id: $origVid \n location: $target_path \n TmpName: $filetmpname \n extension: $extension \n Size: $fileSizeMB MegaBytes \n";
fwrite($fh, $stringData);
fclose($fh);
mysql_close();
// End log file edit

?>