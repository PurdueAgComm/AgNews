<?php
session_start();
include_once("../includes/db.php"); 

// grab varibles from other page
// **07-27: This escapes the apostrophe with a \. The \ does not go in the database but must be removed in the "success" message. http://nyphp.org/PHundamentals/5_Storing-Data-Submitted-Form-Displaying-Database
// $_POST is needing the "name" of the input field.
$_SESSION["deptNameAdd"] = mysql_real_escape_string(str_replace('"', "''", $_POST["department"])); 
$_SESSION["collegeAdd"] = mysql_real_escape_string(str_replace('"', "''", $_POST["college"]));

$_SESSION["deptNameError"] = 0;
$_SESSION["collegeError"] = 0;
$_SESSION["errorCounter"] = 0;

//VALIDATE


//if error send back
// if success write to database
// send success message

if(empty($_SESSION["deptNameAdd"])) 
{
  // if empty
  $_SESSION["deptNameError"] = 1;
  $_SESSION["errorCounter"]++;
  $_SESSION["error"] = "Can you complete the department name field?";
}

else if(empty($_SESSION["collegeAdd"])) 
{
  $_SESSION["collegeError"] = 1;
  $_SESSION["errorCounter"]++;
  $_SESSION["error"] = "We didn't get a college or entity name. Could you help us out? Please complete the field with the college associated with the department.";
}

// check for duplicate departments. The reason for only checking the first name is this is all that shows in the dropdown. 
//Two of the same department names in the dropdown would be impossible to differentiate.
$query = mysql_query("SELECT * FROM tblDept WHERE strDeptName = ('" . $_SESSION["deptNameAdd"] . "') ");
$row = mysql_fetch_array($query);
 
  if(mysql_num_rows($query) != 0) 
  {
    $_SESSION["deptNameError"] = 1;
	$_SESSION["collegeError"] = 0;
    $_SESSION["errorCounter"]++;
    
    $_SESSION["error"] = "Our database shows <strong>". $row[strDeptName]. "</strong> is in our database. Type in a different department name or check the archived list of departments for possible activation.<br> <a rel='tooltip' title='Create a new Department profile' href='/agnewsdb/editDept.php#archDept' role='button' class='btn btn-small btn-danger'>Please go to Edit Department if you want to make the department active.</a>";
  }

  if($_SESSION["errorCounter"] <= 0) 
  { 
    $sql = "INSERT INTO tblDept (strDeptName, strCollege, isHidden) VALUES ('" . $_SESSION['deptNameAdd'] . "', '" . $_SESSION['collegeAdd'] . "',  " .  '0'  . ");";
    mysql_query($sql);
           
    // **07-27: we need the stripslashes to return without any \'s.
    $_SESSION["success"] = "You've successfully added <strong>" . htmlspecialchars(stripslashes($_SESSION["deptNameAdd"]), ENT_QUOTES) . "</strong>" . ", " . "<strong>" . htmlspecialchars(stripslashes($_SESSION["collegeAdd"]), ENT_QUOTES) . "</strong>.";
    // redirect with success message
    header("Location: ../editDept.php");
   
	//activity log for the department activation
	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', '<strong>Added the department <em>" . $_SESSION["deptNameAdd"] . "</em>.</strong>');";
	mysql_query($sql);
	
	
  // clear session variables
  $_SESSION["deptNameAdd"] ="";
  $_SESSION["collegeAdd"] = "";
  $_SESSION["isHiddenAdd"] = "";  

  }
  else
  {
  // return user to last page
  header("Location: ../addDept.php");
  }
  
?>