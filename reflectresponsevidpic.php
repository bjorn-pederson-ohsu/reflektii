<?php
include("db.php");

//Assign the data passed from Flash to variables
$typeVid=$_POST['typeVid'];
$videoID=$_POST['videoID'];
$userID=$_POST['userID'];
$time=$_POST['timestamp'];
$pic = $_POST['flashpic'];
$day = $_POST['day'];
$month = $_POST['month'];
$year = $_POST['year'];
$old="audioOnly.jpg";
//insert data into database
if ($typeVid == "response"){
$query = "INSERT INTO rvideo (primeid,vidname,vidType,month,day,year) VALUES ('$userID','$time','response','$month','$day','$year')";
$result = mysql_query($query);
$query2 = "SELECT * FROM rvideo WHERE vidname = '$videoID' && vidType = 'original'";
$result2=mysql_query($query2);
$row = mysql_fetch_assoc($result2);
$oriVid = $row['id'];
$query3 = "SELECT * FROM rvideo WHERE vidname = '$time'&& vidType = 'response'";
$result3=mysql_query($query3);
$row = mysql_fetch_assoc($result3);
$resVid = $row['id'];
$query4 = "INSERT INTO vidrelation (originalvidid,responsevidid) VALUES ('$oriVid','$resVid')";
$result4 = mysql_query($query4);
}else{
$query = "INSERT INTO rvideo (primeid,vidname,vidType,month,day,year) VALUES ('$userID','$time','original','$month','$day','$year')";
$result = mysql_query($query);
}
mysql_close();
if ($pic=="audio"){
if (file_exists('images/'.$userID)) {
    echo "The directory exists";
} else {
//if not, then php creates the directory. The permissions number is ignored by
//Windows.    
	mkdir("images/".$userID,0777);
}

if (!copy($old, 'images/'.$userID.'/'.$time.'_p.jpg')) {
    echo "failed to copy $old...\n";
}
}else{
//decode the base64
$pic = base64_decode($pic);
//dump the resulting string into a image object
$im = imagecreatefromstring($pic);
//set the max width and height for the thumbnail
$width = 100;
$height = 100;
//this is original ratio. The original script I pulled this from 
//was pulling in an actual file picutre upload and generating the 
//original width and height from that file. In this case, I knew what
//ratio I was working with all the time.
$ratio_orig = 320/240;
//checks to make sure the image object has something in it
if ($im !== false) {
    header('Content-Type: image/jpeg');
//checks the max values against the ratio and sets proportional values for the 
//thumbnail 
if ($width/$height > $ratio_orig) {
   $width = $height*$ratio_orig;
} else {
   $height = $width/$ratio_orig;
}
//creates container for the thumbnail 
$im_p = imagecreatetruecolor($width, $height);
//this resamples the main image down to the thumbnail. Pulled off of php.net
imagecopyresampled($im_p, $im, 0, 0, 0, 0, $width, $height, 320, 240);

// this was recommended so the thumbnail isn't progressive
    imageinterlace($im_p);
//checks to see if the directory the thumbnail is going to exists
	if (file_exists('images/'.$userID)) {
    echo "The directory exists";
} else {
//if not, then php creates the directory. The permissions number is ignored by
//Windows.    
	mkdir("images/".$userID,0777);
}
//writes the image to the jgp, with the path to the directory and the quality of the 
//jpg encoding. 
	imagejpeg($im_p, 'images/'.$userID.'/'.$time.'_p.jpg', (75));
//gets rid of the image objects stored in php, saves on memory.	
    imagedestroy($im_p);
	imagedestroy($im);	
}
else {
    echo 'An error occurred.';
}
}
?>