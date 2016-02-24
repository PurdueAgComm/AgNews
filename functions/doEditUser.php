<?php
session_start();
include_once("../includes/db.php");

$userID = $_GET["userID"];

// grab variables from other page
// **07-27: This escapes the apostrophe with a \. The \ does not go in the database but must be removed in the "success" message. http://nyphp.org/PHundamentals/5_Storing-Data-Submitted-Form-Displaying-Database
$_SESSION["firstNameAdd"] = mysql_real_escape_string(str_replace('"', "''", $_POST["firstName"]));
$_SESSION["lastNameAdd"] = mysql_real_escape_string(str_replace('"', "''", $_POST["lastName"]));

//FYI, the double quotes do have a \, then why do they break things later? When I do a str_replace, everything works
//inlcuding the editStory

$_SESSION["emailAdd"] = mysql_escape_string($_POST["email"]);
$_SESSION["phoneAdd"] = mysql_escape_string($_POST["phone"]);
$_SESSION["aliasAdd"] = mysql_escape_string($_POST["alias"]);

$_SESSION["isWriterAdd"] = (int) $_POST["isWriter"];
$_SESSION["isSupportAdd"] = (int) $_POST["isSupport"];
$_SESSION["isAdminAdd"] = (int) $_POST["isAdmin"];
$_SESSION["isSourceAdd"] = (int) $_POST["isSource"];

// does the user want to receive emails when depot news is sent out?
$_SESSION["isDepotNews"] = (int) $_POST["isDepotNews"];

$_SESSION["Error"] = 0;
$_SESSION["lastNameError"] = 0;
$_SESSION["emailError"] = 0;
$_SESSION["phoneError"] = 0;
$_SESSION["errorCounter"] = 0;
$_SESSION["aliasError"] = 0;


//VALIDATE

//if error send back
// if success write to database
// send success message
$emailTest = preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]/", mysql_real_escape_string($_POST["email"]));
$phoneTest = preg_match("/^[2-9]\d{2}-\d{3}-\d{4}$/", mysql_real_escape_string($_POST["phone"]));

if($emailTest == 0) {
	$_SESSION["emailError"] = 1;
	$_SESSION["errorCounter"]++;
	$_SESSION["error"] = "A valid email wasn't entered. Please try again.";
}

if(!empty($_SESSION["phoneAdd"]) && $phoneTest == 0) {
	$_SESSION["phoneError"] = 1;
	$_SESSION["errorCounter"]++;
	$_SESSION["error"] = "Please enter a valid phone number in this format: XXX-XXX-XXXX. Please try again.";
}

if(empty($_SESSION["aliasAdd"]) && ((!empty($_SESSION["isAdminAdd"]) || (!empty($_SESSION["isWriterAdd"])) || (!empty($_SESSION["isSupportAdd"]))))) {
	// if empty AND the writer, support and admin have NOT been checked. We do not need the alias for the sources.
	$_SESSION["aliasError"] = 1;
	$_SESSION["phoneError"] = 0;
	$_SESSION["errorCounter"]++;
	$_SESSION["error"] = "An alias is required for a user to sign in to the NewsDB. Ask them what their alias is, they should know. Prompt them by reminding them that this is the username that they use to log into a computer at Purdue. An alias is <strong>not</strong> necessarily the first part of their email.";
}

if(empty($_SESSION["emailAdd"])) {
	$_SESSION["emailError"] = 1;
	$_SESSION["errorCounter"]++;
	$_SESSION["error"] = "We didn't get an email address, could you help us out? Please complete the field with a valid email address.";
}

if(empty($_SESSION["lastNameAdd"])) {
	$_SESSION["lastNameError"] = 1;
	$_SESSION["errorCounter"]++;
	$_SESSION["error"] = "Everyone has a name. Can you complete the last name field?";

}

if(empty($_SESSION["firstNameAdd"])) {
	// if empty
	$_SESSION["firstNameError"] = 1;
	$_SESSION["errorCounter"]++;
	$_SESSION["error"] = "You left the first name field empty. Please complete the field.";
}

// if there are no errors
if($_SESSION["errorCounter"] == 0)
{
	// do your SQL statement
	$sql = "UPDATE tblPeople SET strFirstName='" . $_SESSION["firstNameAdd"] . "', strLastName='" . $_SESSION["lastNameAdd"] . "', alias='" . $_SESSION["aliasAdd"] . "', strPhone='" . $_SESSION["phoneAdd"] . "', strEmail='" . $_SESSION["emailAdd"] . "', isWriter=" . $_SESSION["isWriterAdd"] . ", isSupport=" . $_SESSION["isSupportAdd"] . ", isAdmin=" . $_SESSION["isAdminAdd"] . ", isSource=" . $_SESSION["isSourceAdd"] . ", isDepotNews=" . $_SESSION["isDepotNews"] . " WHERE peopleID=" . $userID;
  mysql_query($sql) or die(mysql_error());

	// add an activity
	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Updated the profile of " . $_SESSION["firstNameAdd"] . " " . $_SESSION["lastNameAdd"] . "');";
	mysql_query($sql);


// CHECK USER ROLE -- this writes to the strRole column and users are added to the list on the page

	 $sql = "SELECT strRole FROM tblPeople WHERE peopleID=" . $userID;
     $result= mysql_query($sql);
	 $row = mysql_fetch_array($result);


  if($row["strRole"]!="Project Manager")  {
    if ($row["strRole"]!="Coordinator")  {
	  if($row["strRole"]!="IT")  {
	     if($row["strRole"]!="News Assistant")  {
        if($row["strRole"]!="Extension Depot Manager")  {


	     if($_SESSION["isAdminAdd"]==1)  {

	       $sql = "UPDATE tblPeople SET strRole= '" . "Administrator" . "' WHERE peopleID=" . $userID;
           mysql_query($sql);
         }

            else if($_SESSION["isSupportAdd"]==1)  {

	           $sql = "UPDATE tblPeople SET strRole= '" . "Support" . "' WHERE peopleID=" . $userID;
               mysql_query($sql);
            }

              else if($_SESSION["isWriterAdd"]==1)  {

	            $sql = "UPDATE tblPeople SET strRole= '" . "Writer" . "' WHERE peopleID=" . $userID;
                mysql_query($sql);
            }

                 else if($_SESSION["isSourceAdd"]==1)  {

	                $sql = "UPDATE tblPeople SET strRole= '" . "Source" . "' WHERE peopleID=" . $userID;
                    mysql_query($sql);
                 }
               }
		 }
	  }
	}
  }

	// redirect with success message
	// **07-27: we need the stripslashes to return without any \'s.
	$_SESSION["success"] = "You've successfully edited the profile of <strong>" . htmlspecialchars(stripslashes($_SESSION["firstNameAdd"]), ENT_QUOTES) . " " . htmlspecialchars(stripslashes($_SESSION["lastNameAdd"]), ENT_QUOTES) . "</strong>.";
	// clear session variables
	$_SESSION["firstNameAdd"] ="";
	$_SESSION["lastNameAdd"] = "";
	$_SESSION["emailAdd"] = "";
	$_SESSION["phoneAdd"] = "";
	$_SESSION["aliasAdd"] = "";
	$_SESSION["isWriterAdd"] = "";
	$_SESSION["isSupportAdd"] = "";
	$_SESSION["isAdminAdd"] = "";
	$_SESSION["isSourceAdd"] = "";

	header("Location: ../editUser.php");

}
else {
	// return user to last page
	// 07-27: was going to the edit page list instead of staying with the error
	header("Location: ../editUser.php?userID=" . $userID);
}
?>