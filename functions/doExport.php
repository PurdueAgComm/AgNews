<?php
session_start();
include_once("../includes/db.php");
if($_SESSION["isAdmin"] != 1) {
    $_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
    header("Location: error.php");
}

$filename ="AgNews_Report_".date("m/d/Y").".xlsx";

//Columns: Headline, Story URL, Area [extension, teaching, ag, notables], Topic [, Issue, Published Date, Status, Writer, Source, Department, Featured in,
//Top Story info (Ag, Ext, Science), Reach, YouTube URL, Related Website, Included Media

//column headings
$headings = "Headline\tURL\tArea\tTopic\tIssue\tPublished\tStatus\tWriter\tSource\tDepartment\tFeatured In\tType\tReach\tYouTube\tRelated Websites\tHas Photo?\tHas Video?\tHas Graphic\tHas Audio?\n";

$sql = "SELECT * FROM tblNews ";

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $headings;
echo $contents;

?>