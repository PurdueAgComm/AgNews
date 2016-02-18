<?php

session_start();
include_once('../includes/db.php'); //includes db connection

$stageID = $_POST["stage"];
$newsID  = $_POST["newsID"];

if(!empty($stageID) && !empty($newsID)) {
	if($stageID == 6) {
		$sql2 = "SELECT * FROM tblNews INNER JOIN tblNewsArea ON tblNews.newsID=tblNewsArea.newsID WHERE tblNews.newsID=" . $newsID;
		$result2 = mysql_query($sql2);
		$news = mysql_fetch_array($result2);

		// if the URL is empty and the story has an area OTHER THAN 'notable' area type...
		if($news["strURL"] == "" && $news["areaID"] < 5) {
			$_SESSION["error"] = "You must enter the <a class='btn btn-mini btn-danger' href='editStory.php?newsID=" . $newsID . "#storyURL'>URL for the Purdue News Service version of the story</a> before publishing.";
			header("Location: ../beholdStory.php?newsID=" . $newsID);
			die();
		}
		else {
			$sql = "UPDATE tblNews SET stageID=" . $stageID . " WHERE newsID=" . $newsID;
			mysql_query($sql);
			$_SESSION["success"] = "You have successfully updated the progress of this story.";
		}
	}
	else {
		$sql = "UPDATE tblNews SET stageID=" . $stageID . " WHERE newsID=" . $newsID;
		mysql_query($sql);
		$_SESSION["success"] = "You have successfully updated the progress of this story.";
	}
}
else {
	$_SESSION["error"] .= "We couldn't verify the Stage ID number or the News ID number. Please contact your friendly AgComm web developer.";
	header("Location: ../beholdStory.php?newsID=" . $newsID);
}



