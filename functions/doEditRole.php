<?php
session_start();
// global includes
include_once('../includes/db.php'); // authenticate users, includes db connection

$roleAction = mysql_real_escape_string($_POST["roleAction"]);

if($roleAction == "administrator") {
	// update mmu contact
	$sqlCurrent = "UPDATE tblPeople SET strRole='' WHERE strRole='Project Manager' LIMIT 1";
	mysql_query($sqlCurrent);

	$sqlNew = "UPDATE tblPeople SET strRole='Project Manager' WHERE peopleID=" . (int) $_POST["manager"];
	mysql_query($sqlNew);

	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', '<strong>Changed the MMU Administrator.</strong>');";
	mysql_query($sql);
}

else if($roleAction == "assistant") {
	// update news assistant
	$sqlCurrent = "UPDATE tblPeople SET strRole='' WHERE strRole='News Assistant' LIMIT 1";
	mysql_query($sqlCurrent);

	$sqlNew = "UPDATE tblPeople SET strRole='News Assistant' WHERE peopleID=" . (int) $_POST["assistant"];
	mysql_query($sqlNew);

	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', '<strong>Changed the News Assistant.</strong>');";
	mysql_query($sql);

}
else if($roleAction == "coordinator") {
	// update coordinator for news unit
	$sqlCurrent = "UPDATE tblPeople SET strRole='' WHERE strRole='Coordinator' LIMIT 1";
	mysql_query($sqlCurrent);

	$sqlNew = "UPDATE tblPeople SET strRole='Coordinator' WHERE peopleID=" . (int) $_POST["coordinator"];
	mysql_query($sqlNew);

	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', '<strong>Changed the News Coordinator.</strong>');";
	mysql_query($sql);
}

$_SESSION["success"] = "You have updated the contact person for the " . $roleAction . " role.";
header("Location: ../editRoles.php");

?>