<?php
session_start();


// global includes
include_once("../includes/db.php");

// Function page for issues.php
// creates, edits, hides, activates issues/validates
// #############################################################
// Grab information from last page and save
// #############################################################
	
	
// grab variables from other page and assign to the session variable	
	
     $_SESSION["issueAdd"] = mysql_real_escape_string($_POST["issueAdd"]);
	 $_SESSION["issueEdDel"] = mysql_real_escape_string($_POST["issueEdDel"]);
	 $_SESSION["issueActivate"] = mysql_real_escape_string($_POST["issueActivate"]);
	 $_SESSION["issueID"] = mysql_real_escape_string($_POST["issueID"]);


// if a new issue is requested
if(isset($_POST['submit']))
{

		
//Validate for an existing issue
//$issue = $_POST["issueAdd"];
$query = mysql_query("SELECT * FROM tblIssues WHERE strIssues=('" . $_SESSION["issueAdd"] . "')");
 
if(mysql_num_rows($query) != 0)
 {
 //-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
 $_SESSION["error"] = "The issue, <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["issueAdd"]), ENT_QUOTES) . " " . "</strong>, already exists. Instead of creating a new one with the same name, activiate it below.";
	header("Location: ../issues.php");
 }
 else
 
//Check for a blank field for those without Javascript turned on
	if(empty($_SESSION["issueAdd"])) {
		// if empty
		$_SESSION["issueAddError"] = 1;
		$_SESSION["errorCounter"]++;
		
// return user to last page
		$_SESSION["error"] = "We didn't receive a name for your new issue. Try submitting again.";
		header("Location: ../issues.php");
	}
	else
 {

//success, enter the issue
	$sql = "INSERT INTO tblIssues (strIssues) VALUE ('" . $_SESSION["issueAdd"] . "');";
		mysql_query($sql);

// show a success
//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
$_SESSION["success"] = "You've successfully added <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["issueAdd"]), ENT_QUOTES) . " " . "</strong> as an issue.";	

//activity log for the adding an Issue
$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'You added the new Issue <em>" . $_SESSION["issueAdd"] . "</em>.');";
mysql_query($sql);
} 
}

// if an edit is asked
else if(isset($_POST['edit']))
{
	
//Validate for an existing issue
//$issue = $_POST["issueEdDel"];
$query = mysql_query("SELECT * FROM tblIssues WHERE strIssues=('" . $_SESSION["issueAdd"] . "')");
 
if(mysql_num_rows($query) != 0)
 {
 $_SESSION["error"] = "The issue you specified already exists, instead of creating a new one with the same name, activiate it below.";
	header("Location: ../issues.php");
 }
else

//Check for a blank field for those without Javascript turned on
	if(empty($_SESSION["issueEdDel"])) {
		// if empty
		$_SESSION["issueEdDelError"] = 1;
		$_SESSION["errorCounter"]++;
		
// return user to last page
		$_SESSION["error"] = "We didn't receive a name for your edited issue. Try submitting again.";
		header("Location: ../issues.php");
	}
	else

{	

//success, enter the issue
	$sql = "UPDATE tblIssues SET strIssues = ('" . $_SESSION["issueEdDel"] . "') WHERE tblIssues.issuesID = ('" . $_SESSION["issueID"] ."')";
		mysql_query($sql);
		

// show a success
//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
$_SESSION["success"] = "You've successfully edited the issue to <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["issueEdDel"]), ENT_QUOTES) . " " . "</strong>.";

//activity log for the issue edit
$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Edited the Issue <em>" . $_SESSION["issueEdDel"] . "</em>.');";
mysql_query($sql);

}
}
// if a deletion is requested
else if(isset($_POST['delete']))
{ 
   //  var_dump($_POST['issueEdDel']);

	$sql = "UPDATE tblIssues SET isHidden = 1 WHERE tblIssues.issuesID = ('" . $_SESSION["issueID"] ."')";
 		mysql_query($sql);

	
//Change the Hidden value to "hide"	
			$sql = "UPDATE tblNewsIssues SET isHidden = 1 WHERE tblNewsIssues.issuesID = ('" . $_SESSION["issueID"] ."')";
		mysql_query($sql);

// show a success
//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
$_SESSION["success"] = "You've successfully deactiviated <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["issueEdDel"]), ENT_QUOTES) . " " . "</strong>.";	


//activity log for the deleted
$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Archived the issue <em>" . $_SESSION["issueEdDel"] . "</em>.');";
mysql_query($sql);

}

// if an activation is requested
else if(isset($_POST['reSubmit']))
{ 
//echo (" this is ".$_SESSION["issueID"]." ID when the check button is pressed");

	$sql = "UPDATE tblIssues SET isHidden = 0 WHERE tblIssues.issuesID = ('" . $_SESSION["issueID"] ."')";
		mysql_query($sql);
		
//Change the Hidden value to activate	
			$sql = "UPDATE tblNewsIssues SET isHidden = 0 WHERE tblNewsIssues.issuesID = ('" . $_SESSION["issueID"] ."')";
		mysql_query($sql);
		
// show a success
//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
$_SESSION["success"] = "You've successfully activated <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["issueActivate"]), ENT_QUOTES) . " " . "</strong>.";	

//activity log for the issue activation
$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Activated the issue <em>" . $_SESSION["issueActivate"] . "</em>.');";
mysql_query($sql);
	
}


$_SESSION["issueAddError"] = 0;
$_SESSION["issueEdDelError"] = 0;
$_SESSION["issueActivateError"] = 0;
$_SESSION["errorCounter"] = 0;




// if there are no errors
if ($_SESSION["errorCounter"] == 0) 
{

	// clear session variables
	$_SESSION["issueAdd"] = "";
	$_SESSION["issueEdDel"] = "";
	$_SESSION["issueActivate"] = "";	
	$_SESSION["issueID"] = "";		
		
    header("Location: ../issues.php");

}

?>