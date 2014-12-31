<?php
session_start();
include_once("../includes/db.php");

$_SESSION["email"] = $_POST["email"];
$action = $_GET["action"];


if($action != "unsub") {
	if(!empty($_SESSION["email"])) {
		$numResults = 0;
		$sql = "SELECT strEmail FROM tblNotify WHERE strEmail='" . $_SESSION["email"] . "';";
		$result = mysql_query($sql);
	 	$numResults = mysql_num_rows($result);


		if($numResults === 0) {
			$sql = "INSERT INTO tblNotify (strEmail) VALUES ('" . $_SESSION["email"] . "');";
			mysql_query($sql);
			$_SESSION["success"] = "<strong>Success!</strong> You'll be notified of future news stories when they're published.";
			header("Location: ../getNotified.php");
		}
		else {
			$_SESSION["error"] = "Woah, looks like you love getting our updates. Unfortunately, you can only sign up once and this email address is already registered. If you were trying to unsubscribe, you'll need to <a href='getNotified.php?action=unsub'>unsubscribe here</a>.";
			 header("Location: ../getNotified.php");

		}
	}
	else {
		$_SESSION["error"] = "<strong> Uh oh!</strong> Please don't just press buttons - fill out the email field before submitting!";
		header("Location: ../getNotified.php");

	}
}

if($action == "unsub") {
	if(!empty($_SESSION["email"])) {

		$sql = "SELECT strEmail FROM tblNotify WHERE strEmail='" . $_SESSION["email"] . "';";
		$result = mysql_query($sql);
		$numResults = mysql_num_rows($result);

		if($numResults == 1) {
		 	$numResults = mysql_num_rows($result);
			$sql = "DELETE FROM tblNotify WHERE strEmail='" . $_SESSION["email"] . "';";
			mysql_query($sql);
			$_SESSION["success"] = "<strong>Success!</strong> You have been unsubscribed.";
			header("Location: ../getNotified.php");
		}
		else {
			$_SESSION["error"] = "<strong>Uh oh!</strong> Unfortunately, your e-mail wasn't found. Were you trying to <a href='getNotified.php'>subscribe</a>?";
			header("Location: ../getNotified.php?action=unsub");
		}
	}
	else {
		$_SESSION["error"] = "<strong> Uh oh!</strong> Please don't just press buttons - fill out the email field before submitting!";
		header("Location: ../getNotified.php?action=unsub");
	}
}
echo "done";
	?>