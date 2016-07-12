<?php
session_start();
include_once("../includes/db.php");
if($_SESSION["isAdmin"] != 1) {
	$_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
	header("Location: error.php");
}
$_SESSION["datePublishedBegin"] = mysql_real_escape_string($_POST["datePublishedBegin"]);
$_SESSION["datePublishedEnd"] = mysql_real_escape_string($_POST["datePublishedEnd"]);

$_SESSION["dateCreatedBegin"] = mysql_real_escape_string($_POST["dateCreatedBegin"]);
$_SESSION["dateCreatedEnd"] = mysql_real_escape_string($_POST["dateCreatedEnd"]);

$_SESSION["publish"] = mysql_real_escape_string($_POST["publish"]);
$_SESSION["create"] = mysql_real_escape_string($_POST["create"]);

$_SESSION["datePublishedBeginError"] = 0; 
$_SESSION["datePublishedEndError"] = 0; 
$_SESSION["dateCreatedBeginError"] = 0; 
$_SESSION["dateCreatedEndError"] = 0; 
$_SESSION["errorCounter"] = 0; 

$sql = "SELECT * FROM tblNews";
$resultNews = mysql_query($sql);


$filename ="AgNews_Report_by_Date_".date("m/d/Y").".xls";

//column headings
$headings = "News ID" . "\t" . "Date Published" . "\t" . "headline" . "\t" . "Ag Answers" . "\t" . "is Video" . "\t" . "Columns" . "\t" . "Agriculture Top Story" . "\t" . "Extension Top Story" . "\n";

//First two rows are headings. First grab the cell in the third row for hyperlinking
$r = 2; //start on this row with headings taking row 1

//******I want to find a way to hyperlink without the extra headings column **************



//******************************************************************************
//*****************DATE VALIDATION***********************************
//******************************************************************************
	
// check to see if BOTH publish and create are empty OR both are checked.	
if (empty($_SESSION["publish"]) && empty($_SESSION["create"]) || (!empty($_SESSION["publish"]) && !empty($_SESSION["create"])))

{	// if the publish AND the create checks are NOT empty
	if (!empty($_SESSION["publish"]) && !empty($_SESSION["create"]))
	
	{
         // since both the publish and create dates are requested, check that a full date range is entered for each date lane
		if ((!empty($_SESSION["datePublishedBegin"]) || !empty($_SESSION["datePublishedEnd"])) || (!empty($_SESSION["dateCreatedBegin"]) || !empty($_SESSION["dateCreatedEnd"])) )
		
		{		
	
				if (empty($_SESSION["datePublishedBegin"]))
				{
					$_SESSION["datePublishedBeginError"] = 1;	
					$_SESSION["datePublishedEndError"] = 0; 	
					$_SESSION["errorCounter"]++; 	

				}
				 else if (empty($_SESSION["datePublishedEnd"]))
				{
					$_SESSION["datePublishedEndError"] = 1; 
					$_SESSION["datePublishedBeginError"] = 0;	
					$_SESSION["errorCounter"]++; 				
					
				}
				if (empty($_SESSION["dateCreatedBegin"]))
				{
					$_SESSION["dateCreatedBeginError"] = 1;	
					$_SESSION["datePublishedEndError"] = 0;		
					$_SESSION["errorCounter"]++; 											
					
				}
				 else if (empty($_SESSION["dateCreatedEnd"]))
				{
					$_SESSION["dateCreatedEndError"] = 1; 
					$_SESSION["dateCreatedBeginError"] = 0;		
					$_SESSION["errorCounter"]++; 					
				}
													
					$_SESSION["errorCounter"]++; 				
					$_SESSION["error"] = "We didn't receive the necessary date parameters. Try submitting your date range again.";
					header("Location: ../reportDate.php");
			}	
				die("done");	 
		
		} // END publish and create boxes are checked


	
	$sql = "SELECT * FROM tblNews INNER JOIN tblNewsWriterPeople ON tblNews.newsID = tblNewsWriterPeople.newsID WHERE tblNews.isHidden = 0 GROUP BY tblNews.newsID ORDER BY tblNews.datePublished DESC";
	$result2 = mysql_query($sql);
		while($story = mysql_fetch_array($result2)) 		
		{	
			$url = '= HYPERLINK("' . $story["strURL"] . '", B'. $r . ') ';
			$contents .= $url . "\t" . $story["strHeadline"] . "\t" . $story["newsID"] . "\t" . $story["datePublished"] . "\t" . $story["strHeadline"] . "\t" . $story["isAnswers"] . "\t" . $story["isVideo"] . "\t" . $story["isColumn"] . "\t" . $story["isTopstory"] . "\t" . $story["isExtTopStory"] . "\n";
			++$r;
		}
			$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Exported report of news stories by date.');";
			mysql_query($sql);
			
			header('Content-type: application/ms-excel');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $headings;
			echo $contents;

} // END if both publish and create are empty or full