if($stageID == 1) {

	$sql = "UPDATE tblNews SET statusID=1 WHERE newsID=" . $newsID;
	mysql_query($sql);

	$sql2 = "SELECT strStage FROM tblStage WHERE stageID=1;";
	$result2 = mysql_query($sql2);
	$stage = mysql_fetch_array($result2);

	// update activity feed
	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (" . $newsID . ", " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Set status to " . $stage["strStage"] . ".');";
	mysql_query($sql);

}


if($stageID == 2) {
	// get the e-mail of whoever is Coordinator from the database
	// alert them that the story is ready for review in a friendly e-mail

	$sql = "SELECT * FROM tblPeople WHERE strRole='Coordinator'";
	$result = mysql_query($sql);
	$coord = mysql_fetch_array($result);

	$sql2 = "SELECT * FROM tblNews WHERE newsID=" . $newsID;
	$result2 = mysql_query($sql2);
	$news = mysql_fetch_array($result2);


	$to = $coord["strEmail"];

	if(!empty($news["strHeadline"])) {
		$subject = "[AgNews DB] '" . $news["strHeadline"] . "' is ready for editing.";
		$title = $news["strHeadline"];
	}
	else {
		$subject = "[AgNews DB] '" . $news["strFilename"] . "' is ready for editing.";
		$title = $news["strFilename"];
	}

	$message = "<html><body style='background-color: #fafafa;'>";
	$message .= "<table align='center' width='650' cellpadding='5' cellspacing='5' style='font-family: arial; border: 1px solid #a4a4a4; background-color: #FFF;'>";
	$message .= "<tr><td colspan='4' style='height: 80px; width: 610px; background-color:#FFF;'><img src='http://dev.www.purdue.edu/agnewsdb/img/emailupdate.jpg' alt='You have a new update from AgNews DB' /></td></tr>";
	$message .= "<tr><td colspan='3' width='75%'>&nbsp;</td> <td colspan='1' width='25%' align='right'>" . date("M d, Y") . "</td></tr>";
	$message .= "<tr><td colspan='4' width='100%'>Hey " . $coord["strFirstName"] . ",<br/><br/>This email is to inform you that the story titled, <em><a style='color: #a37628;' href='http://www.purdue.edu/agnewsdb/beholdStory.php?newsID=" . $newsID . "'>" . $title. "</a></em> is ready for review. Please log into the AgNews DB, edit the story as neccessary, and then select the next stage when you're finished with your review.";
	$message .= "<br/><br />Thanks,<br />Ag Communications at Purdue</td></tr>";
	$message .= "</table>";
	$message .= "</body></html>";
	$message = chunk_split(base64_encode($message));
	$headers = "From:noreplyagnews@purdue.edu\r\n";
	//$headers .= "CC:knwilson@purdue.edu\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "Content-Transfer-Encoding: base64\r\n\r\n";


	//mail($to,$subject,$message,$headers);
	$_SESSION["success"] .= "<br /><strong>An e-mail has been sent to notify " . $coord["strFirstName"] . " " . $coord["strLastName"] . " that your story is ready for editing.</strong>";

	$sql = "UPDATE tblNews SET statusID=2 WHERE newsID=" . $newsID;
	mysql_query($sql);

	$sql2 = "SELECT strStage FROM tblStage WHERE stageID=2;";
	$result2 = mysql_query($sql2);
	$stage = mysql_fetch_array($result2);

	// update activity feed
	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (" . $newsID . ", " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Set status to " . $stage["strStage"] . ".');";
	mysql_query($sql);
}

if($stageID == 3) {
	// writer now needs to review edits
	// get the author who is associated with this story from the DB
	$sql = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $newsID;
	$result = mysql_query($sql);
	$writer = mysql_fetch_array($result);

	// get news info
	$sql2 = "SELECT * FROM tblNews WHERE newsID=" . $newsID;
	$result2 = mysql_query($sql2);
	$news = mysql_fetch_array($result2);

	$to = $writer["strEmail"];
	if(!empty($news["strHeadline"])) {
		$subject = "[AgNews DB] '" . $news["strHeadline"] . "' is ready for review.";
		$title = $news["strHeadline"];
	}
	else {
		$subject = "[AgNews DB] '" . $news["strFilename"] . "' is ready for review.";
		$title = $news["strFilename"];
	}

	$message = "<html><body style='background-color: #fafafa;'>";
	$message .= "<table align='center' width='650' cellpadding='5' cellspacing='5' style='font-family: arial; border: 1px solid #a4a4a4; background-color: #FFF;'>";
	$message .= "<tr><td colspan='4' style='height: 80px; width: 610px; background-color:#FFF;'><img src='http://dev.www.purdue.edu/agnewsdb/img/emailupdate.jpg' alt='You have a new update from AgNews DB' /></td></tr>";
	$message .= "<tr><td colspan='3' width='75%'>&nbsp;</td> <td colspan='1' width='25%' align='right'>" . date("M d, Y") . "</td></tr>";
	$message .= "<tr><td colspan='4' width='100%'>Hey " . $writer["strFirstName"] . ",<br/><br/>The story titled, <em><a style='color: #a37628;' href='http://www.purdue.edu/agnewsdb/beholdStory.php?newsID=" . $newsID . "'>" . $title . "</a></em> has been edited by the Coordinator and is now ready for your review.<br/><br />Thanks,<br />Ag Communications at Purdue</td></tr>";
	$message .= "</table>";
	$message .= "</body></html>";
	$message = chunk_split(base64_encode($message));
	$headers = "From:noreplyagnews@purdue.edu\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "Content-Transfer-Encoding: base64\r\n\r\n";

	//mail($to,$subject,$message,$headers);
	$_SESSION["success"] .= "<br /><strong>An e-mail has been sent to notify " . $writer["strFirstName"] . " " . $writer["strLastName"] . " that their story is ready for review.</strong>";

	$sql = "UPDATE tblNews SET statusID=1 WHERE newsID=" . $newsID;
	mysql_query($sql);

	$sql2 = "SELECT strStage FROM tblStage WHERE stageID=3;";
	$result2 = mysql_query($sql2);
	$stage = mysql_fetch_array($result2);

	// update activity feed
	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (" . $newsID . ", " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Set status to " . $stage["strStage"] . ".');";
	mysql_query($sql);

}

if($stageID == 4) {

	// source now gets to review the story
	// get the author  who is associated with this story from the DB
	$sql = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $newsID;
	$result = mysql_query($sql);
	$writer = mysql_fetch_array($result);

	// get news info
	$sql2 = "SELECT * FROM tblNews WHERE newsID=" . $newsID;
	$result2 = mysql_query($sql2);
	$news = mysql_fetch_array($result2);

	// get source associated with this story from DB
	$sql3 = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . $newsID;
	$result3 = mysql_query($sql3);
	$source = mysql_fetch_array($result3);

	if(!empty($news["strHeadline"])) {
		$title = $news["strHeadline"];
	}
	else {
		$title = $news["strFilename"];
	}

	$_SESSION["note"] = mysql_real_escape_string($_POST["note"]);

	if(!empty($_SESSION["note"])) {
		$note = "<strong>Writer's Note</strong>: ";
		$note .= $_SESSION["note"] . "<br /><br />";
	}
	else {
		$note = "";
	}

	$headers = "From: " . $writer["strEmail"];

  // Generate a boundary string
  $semi_rand = md5(time());
  $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

  // Add the headers for a file attachment
  $headers .= "\nMIME-Version: 1.0\n" .
  "Content-Type: multipart/mixed;\n" .
  " boundary=\"{$mime_boundary}\"";

  $content = "<html><body style='background-color: #fafafa;'>";
	$content .= "<table align='center' width='650' cellpadding='5' cellspacing='5' style='font-family: arial; border: 1px solid #a4a4a4; background-color: #FFF;'>";
	$content .= "<tr><td colspan='4' style='height: 80px; width: 610px; background-color:#FFF;'><img src='http://dev.www.purdue.edu/agnewsdb/img/emailupdate.jpg' alt='You have a new update from AgNews DB' /></td></tr>";
	$content .= "<tr><td colspan='3' width='65%'>&nbsp;</td> <td colspan='1' width='35%' align='right'>" . date("M d, Y") . "</td></tr>";
	$content .= "<tr><td colspan='4' width='100%'>Dear " . $source["strFirstName"] . ",<br/><br/>" . $note . "The news story titled <em>" . $title . "</em> that you are working on with <strong>" . $writer["strFirstName"] . " " . $writer["strLastName"] . "</strong> is ready for your review. The attached news release is ready for you to review. Please make any suggested edits in track-changes mode and then return the Word document to the writer. Thank you.<br/><br/></td></tr>";
	// $content .= "<tr><td bgcolor='dadada' colspan='4' style='background-color:#dadada;' width='100%' align='center'><strong>" . $title . "</strong></td></tr>";
	// $content .= "<tr><td colspan='4' width='100%'>" . html_entity_decode(htmlspecialchars_decode($news["txtBody"])) . "</td></tr>";
	$content .= "</table>";
	$content .= "</body></html>";


  // Add a multipart boundary above the plain message
  $message = "This is a multi-part message in MIME format.\n\n" .
  "--{$mime_boundary}\n" .
  "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
  "Content-Transfer-Encoding: 7bit\n\n" .
  $content . "\n\n";


	$body .= "<html>";
	$body .= "<table><tr><td colspan='2'>";
	$body .= "<img width='556' height='94' src='http://dev.www.purdue.edu/agnewsdb/img/agnewsheader.png' />";
	$body .= "</td></tr>";
	$body .= "<tr><td colspan='2'><br/>";
	$body .= "<h3><u>NEWS RELEASE</u></h3>";
	$body .= "<p>" . date("F d, Y", strtotime($news["datePublished"])) . "</p>";
	$body .= "<h3 style='font-size: 24pt; font-family: Cambria, Georgia, serif;'>" . $title . "</h3>";
	$body .= "<p style='font-size: 12pt; font-family: TimesNewRoman, \'Times New Roman\', Times, Baskerville, Georgia, serif;'>" .  html_entity_decode(htmlspecialchars_decode($news["txtBody"])) . "</p><br /><br />"; // <br /> to give space between story and information
	$body .= "</td></tr><tr><td>";
	$body .= "Writer(s)</td>";
	$body .= "<td>";

	$sqlWriters = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $newsID;
	$resultWriters = mysql_query($sqlWriters);
	while($writer = mysql_fetch_array($resultWriters)) {
		$body .= $writer["strFirstName"] . " " . $writer["strLastName"] . ", " . $writer["strPhone"] . ", " . $writer["strEmail"] . "<br />";
	}

	$body .= "</td></tr><tr><td>";
	$body .= "Source(s)</td>";
	$body .= "<td>";

	$sqlSources = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . $newsID;
	$resultSources = mysql_query($sqlSources);
	while($source = mysql_fetch_array($resultSources)) {
		$body .= $source["strFirstName"] . " " . $source["strLastName"] . ", " . $source["strPhone"] . ", " . $source["strEmail"] . "<br />";
	}

	$body .= "</td></tr><tr><td valign='top'><strong>Related Websites:</strong></td><td>";

	if(!empty($news["strWebsite1"])) {
			$body .= $news["strWebsiteTitle1"] . ": " . $news["strWebsite1"] . "<br />";
	}

	if(!empty($news["strWebsite2"])) {
			$body .= $news["strWebsiteTitle2"] . ": " . $news["strWebsite2"] . "<br />";
	}

	if(!empty($news["strWebsite3"])) {
			$body .= $news["strWebsiteTitle3"] . ": " . $news["strWebsite3"] . "<br />";
	}

	if(!empty($news["strWebsite4"])) {
			$body .= $news["strWebsiteTitle4"] . ": " . $news["strWebsite4"] . "<br />";
	}

	if(!empty($news["strWebsite5"])) {
			$body .= $news["strWebsiteTitle5"] . ": " . $news["strWebsite5"] . "<br />";
	}

	$body .= "</td></tr></table>";
	$body .= "</html>";

  // Base64 encode the file data
  $data = chunk_split(base64_encode($body));

  // Add file attachment to the message
  $message .= "--{$mime_boundary}\n" .
  "Content-Type: application/ms-word;\n" .
  " name=\"testfile.doc\"\n" .
  "Content-Disposition: attachment;\n" .
  " filename=\" " . date("ymd") . "_" . $news["strFilename"] . ".doc\"\n" .
  "Content-Transfer-Encoding: base64\n\n" .
  $data . "\n\n" .
  "--{$mime_boundary}--\n";


  // get source associated with this story from DB
	$sql3 = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . $newsID;
	$result3 = mysql_query($sql3);
	$source = mysql_fetch_array($result3);

	//TODO
 	//mail($source["strEmail"], "[AgComm News] " . $title . " is ready for review.", $message, $headers);
 	//mail("knwilson@purdue.edu", "[AgComm News] " . $title . " is ready for review.", $message, $headers);

	$_SESSION["success"] .= "<br /><strong>An e-mail has been sent to notify " . $source["strFirstName"] . " " . $source["strLastName"] . " that a source check is needed from them.</strong><br /><small>Follow up with your source to make sure that your email address is on their whitelist.</small>";

	$sql = "UPDATE tblNews SET statusID=2 WHERE newsID=" . $newsID;
	mysql_query($sql);

	$sql2 = "SELECT strStage FROM tblStage WHERE stageID=4;";
	$result2 = mysql_query($sql2);
	$stage = mysql_fetch_array($result2);

	// update activity feed
	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (" . $newsID . ", " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Set status to " . $stage["strStage"] . ".');";
	mysql_query($sql);

}

if($stageID == 5) {

	$sql = "SELECT * FROM tblPeople WHERE strRole='News Assistant'";
	$result = mysql_query($sql);
	$support = mysql_fetch_array($result);

	$sql2 = "SELECT * FROM tblNews WHERE newsID=" . $newsID;
	$result2 = mysql_query($sql2);
	$news = mysql_fetch_array($result2);

	$to = $support["strEmail"];

	if(!empty($news["strHeadline"])) {
		$subject = "[AgNews DB] '" . $news["strHeadline"] . "' has been submitted to M&M.";
		$title = $news["strHeadline"];
	}
	else {
		$subject = "[AgNews DB] '" . $news["strFilename"] . "' has been submitted to M&M.";
		$title = $news["strFilename"];
	}

	$message =  "<html><body style='background-color: #fafafa;'>";
	$message .= "<table align='center' width='650' cellpadding='5' cellspacing='5' style='font-family: arial; border: 1px solid #a4a4a4; background-color: #FFF;'>";
	$message .= "<tr><td colspan='4' style='height: 80px; width: 610px; background-color:#FFF;'><img src='http://dev.www.purdue.edu/agnewsdb/img/emailupdate.jpg' alt='You have a new update from AgNews DB' /></td></tr>";
	$message .= "<tr><td colspan='3' width='75%'>&nbsp;</td> <td colspan='1' width='25%' align='right'>" . date("M d, Y") . "</td></tr>";
	$message .= "<tr><td colspan='4' width='100%'>Hey " . $support["strFirstName"] . ",<br/><br/>This email is to inform you that the story titled, <em><a style='color: #a37628;' href='http://www.purdue.edu/agnewsdb/beholdStory.php?newsID=" . $newsID . "'>" . $title . "</a></em> has been submitted to M&M for review. Once approved, please log in and <strong>publish</strong> the story.<br/><br />Thanks,<br />Ag Communications at Purdue</td></tr>";
	$message .= "</table>";
	$message .= "</body></html>";
	$message =  chunk_split(base64_encode($message));
	$headers =  "From:noreplyagnews@purdue.edu\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "Content-Transfer-Encoding: base64\r\n\r\n";

	// mail($to,$subject,$message,$headers);
	$_SESSION["success"] .= "<br /><strong>An e-mail has been sent to notify " . $support["strFirstName"] . " " . $support["strLastName"] . " that your story has been submitted to M&M.</strong>";
	$sql = "UPDATE tblNews SET statusID=2 WHERE newsID=" . $newsID;
	mysql_query($sql);

	$sql2 = "SELECT strStage FROM tblStage WHERE stageID=5;";
	$result2 = mysql_query($sql2);
	$stage = mysql_fetch_array($result2);

	// update activity feed
	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (" . $newsID . ", " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Set status to " . $stage["strStage"] . ".');";
	mysql_query($sql);
}

if($stageID == 6) {
	// SENDING OUT EMAIL TO PEOPLE ON NOTIFICATION LIST
	// get the author  who is associated with this story from the DB
	$sql = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $newsID;
	$result = mysql_query($sql);
	$writer = mysql_fetch_array($result);

	// get news info
	$sql2 = "SELECT * FROM tblNews WHERE newsID=" . $newsID;
	$result2 = mysql_query($sql2);
	$news = mysql_fetch_array($result2);

	// get source associated with this story from DB
	$sql3 = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . $newsID;
	$result3 = mysql_query($sql3);
	$source = mysql_fetch_array($result3);

	$sql4 = "SELECT strEmail FROM tblNotify";
	$result4 = mysql_query($sql4);

	while($recipient = mysql_fetch_array($result4)) {
		$to = $recipient["strEmail"];

		if(!empty($news["strHeadline"])) {
			$subject = "[AgNews DB] '" . $news["strHeadline"] . "' is now published.";
			$title = $news["strHeadline"];
		}
		else {
			$subject = "[AgNews DB] '" . $news["strFilename"] . "' is now published.";
			$title = $news["strFilename"];
		}

		$message = "<html><body style='background-color: #fafafa;'>";
		$message .= "<table align='center' width='650' cellpadding='5' cellspacing='5' style='font-family: arial; border: 1px solid #a4a4a4; background-color: #FFF;'>";
		$message .= "<tr><td colspan='4' style='height: 80px; width: 610px; background-color:#FFF;'><img src='http://dev.www.purdue.edu/agnewsdb/img/emailupdate.jpg' alt='You have a new update from AgNews DB' /></td></tr>";
		$message .= "<tr><td colspan='3' width='75%'>&nbsp;</td> <td colspan='1' width='25%' align='right'>" . date("M d, Y") . "</td></tr>";
		$message .= "<tr><td colspan='4' width='100%'>Hello,<br/><br/>The story titled, <em><a style='color: #a37628;' href='" . $news["strURL"] . "'>" . $title . "</a></em> has been published and is now live. The writer for this story is " . $writer["strFirstName"]  . "  " . $writer["strLastName"] . " and the lead source is " . $source["strFirstName"] . " " . $source["strLastName"] . ".<br/><br />Thanks,<br />Ag Communications at Purdue</td></tr>";
		$message .= "</table>";
		$message .= "</body></html>";
		$message = chunk_split(base64_encode($message));
		$headers = "From:noreplyagnews@purdue.edu\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "Content-Transfer-Encoding: base64\r\n\r\n";
		//mail($to,$subject,$message,$headers);
	}

	// EMAIL AGCOMM WEB TEAM FOR EXTENSION DEPOT STORY POSTING
	$sqlArea = "SELECT newsID FROM tblNewsArea WHERE newsID=" . $newsID . " AND areaID=4";
	$resultArea = mysql_query($sqlArea);
	$areaNum = mysql_num_rows($resultArea);

	// Do I need to do this? Currently, no...
	// $sqlArea = "SELECT tblNews.newsID FROM tblNewsArea JOIN tblNews ON tblNewsArea.newsID=tblNews.newsID WHERE tblNewsArea.newsID=" . $newsID . " AND areaID=2 AND strVideo <> ''";
	// $resultARPAlert = mysql_query($sqlArea);
	// $areaNumARPAlert = mysql_num_rows($resultArea);

	$sqlWriters = "SELECT * FROM tblPeople JOIN tblNewsWriterPeople ON tblPeople.peopleID = tblNewsWriterPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $newsID;
	$resultWriters = mysql_query($sqlWriters);
	$numWriters = mysql_num_rows($resultWriters);

	$sqlIssues = "SELECT * FROM tblIssues JOIN tblNewsIssues ON tblIssues.issuesID = tblNewsIssues.issuesID WHERE tblNewsIssues.newsID=" . $newsID . " AND tblIssues.isHidden=0";
	$resultIssues = mysql_query($sqlIssues);
	$numIssues = mysql_num_rows($resultIssues);

	$sqlTopics = "SELECT * FROM tblTopic JOIN tblNewsTopic ON tblTopic.topicID = tblNewsTopic.topicID WHERE tblNewsTopic.newsID=" . $newsID . " AND tblTopic.isHidden=0";
	$resultTopics = mysql_query($sqlTopics);
	$numTopics = mysql_num_rows($resultTopics);

	// if the area is Extension Depot News...
	if($areaNum > 0) {
		$to = "";
		$sqlDepotNewsReceivers = "SELECT strFirstName, strEmail FROM tblPeople WHERE isDepotNews=1";
		$resultDepotNewsReceivers = mysql_query($sqlDepotNewsReceivers);
		while($depotNewsReceivers = mysql_fetch_array($resultDepotNewsReceivers)) {
			$to .= $depotNewsReceivers["strEmail"] . ", ";
		}

		if(!empty($news["strHeadline"])) {
			$subject = "[Depot] '" . $news["strHeadline"] . "' needs to be added to the Depot.";
			$title = $news["strHeadline"];
		}
		else {
			$subject = "[Depot] '" . $news["strFilename"] . "' needs to be added to the Extension Depot.";
			$title = $news["strFilename"];
		}
		$message = "<html><body style='background-color: #fafafa;'>";
		$message .= "<table align='center' width='650' cellpadding='5' cellspacing='5' style='font-family: arial; border: 1px solid #a4a4a4; background-color: #FFF;'>";
		$message .= "<tr><td colspan='4' style='height: 80px; width: 610px; background-color:#FFF;'><img src='http://dev.www.purdue.edu/agnewsdb/img/emailupdate.jpg' alt='You have a new update from AgNews DB' /></td></tr>";
		$message .= "<tr><td colspan='3' width='75%'>&nbsp;</td> <td colspan='1' width='25%' align='right'>" . date("F d, Y") . "</td></tr>";
		$message .= "<tr><td colspan='4' width='100%'>Quick, there's work to be had! The News Unit has published a news article that needs to be added to <a href='http://extension.purdue.edu/depot'>The Extension Depot</a>.</td></tr>";
		$message .= "<tr style='background-color: #dadada'><td colspan='4' style='text-align: center;'><strong>General Information</strong></td></tr>";
		$message .= "<tr><td width='10%'><strong>Admin</strong></td><td width='*' colspan='3'><a href='https://www.purdue.edu/agnewsdb/beholdStory.php?newsID=" . $newsID . "'>View Article in News DB</a></td></tr>";
		$message .= "<tr><td><strong>Topics</strong></td><td colspan='3'>";
		$i = 0;
		while($topics = mysql_fetch_array($resultTopics)) {
			if($i < $numTopics-1) {
				$message .= $topics["strTopic"] . ", ";
			}
			else {
				$message .= $topics["strTopic"];
			}
			$i++;
		}
		$message .= "</td></tr>";
		$message .= "<tr><td><strong>Issues</strong></td><td colspan='3'>";
		$i = 0;
		while($issues = mysql_fetch_array($resultIssues)) {
			if($i < $numIssues-1) {
				$message .= $issues["strIssues"] . ", ";
			}
			else {
				$message .= $issues["strIssues"];
			}
			$i++;
		}
		$message .= "<tr><td width='10%'><strong>URL</strong></td><td width='*' colspan='3'>" . $news["strURL"] . "</td></tr>";
		$message .= "<tr><td width='10%'><strong>Headline</strong></td><td width='*' colspan='3'>" . $news["strHeadline"] . "</td></tr>";
		$message .= "<tr><td width='10%'><strong>Writers</strong></td><td width='*' colspan='3'>";
		$i = 0;
		while($writer = mysql_fetch_array($resultWriters)) {
			if($i < $numWriters-1) {
				$message .= $writer["strFirstName"] . " " . $writer["strLastName"] . ", ";
			}
			else {
				$message .= $writer["strFirstName"] . " " . $writer["strLastName"];
			}
			$i++;
		}
		$message .= "</td></tr>";

		if($news["strVideo"] != "" || $news["strImage"] != "") {

			$message .= "<tr style='background-color: #E3AE24;'><td colspan='4' style='text-align: center;'><strong>Multimedia Assets</strong></td></tr>";
		}

		if($news["strVideo"] != "") {
			$message .= "<tr><td width='10%'><strong>Video</strong></td><td width='*' colspan='3'>" . $news["strVideo"] . "</td></tr>";
		}
		if($news["strImage"] != "") {
			$message .= "<tr><td width='10%'><strong>Image</strong></td><td width='*' colspan='3'>" . $news["strImage"] . "</td></tr>";
		}

		$message .= "<tr style='background-color: #dadada'><td colspan='4' style='text-align: center;'><strong>Article</strong></td></tr>";

		// is it a research story? if so append the textArea with more information...
		$sqlAreaARP = "SELECT newsID FROM tblNewsArea WHERE newsID=" . $newsID . " AND areaID=2";
		$resultAreaARP = mysql_query($sqlAreaARP);
		$areaNumARP = mysql_num_rows($resultAreaARP);
		if($areaNumARP > 0) {
			$message .= "<tr><td valign='top'><strong>Article</strong></td><td colspan='3'>" . html_entity_decode(htmlspecialchars_decode($news["txtBody"])) . "<br />For more information about research, visit <a href='https://ag.purdue.edu/arp'>Ag Research at Purdue</a>.</td></tr>";

		}
		else {
			$message .= "<tr><td valign='top'><strong>Article</strong></td><td colspan='3'>" . html_entity_decode(htmlspecialchars_decode($news["txtBody"])) . "</td></tr>";
		}

		$message .= "</table>";
		$message .= "</body></html>";
		$message = chunk_split(base64_encode($message));
		$headers = "From:noreplyagnews@purdue.edu\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "Content-Transfer-Encoding: base64\r\n\r\n";
		//mail($to,$subject,$message,$headers);
	}

	$sql = "UPDATE tblNews SET statusID=3 WHERE newsID=" . $newsID;
	mysql_query($sql);

	$sql2 = "SELECT strStage FROM tblStage WHERE stageID=6;";
	$result2 = mysql_query($sql2);
	$stage = mysql_fetch_array($result2);

	// update activity feed
	$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (" . $newsID . ", " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Set status to " . $stage["strStage"] . ".');";
	mysql_query($sql);

	//update publish date
	$sql = "UPDATE tblNews SET datePublished='" . date("Y-m-d") . "' WHERE newsID=" . $newsID;
	mysql_query($sql);

	// social media information
	if(empty($news["strTweet"])) {
		$_SESSION["tweetHeadline"] = $news["strHeadline"];
	}
	else {
		$_SESSION["tweetHeadline"] = $news["strTweet"];
		$_SESSION["customTweet"] = 1;
	}

	$_SESSION["tweetURL"] = $news["strURL"];

	header("Location: ../social.php");
	die();

}

header("Location: ../beholdStory.php?newsID=" . $newsID);



?>