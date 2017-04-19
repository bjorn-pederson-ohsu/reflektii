<?php
include("db.php");

$itemNum = $_POST['itemnum'];
$userID = $_POST['loginid'];
$timeStamp = $_POST['timestamp'];
 //$picnum = 23;
 
function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
 $image =$_FILES['Filedata']['name'];
 $uploadedfile = $_FILES['Filedata']['tmp_name'];
 $fileSizeMB = ($_FILES['Filedata']['size'] / 1024 / 1000);
  if ($image!=null) 
  {
  $filename = stripslashes($_FILES['Filedata']['name']);
  $extension = getExtension($filename);
  $extension = strtolower($extension);
  
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
 		{
		echo ' Unknown Image extension ';
			$errors=1;
  }
else
{
		$size=filesize($_FILES['Filedata']['size']);
 
		if ($size > 2097152)
				{
					echo "You have exceeded the size limit";
					$errors=1;
		}
 
if($extension=="jpg" || $extension=="jpeg" )
{
			$uploadedfile = $_FILES['Filedata']['tmp_name'];
			$src = imagecreatefromjpeg($uploadedfile);
}
else if($extension=="png")
{
			$uploadedfile = $_FILES['Filedata']['tmp_name'];
			$src = imagecreatefrompng($uploadedfile);
}
else 
{
			$src = imagecreatefromgif($uploadedfile);
}
 
list($width,$height)=getimagesize($uploadedfile);
$ratio_orig=$width/$height;

$newwidth=300;
$newheight=300;
if ($newwidth/$newheight > $ratio_orig) {
   $newwidth = $newheight*$ratio_orig;
} else {
   $newheight = $newwidth/$ratio_orig;
   }

$tmp=imagecreatetruecolor($newwidth,$newheight);

$newwidth1=30;
$newheight1=30;
if ($newwidth1/$newheight1 > $ratio_orig) {
   $newwidth1 = $newheight1*$ratio_orig;
} else {
   $newheight1 = $newwidth1/$ratio_orig;
   }
$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
imageinterlace($tmp);
imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);
imageinterlace($tmp1);
if (file_exists('pics/'.$userID)) {
    echo "The directory exists";
} else {
//if not, then php creates the directory. The permissions number is ignored by
//Windows.    
	mkdir('pics/'.$userID,0777);
}
if (file_exists('pics/'.$userID.'/'.$timeStamp)) {
    echo "The directory exists";
} else {
//if not, then php creates the directory. The permissions number is ignored by
//Windows.    
	mkdir('pics/'.$userID.'/'.$timeStamp,0777);
}

$filename = "pics/".$userID."/".$timeStamp."/".$timeStamp."_".$itemNum.".".$extension;
$filename1 = "pics/".$userID."/".$timeStamp."/small".$timeStamp."_".$itemNum.".".$extension;

imagejpeg($tmp,$filename,100);
imagejpeg($tmp1,$filename1,100);
//entering into Database 
$query1 = "SELECT * FROM rvideo WHERE vidname = '$timeStamp'";
$result= mysql_query($query1);
$row = mysql_fetch_assoc($result);
$origVid=$row['id'];
$query2 = "INSERT INTO vidpics (videoID,name,extension,number) VALUES ('$origVid','$timeStamp','$extension','$itemNum')";
$result = mysql_query($query2);
// This section edits your log file, if you don't need a text log file just delete these lines
$myFile = "piclogFile.txt";
$fh = fopen($myFile, 'a') or die("can't open file");
$stringData = "\n\n todayDate: ".date('l jS \of F Y h:i:s A')."  \n Name: $userID \n video id: $origVid \n location: $filename \n TmpName: $filetmpname \n extension: $extension \n Size: $fileSizeMB MegaBytes \n";
fwrite($fh, $stringData);
fclose($fh);
mysql_close();
imagedestroy($src);
imagedestroy($tmp);
imagedestroy($tmp1);
}
}


//If no errors registred, print the success message
 ?>