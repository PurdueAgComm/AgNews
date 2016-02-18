<?php
session_start();
include_once("../includes/db.php");

// grab varibles from other page
// **07-27: This escapes the apostrophe with a \. The \ does not go in the database but must be removed in the "success" message. http://nyphp.org/PHundamentals/5_Storing-Data-Submitted-Form-Displaying-Database
$_SESSION["firstNameAdd"] = mysql_real_escape_string(str_replace('"', "''", $_POST["firstName"]));
$_SESSION["lastNameAdd"] = mysql_real_escape_string(str_replace('"', "''", $_POST["lastName"]));

$_SESSION["emailAdd"] = mysql_escape_string($_POST["email"]);
$_SESSION["phoneAdd"] = mysql_escape_string($_POST["phone"]);
$_SESSION["aliasAdd"] = mysql_escape_string($_POST["alias"]);

$_SESSION["isWriterAdd"] = (int) $_POST["isWriter"];
$_SESSION["isSupportAdd"] = (int) $_POST["isSupport"];
$_SESSION["isAdminAdd"] = (int) $_POST["isAdmin"];
$_SESSION["isSourceAdd"] = (int) $_POST["isSource"];

$_SESSION["firstNameError"] = 0;
$_SESSION["lastNameError"] = 0;
$_SESSION["emailError"] = 0;
$_SESSION["phoneError"] = 0;
$_SESSION["errorCounter"] = 0;
$_SESSION["aliasError"] = 0;
$_SESSION["rolesError"] = 0;

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

if((empty($_SESSION["isAdminAdd"])) && (empty($_SESSION["isWriterAdd"])) && (empty($_SESSION["isSupportAdd"]) && (empty($_SESSION["isSourceAdd"])))) {
	// if empty
	$_SESSION["rolesError"] = 1;
	$_SESSION["errorCounter"]++;
	$_SESSION["error"] = "Please assign a role to this user.";
}

if(empty($_SESSION["emailAdd"])) {
	$_SESSION["emailError"] = 1;
	$_SESSION["errorCounter"]++;
	$_SESSION["error"] = "We didn't get an email address, could you help us out? Please complete the field with a valid email address.";
}

if(empty($_SESSION["lastNameAdd"])) {
	$_SESSION["lastNameError"] = 1;
	$_SESSION["emailError"] = 0;
	$_SESSION["errorCounter"]++;
	$_SESSION["error"] = "Everyone has a name. Can you complete the last name field?";

}

if(empty($_SESSION["firstNameAdd"])) {
	// if empty
	$_SESSION["firstNameError"] = 1;
	$_SESSION["lastNameError"] = 0;
	$_SESSION["emailError"] = 0;
	$_SESSION["errorCounter"]++;
	$_SESSION["error"] = "Everyone has a name. Can you complete the first name field?";
}

// check for duplicate users
$query = mysql_query("SELECT * FROM tblPeople WHERE strEmail = ('" . $_SESSION["emailAdd"] . "') ");
$row = mysql_fetch_array($query);

if(mysql_num_rows($query) != 0) {
	$_SESSION["emailError"] = 1;
	$_SESSION["errorCounter"]++;

	$_SESSION["error"] = "Our database shows <strong>". $row[strFirstName]. " ". $row[strLastName]. "</strong> is assigned the email address entered below and is in our database.<br> <a rel='tooltip' title='Create a new Source profile' href='/agnewsdb/editUser.php' role='button' class='btn btn-small btn-danger'><strong> " . $row[strEmail]. " </strong> is assigned to a source in our database. Please go to Edit User if you want to add a staff role to ". $row[strFirstName]. " ". $row[strLastName]. "</a>";

}

