<?php
include("db.php");

//Assign the data passed from Flex to variables
$username = mysql_real_escape_string($_POST["username"]);
$password = mysql_real_escape_string($_POST["password"]);

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
$query3 = "SELECT * FROM gradetype WHERE id != '$myGrade'";
$result3= mysql_query($query3);
/*$query4 = "SELECT * FROM cohorttype WHERE id = '$myCohort'";
$result4= mysql_query($query4);
$out4 = mysql_fetch_assoc($result4)
$myCohortNum=$out4['id']
$query5= "SELECT * FROM gradetype WHERE id = '$myGrade'";
$result5= mysql_query($query5);
$out5 = mysql_fetch_assoc($result5)
$myGradeNum=$out5['id']*/

//Open XML
echo "<?xml version=\"1.0\"?>\n";
echo"<mydata>\n";
//Create the XML
echo"<loginid>". $logID ."</loginid>\n";
echo"<label>". $myName ."</label>\n";
echo "<mycohort>" . $myCohort. "</mycohort>\n";
//echo "<mycohortnum>" . $myCohortNum. "</mycohortnum>\n";
echo "<mygradelevel>" . $myGrade. "</mygradelevel>\n";
//echo "<mygradelevelnum>" . $myGradeNum. "</mygradelevelnum>\n";
echo "<noncohort>\n";
while($out2 = mysql_fetch_array($result2)):
echo "<noncohortid>" . $out2['id'] . "</noncohortid>\n";
echo "<noncohorttitle>" . $out2['cohortlabel'] . "</noncohorttitle>\n";
endwhile;
echo "</noncohort>\n";
echo "<nongrade>\n";
while($out3 = mysql_fetch_array($result3)):
echo "<nongradeid>" . $out3['id'] . "</nongradeid>\n";
echo "<nongradelevel>" . $out3['level'] . "</nongradelevel>\n";
endwhile;
echo "</nongrade>\n";
//close XML
echo"</mydata>";
}
//echo $output;
//Close the db
mysql_close();

?>