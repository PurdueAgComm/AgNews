<?php
session_start();
// global includes
include_once('../includes/db.php'); // authenticate users, includes db connection


$emailTest = preg_match("/^[a-zA-Z0-9]+@[a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]/", mysql_real_escape_string($_POST["email"]));

if(!empty($_POST["email"]) && $emailTest == "1") {
	$sql = "UPDATE tblPeople SET strEmail='" . mysql_real_escape_string($_POST["email"])  . "' WHERE strRole='MM';";
	mysql_query($sql);

	$_SESSION["success"] = "You have updated the email contact in M&M for AgComm News.";
}
else {
	$_SESSION["error"] = "Please enter a valid email address as the contact.";
}

header("Location: ../projectList.php");

?>