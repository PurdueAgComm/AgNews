<?php
// global includes
include_once('includes/header.php'); // authenticate users, includes db connection
if($_SESSION["isAdmin"] != 1) {
	$_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
	header("Location: error.php");
}
?>
<h3>Control Panel</h3>
<div class="row-fluid">
	<div class='span4 well'>
		<h4 class="text-center"><a href="activity.php">Activity Log</a></h4>
		<p class="text-center"><img src="img/cp/Lock.png" width="20%" height="20%" alt="Activity Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="activity.php">View Activity Log</a></p>
	</div>

	<div class='span4 well'>
		<h4 class="text-center"><a href="issues.php">Issue Options</a></h4>
		<p class="text-center"><img src="img/cp/Settings.png" width="20%" height="20%" alt="Issue Options"></p>
		
		<p><a class='btn btn-block btn-small' <a href="issues.php">Update Issue Options</a></p>
	</div>

	<div class='span4 well'>
		<h4 class="text-center"><a href="topics.php">Topic Options</a></h4>
		<p class="text-center"><img src="img/cp/Settings.png" width="20%" height="20%" alt="Topic Options"></p>
		
		<p><a class='btn btn-block btn-small' <a href="topics.php">Update Topic Options</a></p>
	</div>

</div>

<div class="row-fluid">

	<div class='span4 well'>
		<h4 class="text-center"><a href="reports.php">Download Reports</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Reports"></p>
		
		<p><a class='btn btn-block btn-small' <a href="reports.php">Download Reports</a></p>
	</div>

	<div class='span4 well'>
		<h4 class="text-center"><a href="projectList.php">Work List</a></h4>
		<p class="text-center"><img src="img/cp/Paste.png" width="20%" height="20%" alt="Download Project List"></p>
		
		<p><a class='btn btn-block btn-small' <a href="projectList.php">Work List</a></p>
	</div>

	<div class='span4 well'>
		<h4 class="text-center"><a href="#">Edit Users</a></h4>
		<p class="text-center"><img src="img/cp/User.png" width="20%" height="20%" alt="Edit Users"></p>
		
		<p><a class='btn btn-block btn-small disabled' <a href="">Edit Users</a></p>
	</div>

</div>




<?php
include_once("includes/footer.php");
?>