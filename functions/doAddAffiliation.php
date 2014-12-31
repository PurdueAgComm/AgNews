<?php
session_start();
include_once("../includes/db.php"); 

// grab varibles from other page
// **07-27: This escapes the apostrophe with a \. The \ does not go in the database but must be removed in the "success" message. http://nyphp.org/PHundamentals/5_Storing-Data-Submitted-Form-Displaying-Database
// $_POST is needing the "name" of the input field.
$_SESSION["affiliationAdd"] = mysql_real_escape_string(str_replace('"', "''", $_POST["affiliation"])); 
$_SESSION["affiliationError"] = 0;
$_SESSION["isHiddenError"] = 0;
$_SESSION["errorCounter"] = 0;

//VALIDATE


//if error send back
// if success write to database
// send success message

if(empty($_SESSION["affiliationAdd"])) 
{
  // if empty
  $_SESSION["affiliationError"] = 1;
  $_SESSION["errorCounter"]++;
  $_SESSION["error"] = "Can you complete the affiliation name field?";
  header("Location: ../addAffiliation.php");
}


// check for duplicate affiliations. 
$query = mysql_query("SELECT * FROM tblAffiliation WHERE strAffiliation = ('" . $_SESSION["affiliationAdd"] . "') ");
$row = mysql_fetch_array($query);
 
  if(mysql_num_rows($query) != 0) 
  {
    $_SESSION["affiliationError"] = 1;
    $_SESSION["errorCounter"]++;
    
    $_SESSION["error"] = "Our database shows <strong>". $row[strAffiliation]. "</strong> is in our database. Type in a different affiliation or check the archived list of affiliations for possible activation.<br> <a rel='tooltip' title='Create a new Department profile' href='/agnewsdb/editAffiliation.php#archAfilliation' role='button' class='btn btn-small btn-danger'>Please go to Edit Affiliation if you want to make the affiliation active.</a>";
  }

  if($_SESSION["errorCounter"] <= 0) 
  { 
  
    $sql = "INSERT INTO tblAffiliation (strAffiliation, isHidden) VALUES ('" . $_SESSION['affiliationAdd'] . "',  " .  '0'  . ");";
    mysql_query($sql);
           
    // **07-27: we need the stripslashes to return without any \'s.
    $_SESSION["success"] = "You've successfully added <strong>" . htmlspecialchars(stripslashes($_SESSION["affiliationAdd"]), ENT_QUOTES) . "</strong>.";
    // redirect with success message
    header("Location: ../editAffiliation.php");
   
	//activity log for the affiliation activation
	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', '<strong>Added the affiliation <em>" . $_SESSION["affiliationAdd"] . "</em>.</strong>');";
	mysql_query($sql);
	
	
  // clear session variables
  $_SESSION["affiliationAdd"] ="";
  $_SESSION["isHiddenAdd"] = "";  

  }
  else
  {
  // return user to last page
  header("Location: ../addAffiliation.php");
  }
  
?>