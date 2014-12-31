<?php
session_start();
include_once("../includes/db.php");
if($_SESSION["isAdmin"] != 1) {
	$_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
	header("Location: error.php");
}




$filename ="AgNews_Report_".date("m/d/Y").".xls";

//column headings
$headings = "Published News Releases" . "\n";
$headings.= "Linked News Release Headline" . "\t" . "Date Published" . "\t" . "News Release Headline" . "\n";

//First two rows are headings. First grab the cell in the third row for hyperlinking
$r = 3;
			

$sql = "SELECT * FROM tblNews INNER JOIN tblNewsWriterPeople ON tblNews.newsID = tblNewsWriterPeople.newsID WHERE tblNews.isHidden = 0 AND tblNews.stageID=6 GROUP BY tblNews.newsID ORDER BY tblNews.datePublished DESC";
$result2 = mysql_query($sql);
while($story = mysql_fetch_array($result2)) {
	
        $url = '= HYPERLINK("' . $story["strURL"] . '", C'. $r . ') ';
		$contents .= $url . "\t" . $story["datePublished"] . "\t" . $story["strHeadline"] . "\n";
        ++$r;



}


$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Exported report of news stories by writer.');";
mysql_query($sql);

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $headings;
echo $contents;

?>