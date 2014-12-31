<?php
session_start();
include_once("../includes/db.php");
if($_SESSION["isAdmin"] != 1) {
	$_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
	header("Location: error.php");
}


$sql = "SELECT * FROM tblPeople WHERE isWriter=1";
$resultNews = mysql_query($sql);


$filename ="AgNews_Report_".date("m/d/Y").".xls";

$headings .= "Linked News Release Headline" . "\t" . "Date Published" . "\t" . "Writer" . "\t" . "News Release Headline" . "\n";
$r = 2;
			
while($header = mysql_fetch_array($resultNews)) {

	$SQL = "SELECT * FROM tblNews INNER JOIN tblNewsWriterPeople ON tblNews.newsID = tblNewsWriterPeople.newsID WHERE tblNews.isHidden = 0 AND tblNewsWriterPeople.peopleID=" . $header["peopleID"] . " ORDER BY tblNewsWriterPeople.peopleID ASC";
	$result = mysql_query($SQL);
	while($story = mysql_fetch_array($result)) {

        // grab only the published stories 		
		if($story["stageID"] == 6) {
			


            $url = '= HYPERLINK("' . $story["strURL"] . '", D'. $r . ') ';
			$contents .=  $url . "\t" . $story["datePublished"] . "\t" . $header["strFirstName"] . " " . $header["strLastName"] . "\t" . $story["strHeadline"] . "\n";
            ++$r;

		}

	}

}

$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Exported report of news stories by writer.');";
mysql_query($sql);

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $headings;
echo $contents;

?>