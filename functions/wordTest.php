<?php
session_start();
include_once("../includes/db.php");
if($_SESSION["isAdmin"] != 1) {
	$_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
	header("Location: ../error.php");
}


$sql = "SELECT * FROM tblArea";
$resultNews = mysql_query($sql);


$filename ="AgNews_Report_".date("m/d/Y").".doc";

$contents .= "<html>";
$contents .= "<table width='100%'><tr><td>";
$contents .= "<img width='556' height='132' src='http://dev.www.purdue.edu/agnewsdb/img/agnewsheader.png' />";
$contents .= "</td></tr>"; 
$contents .= "<tr><td>";
$contents .= "<h3>News Title</h3>";
$contents .= "<p>";


while($header = mysql_fetch_array($resultNews)) {
	$contents .= "#############  " . $header["strArea"] . "  #############\n";
	
	$SQL = "SELECT * FROM tblNews INNER JOIN tblNewsArea ON tblNews.newsID = tblNewsArea.newsID WHERE tblNews.isHidden = 0 AND tblNewsArea.areaID=" . $header["areaID"] . " ORDER BY tblNews.stageID ASC";
	$result = mysql_query($SQL);
	while($story = mysql_fetch_array($result)) {

		$contents .= $story["strHeadline"] . "\t" . $story["datePublished"] . "\t";
		if($story["stageID"] == 6) {
			$contents .= "Published\n";
		}
		else {
			$contents .= "Not Completed\n";
		}

	}


}

$contents .= "</p></td></tr></table>";
$contents .= "</html>";


// $sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Exported report of news stories by area.');";
// mysql_query($sql);

header('Content-type: application/msword');
header('Content-Disposition: attachment; filename='.$filename);
echo $contents;

?>