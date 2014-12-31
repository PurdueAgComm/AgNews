<?php
session_start();
// global includes
include_once("../includes/db.php");

	// grab from db the email of the MMU contact
	$sql = "SELECT * FROM tblPeople WHERE strRole='Project Manager'";
	$result = mysql_query($sql);
	$contact = mysql_fetch_array($result);


	$email = $_POST["email"];
	$name = $_POST["name"];
	$phone = $_POST["phone"];
	$subject = "[AgNews DB] " . $_POST["topic"];
	$userMessage = $_POST["message"];

	$to = $contact["strEmail"];
	$message = "<html><body style='background-color: #fafafa;'>";
	$message .= "<table align='center' width='650' cellpadding='5' cellspacing='5' style='font-family: arial; border: 1px solid #a4a4a4; background-color: #FFF;'>";
	$message .= "<tr><td colspan='4' style='height: 80px; width: 610px; background-color:#FFF;'><img src='http://dev.www.purdue.edu/agnewsdb/img/emailupdate.jpg' alt='You have a new update from AgNews DB' /></td></tr>";
	$message .= "<tr><td colspan='3' width='75%'>&nbsp;</td> <td colspan='1' width='25%' align='right'>" . date("M d, Y") . "</td></tr>";
	$message .= "<tr><td colspan='4' style='background-color: #d9edf7;'><strong>" . $subject . "</strong></td></tr>";
	$message .= "<tr><td colspan='4' width='100%'>";
	$message .= "<p>This email was sent regarding the <a href='http://www.purdue.edu/agnewsdb'>Ag News Database</a>.</p>";
	$message .= "<table border='0'><tr><td>User:</td>";
	$message .= "<td>" . $name . " (" . $phone . ")</td></tr>";
	$message .= "<tr><td>Issue Topic:</td>";
	$message .= "<td>" . $_POST["topic"] . "</td></tr>";
	$message .= "<tr><td>Message:</td>";
	$message .= "<td>" . $userMessage . "</td></tr></table>";
	$message .= "</td></tr>";
	$message .= "</table>";
	$message .= "</body></html>";
	$message = chunk_split(base64_encode($message));
	$headers = "From:" . $email . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "Content-Transfer-Encoding: base64\r\n\r\n";
	mail($to,$subject,$message,$headers);

	$_SESSION["success"] = "Your email has been sent.";
	header("Location: ../contactHelp.php");


?>