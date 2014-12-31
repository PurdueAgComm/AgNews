<?php
session_start();
include_once('../includes/db.php'); //includes db connection

$newsID = (int) $_GET["newsID"];
$action = $_GET["action"];


if($action == "recover") {
	$sql = "UPDATE tblNews SET isHidden=0 WHERE newsID=" . $newsID . " LIMIT 1";
	mysql_query($sql);

	// update activity log
	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (" . $newsID . ", " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Recovered story from deletion.');";
	mysql_query($sql);


	$_SESSION["success"] = "You've successfully recovered the story.";
	header("Location: ../index.php");



}
else{
	$sql = "UPDATE tblNews SET isHidden=1 WHERE newsID=" . $newsID . " LIMIT 1";
	mysql_query($sql);

	// update activity log
	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (" . $newsID . ", " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Deleted story.');";
	mysql_query($sql);

	$_SESSION["success"] = "The news story has been deleted.<br/><small>Mistake? <a href='functions/doDeleteStory.php?action=recover&newsID=" . $newsID . "'>Recover</a></small>.";
	header("Location: ../index.php");
}

?>