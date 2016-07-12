<?php
session_start();
include_once("../includes/db.php");
if($_SESSION["isAdmin"] != 1) {
	$_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
	header("Location: error.php");
}


$sql = "SELECT * FROM tblPeople WHERE isWriter=1";
$resultNews = mysql_query($sql);


$filename ="AgNews_Report_Writer_".date("m/d/Y").".xls";

$contents .= "HEADLINE\tDATE\tSTATUS\tWRITER\n";
$SQL = "SELECT * FROM tblNews INNER JOIN tblNewsWriterPeople ON tblNews.newsID = tblNewsWriterPeople.newsID WHERE tblNews.isHidden = 0 ORDER BY tblNewsWriterPeople.peopleID ASC";
$result = mysql_query($SQL);

while($story = mysql_fetch_array($result)) {

	// get headline or filename
	if(empty($story["strHeadline"])) {
		$headline = $story["strFilename"];
	}
	else {
		$headline = $story["strHeadline"];
	}

	// decide date output
	if($story["datePublished"] == "0000-00-00") {
		$date = "Unspecified";
	}
	else {
		$date = $story["datePublished"];
	}

	$contents .= $headline . "\t" . $date . "\t";

	if($story["stageID"] == 6) {
		$contents .= "Published\t";
	}
	else {
		$contents .= "Incomplete\t";
	}

	// get writer of the headline
	$sqlWriter = "SELECT strFirstName, strLastName FROM tblPeople WHERE peopleID = " . $story["peopleID"];
	$resultsWriter = mysql_query($sqlWriter);
	$writer = mysql_fetch_array($resultsWriter);

	// output writer of headline
	$contents .= $writer["strFirstName"] . " " . $writer["strLastName"] . "\n";
}


$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Exported report of news stories by writer.');";
mysql_query($sql);

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $contents;

?>