// if there are no errors
if($_SESSION["errorCounter"] == 0)
{
	// Set user strRole field
	if($_SESSION["isAdminAdd"]==1)  {
		$sql = "INSERT INTO tblPeople (alias, strFirstName, strLastName, strRole, strEmail, strPhone, isAdmin, isSupport, isWriter, isSource) VALUES ('" . $_SESSION["aliasAdd"] . "', '" . $_SESSION["firstNameAdd"] . "', '" . $_SESSION["lastNameAdd"] . "', '" . "Administrator" . "' ,'" . $_SESSION["emailAdd"] . "', '" . $_SESSION["phoneAdd"] . "', " . $_SESSION["isAdminAdd"]  . ", " . $_SESSION["isSupportAdd"]  . ", " . $_SESSION["isWriterAdd"]  . ", " . $_SESSION["isSourceAdd"]  . ");";
		mysql_query($sql);
  }

  else if($_SESSION["isSupportAdd"]==1)  {
		$sql = "INSERT INTO tblPeople (alias, strFirstName, strLastName, strRole, strEmail, strPhone, isAdmin, isSupport, isWriter, isSource) VALUES ('" . $_SESSION["aliasAdd"] . "', '" . $_SESSION["firstNameAdd"] . "', '" . $_SESSION["lastNameAdd"] . "', '" . "Support" . "' ,'" . $_SESSION["emailAdd"] . "', '" . $_SESSION["phoneAdd"] . "', " . $_SESSION["isAdminAdd"]  . ", " . $_SESSION["isSupportAdd"]  . ", " . $_SESSION["isWriterAdd"]  . ", " . $_SESSION["isSourceAdd"]  . ");";
		mysql_query($sql);
	}

	else if($_SESSION["isWriterAdd"]==1)  {
		$sql = "INSERT INTO tblPeople (alias, strFirstName, strLastName, strRole, strEmail, strPhone, isAdmin, isSupport, isWriter, isSource) VALUES ('" . $_SESSION["aliasAdd"] . "', '" . $_SESSION["firstNameAdd"] . "', '" . $_SESSION["lastNameAdd"] . "', '" . "Writer" . "' ,'" . $_SESSION["emailAdd"] . "', '" . $_SESSION["phoneAdd"] . "', " . $_SESSION["isAdminAdd"]  . ", " . $_SESSION["isSupportAdd"]  . ", " . $_SESSION["isWriterAdd"]  . ", " . $_SESSION["isSourceAdd"]  . ");";
		//TODO: REMOVE COMMENT BELOW
		//mysql_query($sql);
		// email Extension Depot Manager about addition of new WRITERS
		$sql = "SELECT strEmail FROM tblPeople WHERE strRole='Extension Depot Manager' LIMIT 1";
		$result = mysql_query($sql);
		$depotManger = mysql_fetch_array($result);
		$to = $depotManger["strEmail"];
		$subject = "[AgNews] A writer needs to be added to the Extension Depot";
		$message = "<html><body style='background-color: #fafafa;'>";
		$message .= "<table align='center' width='650' cellpadding='5' cellspacing='5' style='font-family: arial; border: 1px solid #a4a4a4; background-color: #FFF;'>";
		$message .= "<tr><td colspan='4' style='height: 80px; width: 610px; background-color:#FFF;'><img src='http://dev.www.purdue.edu/agnewsdb/img/emailupdate.jpg' alt='You have a new update from AgNews DB' /></td></tr>";
		$message .= "<tr><td colspan='3' width='75%'>&nbsp;</td> <td colspan='1' width='25%' align='right'>" . date("M d, Y") . "</td></tr>";
		$message .= "<tr><td colspan='4' width='100%'>Hey,<br/><br/>";
		$message .= "<p>A new writer <strong>" . $_SESSION["firstNameAdd"] . " " . $_SESSION["lastNameAdd"] . "</strong>, their alias is <strong>" . $_SESSION["aliasAdd"] . "</strong>. If you have questions, the writer was added by " . $_SESSION["firstName"] . " " . $_SESSION["lastName"] . " (" . $_SESSION["userEmail"] . ").</p>";
		$message .= "<p>Here's a <a href='https://extension.purdue.edu/depot/AuthorControl.aspx'>handy link to the author control page in the Extension Depot</a>.</p>";
		$message .= "<p>Thanks,<br />Mankind</p>";
		$message .= "</td></tr>";
		$message .= "</table>";
		$message .= "</body></html>";
		$message = chunk_split(base64_encode($message));
		$headers = "From:noreplyagnews@purdue.edu\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "Content-Transfer-Encoding: base64\r\n\r\n";
		mail($to,$subject,$message,$headers);
	}
  else if($_SESSION["isSourceAdd"]==1)  {
		$sql = "INSERT INTO tblPeople (alias, strFirstName, strLastName, strRole, strEmail, strPhone, isAdmin, isSupport, isWriter, isSource) VALUES ('" . $_SESSION["aliasAdd"] . "', '" . $_SESSION["firstNameAdd"] . "', '" . $_SESSION["lastNameAdd"] . "', '" . "Source" . "' ,'" . $_SESSION["emailAdd"] . "', '" . $_SESSION["phoneAdd"] . "', " . $_SESSION["isAdminAdd"]  . ", " . $_SESSION["isSupportAdd"]  . ", " . $_SESSION["isWriterAdd"]  . ", " . $_SESSION["isSourceAdd"]  . ");";
		mysql_query($sql);;
  }
	// add an activity
	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', '<strong>Added " . $_SESSION["firstNameAdd"] . " " . $_SESSION["lastNameAdd"] . "</strong>');";
	mysql_query($sql);

	// redirect with success message
	// **07-27: we need the stripslashes to return without any \'s.
	$_SESSION["success"] = "You've successfully added <strong>" . htmlspecialchars(stripslashes($_SESSION["firstNameAdd"]), ENT_QUOTES) . " " . htmlspecialchars(stripslashes($_SESSION["lastNameAdd"]), ENT_QUOTES) . "</strong>.";
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
	header("Location: ../addUser.php");
}
else {
	// return user to last page
	header("Location: ../addUser.php");
}
?>