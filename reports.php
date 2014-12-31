<?php
include_once('includes/header.php'); // authenticate users, includes db connection.
if($_SESSION["isAdmin"] != 1) {
	$_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
	header("Location: error.php");
}
?>

<h3>Reports</h3>


<div class="row-fluid">
	<div class='span4 well'>
		<h4 class="text-center"><a href="functions/doExportNewsPublished.php">Download News <br /> Published</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="functions/doExportNewsPublished.php">Download  <i class="icon-download-alt"></i></a></p>
	</div>

	<div class='span4 well'>
		<h4 class="text-center"><a href="functions/doExportNewsByWriters.php">Download News <br/>Sorted By Writers</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="functions/doExportNewsByWriters.php">Download  <i class="icon-download-alt"></i></a></p>
	</div>
        
	<div class='span4 well'>
		<h4 class="text-center"><a href="functions/doExportNewsBySource.php">Download News <br/>Sorted By Sources</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="functions/doExportNewsBySource.php">Download  <i class="icon-download-alt"></i></a></p>
	</div>
    
</div>
    

<div class="row-fluid">
	<div class='span4 well'>
		<h4 class="text-center"><a href="functions/doExportNewsByArea.php">Download News <br/>Sorted By Areas</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="functions/doExportNewsByArea.php">Download  <i class="icon-download-alt"></i></a></p>
	</div>

	<div class='span4 well'>
		<h4 class="text-center"><a href="functions/doExportNewsByTopic.php">Download News <br/>Sorted By Topics</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="functions/doExportNewsByTopic.php">Download  <i class="icon-download-alt"></i></a></p>
	</div>

	<div class='span4 well'>
		<h4 class="text-center"><a href="functions/doExportNewsByIssue.php">Download News <br/>Sorted By Issues</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="functions/doExportNewsByIssue.php">Download  <i class="icon-download-alt"></i></a></p>
	</div>

</div>


<div class="row-fluid">
	<div class='span4 well'>
		<h4 class="text-center"><a href="functions/doExportNewsByDept.php">Download News <br/>Sorted By Department</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="functions/doExportNewsByDept.php">Download  <i class="icon-download-alt"></i></a></p>
	</div>

</div>






<?php
include_once('includes/footer.php');
?>