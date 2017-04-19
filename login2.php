<?php
include("db.php");

//Assign the data passed from Flex to variables
$username = mysql_real_escape_string($_POST["test01"]);
$password = mysql_real_escape_string($_POST["test01"]);
//Query the database to see if the given username/password combination is valid.
$query = "SELECT * FROM tlogin WHERE name = '$username' AND pass = '$password'";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$logID=$row['primeid'];
$myName=$row['name'];
$query1 = "SELECT * FROM tprofile WHERE logID = '$logID'";
$result= mysql_query($query1);
$row=mysql_fetch_array($result);
$myCohort=$row['cohort'];
$myGrade=$row['gradelevel'];
if (!$myCohort || !$myGrade){
echo "no data";
} else {
$query2 = "SELECT * FROM cohorttype WHERE id != '$myCohort'";
$result2= mysql_query($query2);
//Open XML
echo "<?xml version=\"1.0\"?>\n";
echo"<mydata>\n";
//Create the XML
echo"<loginid>". $logID ."</loginid>\n";
echo"<label>". $myName ."</label>\n";
echo "<mycohort>" . $myCohort. "</mycohort>\n";
echo "<mygradelevel>" . $myGrade. "</mygradelevel>\n";
echo "<noncohort>\n";
while($out2 = mysql_fetch_array($result2)):
echo "<noncohorttitle>" . $out2['cohortlabel'] . "</noncohorttitle>\n";
echo "<noncohortid>" . $out2['id'] . "</noncohortid>\n";
endwhile;
echo "</noncohort>\n";
//close XML
echo"</mydata>";
}
//echo $output;
//Close the db
mysql_close();

?>