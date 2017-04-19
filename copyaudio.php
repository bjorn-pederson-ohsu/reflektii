<?php
include("db.php");
$userID="16";
$time="seeingIfThisWorks";
$old="audioOnly.jpg";

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
?>