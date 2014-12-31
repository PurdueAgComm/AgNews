<?php
session_start();


// global includes
include_once("../includes/db.php");

// Function page for topics.php
// creates, edits, hides, activates topics/validates
// #############################################################
// Grab information from last page and save
// #############################################################
	
	
// grab variables from other page and assign to the session variable	
	
     $_SESSION["topicAdd"] = mysql_real_escape_string($_POST["topicAdd"]);
	 $_SESSION["topicEdDel"] = mysql_real_escape_string($_POST["topicEdDel"]);
	 $_SESSION["topicActivate"] = mysql_real_escape_string($_POST["topicActivate"]);
	 $_SESSION["topicID"] = mysql_real_escape_string($_POST["topicID"]);


// if a new topic is requested
if(isset($_POST['submit']))
{
//echo (" this is ".$_SESSION["topicAdd"]." the submit button");

		
//Validate for an existing topic
//$topic = $_POST["topicAdd"];
$query = mysql_query("SELECT * FROM tblTopic WHERE strTopic=('" . $_SESSION["topicAdd"] . "')");
 
if(mysql_num_rows($query) != 0)
 {
//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
$_SESSION["error"] = "The topic, <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["topicAdd"]), ENT_QUOTES) . " " . "</strong>, already exists. Instead of creating a new one with the same name, activiate it below.";
	header("Location: ../topics.php");
 }
 else
 
//Check for a blank field for those without Javascript turned on
	if(empty($_SESSION["topicAdd"])) {
		// if empty
		$_SESSION["topicAddError"] = 1;
		$_SESSION["errorCounter"]++;
		
// return user to last page
		$_SESSION["error"] = "We didn't receive a name for your new topic. Try submitting again.";
		header("Location: ../topics.php");
	}
	else
 {

//success, enter the topic
	$sql = "INSERT INTO tblTopic (strTopic) VALUE ('" . $_SESSION["topicAdd"] . "');";
		mysql_query($sql);

// show a success
//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
$_SESSION["success"] = "You've successfully added <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["topicAdd"]), ENT_QUOTES) . " " . "</strong> as an topic.";	

//activity log for the adding a Topic
$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Added the new Topic <em>" . $_SESSION["topicAdd"] . "</em>.');";
mysql_query($sql);
} 
}

// if an edit is asked
else if(isset($_POST['edit']))
{
	
//Validate for an existing topic
//$topic = $_POST["topicEdDel"];
$query = mysql_query("SELECT * FROM tblTopic WHERE strTopic=('" . $_SESSION["topicAdd"] . "')");
 
if(mysql_num_rows($query) != 0)
 {
//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
$_SESSION["error"] = "The topic, <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["topicAdd"]), ENT_QUOTES) . " " . "</strong>, already exists. Instead of creating a new one with the same name, activiate it below.";
	header("Location: ../topics.php");
 }
else

//Check for a blank field for those without Javascript turned on
	if(empty($_SESSION["topicEdDel"])) {
		// if empty
		$_SESSION["topicEdDelError"] = 1;
		$_SESSION["errorCounter"]++;
		
// return user to last page
		$_SESSION["error"] = "We didn't receive a name for your edited topic. Try submitting again.";
		header("Location: ../topics.php");
	}
	else

{	

//success, enter the topic
	$sql = "UPDATE tblTopic SET strTopic = ('" . $_SESSION["topicEdDel"] . "') WHERE tblTopic.topicID = ('" . $_SESSION["topicID"] ."')";
		mysql_query($sql);

// show a success
//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
$_SESSION["success"] = "You've successfully edited the topic to <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["topicEdDel"]), ENT_QUOTES) . "</strong>.";	

//activity log for the editing a Topic
$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Edited the Topic <em>" . $_SESSION["topicEdDel"] . "</em>.');";
mysql_query($sql);
}
}
// if a deletion is requested
else if(isset($_POST['delete']))
{ 
   //  var_dump($_POST['topicEdDel']);

	$sql = "UPDATE tblTopic SET isHidden = 1 WHERE tblTopic.topicID = ('" . $_SESSION["topicID"] ."')";
 		mysql_query($sql);
		
//Change the Hidden value to activate	
			$sql = "UPDATE tblNewsTopic SET isHidden = 1 WHERE tblNewsTopic.topicID = ('" . $_SESSION["topicID"] ."')";
		mysql_query($sql);
		

// show a success
//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
$_SESSION["success"] = "You've successfully deactivated <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["topicEdDel"]), ENT_QUOTES) . " " . "</strong>.";	


//activity log for the deleting a Topic
$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Archived the topic <em>" . $_SESSION["topicEdDel"] . "</em>.');";
mysql_query($sql);
}

// if an activation is requested
else if(isset($_POST['reSubmit']))
{ 
//echo (" this is ".$_SESSION["topicID"]." ID when the check button is pressed");

	$sql = "UPDATE tblTopic SET isHidden = 0 WHERE tblTopic.topicID = ('" . $_SESSION["topicID"] ."')";
		mysql_query($sql);
		
//Change the Hidden value to activate	
			$sql = "UPDATE tblNewsTopic SET isHidden = 0 WHERE tblNewsTopic.topicID = ('" . $_SESSION["topicID"] ."')";
		mysql_query($sql);
		
		
// show a success
//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
$_SESSION["success"] = "You've successfully activated <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["topicActivate"]), ENT_QUOTES) . " " . "</strong>.";	


//activity log for the activating a Topic
$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Activated the topic <em>" . $_SESSION["topicActivate"] . "</em>.');";
mysql_query($sql);
	
}


$_SESSION["topicAddError"] = 0;
$_SESSION["topicEdDelError"] = 0;
$_SESSION["topicActivateError"] = 0;
$_SESSION["errorCounter"] = 0;




// if there are no errors
if ($_SESSION["errorCounter"] == 0) 
{

	// clear session variables
	$_SESSION["topicAdd"] = "";
	$_SESSION["topicEdDel"] = "";
	$_SESSION["topicActivate"] = "";	
	$_SESSION["topicID"] = "";		
		
    header("Location: ../topics.php");

}

?>