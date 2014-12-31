<?php
session_start();
include_once("../includes/db.php");
if($_SESSION["isAdmin"] != 1) {
	$_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
	header("Location: ../error.php");
}


$sql = "SELECT * FROM tblNews WHERE newsID=" . (int) $_GET["newsID"];
$resultNews = mysql_query($sql);
$news = mysql_fetch_array($resultNews);


$filename = date("ydm") . "_" . $news["strFilename"] . ".doc";

	if(!empty($news["strHeadline"])) {
		$title = $news["strHeadline"];
	}
	else {
		$title = $news["strFilename"];
	}


	$body .= "<html>";
	$body .= "<table><tr><td colspan='2'>";
	$body .= "<img width='556' height='94' src='http://dev.www.purdue.edu/agnewsdb/img/agnewsheader.png' />";
	$body .= "</td></tr>"; 
	$body .= "<tr><td colspan='2'><br/>";
	$body .= "<h3><u>NEWS RELEASE</u></h3>";
	
	if(($news["datePublished"] != "0000-00-00")) {
	$body .= "<p>" . date("F d, Y", strtotime($news["datePublished"])) . "</p>";
	}

	$body .= "<h3 style='font-size: 24pt; font-family: Cambria, Georgia, serif;'>" . $title . "</h3>";
	
	$body .= "<p style='font-size: 12pt; font-family: TimesNewRoman, \'Times New Roman\', Times, Baskerville, Georgia, serif;'>" . html_entity_decode(htmlspecialchars_decode(str_replace("&amp;lt;p&amp;gt;",'&amp;lt;p&amp;gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $news["txtBody"]))) . str_replace("&amp;lt;p&amp;gt;&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;&amp;lt;/p&amp;gt;", '&amp;lt;p&amp;gt;', $news["textBody"]) . "</p><br /><br />"; // <br /> to give space between story and information
	$body .= "</td></tr><tr><td style='font-size: 10pt;'>"; 
	$body .= "Writer(s)</td>";
	$body .= "<td style='font-size: 10pt;'>";

		$sqlWriters = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . (int) $_GET["newsID"];
		$resultWriters = mysql_query($sqlWriters);
		while($writer = mysql_fetch_array($resultWriters)) {
			$body .= $writer["strFirstName"] . " " . $writer["strLastName"] . ", " . $writer["strPhone"] . ", " . $writer["strEmail"] . "<br />";
		}

	$body .= "</td></tr><tr><td style='font-size: 10pt;'>";
	$body .= "Source(s)</td>"; 
	$body .= "<td style='font-size: 10pt;'>";

		$sqlSources = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . (int) $_GET["newsID"];
		$resultSources = mysql_query($sqlSources);
		while($source = mysql_fetch_array($resultSources)) {
			$body .= $source["strFirstName"] . " " . $source["strLastName"] . ", " . $source["strPhone"] . ", " . $source["strEmail"] . "<br />";
		}

	$body .= "</td></tr><tr><td valign='top' style='font-size: 10pt;'><strong>Related Websites:</strong></td><td style='font-size: 10pt;'>";

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


 $sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (" . (int) $_GET["newsID"] . ", " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Downloaded a Word copy.');";
 mysql_query($sql);

header('Content-type: application/msword');
header('Content-Disposition: attachment; filename='.$filename);
echo $body;

?>