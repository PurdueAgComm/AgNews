<?php
session_start();
include_once("../includes/db.php");
if($_SESSION["isAdmin"] != 1) {
	$_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
	header("Location: error.php");
}


$sql = "SELECT * FROM tblDept";
$resultNews = mysql_query($sql);


$filename ="AgNews_Dept_Report_".date("m/d/Y").".xls";

$headings .= "Headline" . "\t" . "Date Published" . "\t" . "Department" . "\t" . "Story Status" . "\t" . "Science Story" . "\t" . "Agriculture Top Story" . "\t" . "Extension Top Story" . "\n";
$r = 2;


while($header = mysql_fetch_array($resultNews)) {

	$SQL = "SELECT * FROM tblNews INNER JOIN tblNewsDept ON tblNews.newsID = tblNewsDept.newsID WHERE tblNews.isHidden = 0 AND tblNewsDept.deptID=" . $header["deptID"] . " ORDER BY tblNews.stageID ASC";
	$result = mysql_query($SQL);
	while($story = mysql_fetch_array($result)) {

		$contents .= $story["strHeadline"] . "\t" . $story["datePublished"] . "\t" . $header["strDeptName"] . "\t";
		if($story["stageID"] == 6) {
			$contents .= "Published\t";
		}
		else {
			$contents .= "Not Completed\t";
		}
		
				if($story["isScience"] > 0) {
			    $contents .= "Science\t";
		   }
	    	else {
		    	$contents .= "\t";
		   }
				
				if($story["isTopStory"] > 0) {
		    	$contents .= "Top Story\t";
	    	}
	    	else {
			$contents .= "\t";
	    	}
							
				if($story["isExtTopStory"] > 0) {
		    	$contents .= "Extension Top Story\n";
	    	}
	    	else {
			$contents .= "\n";
	    	}
  
	}


}

$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Exported report of news stories by department.');";
mysql_query($sql);

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $headings;
echo $contents;

?>