// if publish is checked and created is blank
else if ($_SESSION["publish"]==1 && $_SESSION["create"]==0)
{ 
	if (empty($_SESSION["datePublishedBegin"]) && empty($_SESSION["datePublishedEnd"]))
	
	{
		$sql = "SELECT * FROM tblNews INNER JOIN tblNewsWriterPeople ON tblNews.newsID = tblNewsWriterPeople.newsID WHERE tblNews.isHidden = 0 AND tblNews.stageID=6 GROUP BY tblNews.newsID ORDER BY tblNews.datePublished DESC";
		$result2 = mysql_query($sql);
			while($story = mysql_fetch_array($result2)) 		
			{		
				$url = '= HYPERLINK("' . $story["strURL"] . '", C'. $r . ') ';
			$contents .= $url . "\t" . $story["datePublished"] . "\t" . $story["strHeadline"] . "\n";
				++$r;
			}
		
	}
	if (!empty($_SESSION["datePublishedBegin"]) && !empty($_SESSION["datePublishedEnd"]))
	
	{		
		$sql = "SELECT * FROM tblNews INNER JOIN tblNewsWriterPeople ON tblNews.newsID = tblNewsWriterPeople.newsID WHERE tblNews.isHidden = 0 AND tblNews.stageID=6 AND (tblNews.datePublished BETWEEN '" . $_SESSION["datePublishedBegin"] . "' AND '" . $_SESSION["datePublishedEnd"] . "') GROUP BY tblNews.newsID ORDER BY tblNews.datePublished DESC";
		$result2 = mysql_query($sql);
			while($story = mysql_fetch_array($result2)) 		
			{		
				$url = '= HYPERLINK("' . $story["strURL"] . '", C'. $r . ') ';
				$contents .= $url . "\t" . $story["datePublished"] . "\t" . $story["strHeadline"] . "\n";
				++$r;
			}
		
		}
		
		else if (!empty($_SESSION["datePublishedBegin"]) || !empty($_SESSION["datePublishedEnd"]))
		
		{		
				if (empty($_SESSION["datePublishedBegin"]))
				{
					$_SESSION["datePublishedBeginError"] = 1;	
					$_SESSION["datePublishedEndError"] = 0; 				
					// return user to last page
				}
				else 
				{
					$_SESSION["datePublishedEndError"] = 1; 
					$_SESSION["datePublishedBeginError"] = 0;					
					
				}
					$_SESSION["errorCounter"]++; 				
					$_SESSION["error"] = "We are missing a Published Date parameter. Try submitting again.";
					header("Location: ../reportDate.php");
			}		 
	
} // END if publish = 1

// if create is checked and publish is blank
else if ($_SESSION["create"]==1 && $_SESSION["publish"]==0)
{ 
	
	if (empty($_SESSION["dateCreatedBegin"]) && empty($_SESSION["dateCreatedEnd"]))

	{
		$sql = "SELECT * FROM tblNews INNER JOIN tblNewsWriterPeople ON tblNews.newsID = tblNewsWriterPeople.newsID WHERE tblNews.isHidden = 0 GROUP BY tblNews.newsID ORDER BY tblNews.dateCreated DESC";
		$result2 = mysql_query($sql);
			while($story = mysql_fetch_array($result2)) 		
			{		
				$url = '= HYPERLINK("' . $story["strURL"] . '", C'. $r . ') ';
				$contents .= $url . "\t" . $story["dateCreated"] . "\t" . $story["strHeadline"] . "\n";
				++$r;
			}
	}
				
		
		if (!empty($_SESSION["dateCreatedBegin"]) && !empty($_SESSION["dateCreatedEnd"]) )
		{
			$sql = "SELECT * FROM tblNews INNER JOIN tblNewsWriterPeople ON tblNews.newsID = tblNewsWriterPeople.newsID WHERE tblNews.isHidden = 0 AND (tblNews.dateCreated BETWEEN '" . $_SESSION["dateCreatedBegin"] . "' AND '" . $_SESSION["dateCreatedEnd"] . "') GROUP BY tblNews.newsID ORDER BY tblNews.dateCreated DESC";
			$result2 = mysql_query($sql);
				while($story = mysql_fetch_array($result2)) 		
				{		
					$url = '= HYPERLINK("' . $story["strURL"] . '", C'. $r . ') ';
					$contents .= $url . "\t" . $story["dateCreated"] . "\t" . $story["strHeadline"] . "\n";
					++$r;
				}
		} 
	
			//check below for one or the other datePublished fields to be empty
			else if (!empty($_SESSION["dateCreatedBegin"]) || !empty($_SESSION["dateCreatedEnd"]))
			{
				if (empty($_SESSION["dateCreatedBegin"]))
				{
					$_SESSION["dateCreatedBeginError"] = 1;	
					$_SESSION["dateCreatedEndError"] = 0; 				
					// return user to last page
				}
				else 
				{
					$_SESSION["dateCreatedEndError"] = 1; 
					$_SESSION["dateCreatedBeginError"] = 0;					
					
				}
					$_SESSION["errorCounter"]++; 				
					$_SESSION["error"] = "We are missing a Created Date parameter. Try submitting again.";
					header("Location: ../reportDate.php");
			}		 


$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Exported report of news stories by date.');";
mysql_query($sql);

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $headings;
echo $contents;

} // end create = 1


//die("if all the way through to activity log. what should we have in the log?");


?>