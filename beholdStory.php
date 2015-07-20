<?php
include_once('includes/header.php'); // authenticate users, includes db connection


if(!empty($_GET["newsID"]) && is_numeric($_GET["newsID"])) {
	$SQL = "SELECT * FROM tblNews WHERE newsID=" . mysql_escape_string($_GET["newsID"]) . " AND isHidden=0";
	$result = mysql_query($SQL) or die(mysql_error());
	$row = mysql_fetch_array($result);


	$SQL = "SELECT tblIssues.strIssues FROM tblNewsIssues INNER JOIN tblIssues ON tblNewsIssues.issuesID = tblIssues.issuesID WHERE tblIssues.isHidden=0 AND tblNewsIssues.newsID=" . mysql_escape_string($_GET["newsID"]);
	$result2 = mysql_query($SQL);
	$issueCount = mysql_num_rows($result2);

	$SQL = "SELECT tblTopic.strTopic FROM tblNewsTopic INNER JOIN tblTopic ON tblNewsTopic.topicID = tblTopic.topicID WHERE tblTopic.isHidden=0 AND tblNewsTopic.newsID=" . mysql_escape_string($_GET["newsID"]);
	$result3 = mysql_query($SQL);
	$topicCount = mysql_num_rows($result3);

	$SQL = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . mysql_escape_string($_GET["newsID"]);
	$result4 = mysql_query($SQL);
	$sourceCount = mysql_num_rows($result4);

	$SQL = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . mysql_escape_string($_GET["newsID"]);
	$result5 = mysql_query($SQL);

	$SQL = "SELECT tblDept.strDeptName, tblDept.strCollege FROM tblDept INNER JOIN tblNewsDept ON tblNewsDept.deptID = tblDept.deptID WHERE tblNewsDept.newsID=" . mysql_escape_string($_GET["newsID"]);
	$result6 = mysql_query($SQL);
	$deptCount = mysql_num_rows($result6);

	$SQL = "SELECT tblAffiliation.strAffiliation FROM tblAffiliation INNER JOIN tblNewsAffiliation ON tblNewsAffiliation.affiliationID = tblAffiliation.affiliationID WHERE tblNewsAffiliation.newsID=" . mysql_escape_string($_GET["newsID"]);
	$result7 = mysql_query($SQL);
	$affiliationCount = mysql_num_rows($result7);


	$SQL = "SELECT tblArea.strArea FROM tblArea INNER JOIN tblNewsArea ON tblNewsArea.areaID = tblArea.areaID WHERE tblNewsArea.newsID=" . mysql_escape_string($_GET["newsID"]);
	$result8 = mysql_query($SQL);
	$areaCount = mysql_num_rows($result8);


}
else {
	$_SESSION["error"] = "The newsID must be provided and it must be a number.<br/><small><em>Error Description: ID provided in query string is invalid.</small></em>";
}

if(!empty($_SESSION["error"])) {
	// if there is an error, display it
	echo "<div class='alert alert-danger alert-block'><h4>Houston, we have a problem!</h4><p>" . $_SESSION["error"] . "</p></div>";
	$_SESSION["error"] = "";
}
if ($_SESSION["success"] != "") {
          echo "<div class='alert alert-success alert-block'><h4>Success!</h4><p>" . $_SESSION["success"] . "</p></div>";
          $_SESSION["success"] = "";
}



if(!empty($row["newsID"]))
{
?>


<div style="width: 65%; padding: 5px; float: left;">

<?php
  if(empty($row["txtIntent"])) {
  	echo "<div class='alert alert-warning'><i class='fa fa-flag'></i> <strong>Attention:</strong> This story does not appear in the work list. <br/>You must specify an intent for your story to be listed in the work list.</div>";

  }
?>


	<h2><?php if($row["isTopStory"] == 1 || $row["isExtTopStory"] == 1) echo "<span class='label label-inverse' style='position: relative; top: -5px;'><i class='fa fa-star icon-white' rel='tooltip' title='This was featured as a Top Story. '></i></span>"?> <?php if(!empty($row["strHeadline"])) { echo htmlspecialchars(stripslashes($row["strHeadline"]), ENT_QUOTES); } else { echo htmlspecialchars(stripslashes($row["strFilename"]), ENT_QUOTES); } ?></h2>

	<div class="panel panel-default">
	<div class="panel-body">


		<div style="width:45%; float: left; margin-right: 20px;">
			<table class="table table-hover">
				<tr >
					<td style="border: none;">Writers:</td>
					<td style="border: none;">
						<?php
							while($writers = mysql_fetch_array($result5)) {
									if(!empty($writers["strFirstName"])) {
										echo "<i class='fa fa-user' rel='tooltip' title='Phone: " . $writers["strPhone"] . "'></i> <a href='mailto:" . $writers["strEmail"] . "'>" . $writers["strFirstName"] . " " . $writers["strLastName"] . "</a><br />";
									}
								}
						?>


					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
							if($row["datePublished"] != "0000-00-00") {
								if(strtotime($row["datePublished"]) > strtotime('now')) {
									echo "Expected Release: " .  date("F d, Y", strtotime($row["datePublished"]));
								}
								else {
									echo "Published: " . date("F d, Y", strtotime($row["datePublished"]));
								}
							}
							else {
								echo "Expected Release: <a href='editStory.php?newsID=" . $_GET["newsID"] . "#pubDate' class='btn btn-default btn-xs'><i class='fa fa-plus'></i> Add Publish Date</a>";
							}
						?>

					</td>
				</tr>
			</table>
		</div>
		<div style="width:45%; float: left; margin-left: 20px;">
			<table class="table table-hover">
				<tr>
					<td style="border: none;">Reach:</td>
					<td style="border: none;">
						<?php
							if(!empty($row["strReach"])) {
								echo $row["strReach"];
							}
							else {
								echo "<a href='editStory.php?newsID=" . $_GET["newsID"] . "#reach' class='btn btn-default btn-xs'><i class='fa fa-plus'></i> Add Reach</a>";
							}
						?>
					</td>
				</tr>
				<tr>
					<td>Intent:</td>
					<td>
						<?php
							if(!empty($row["txtIntent"])) {
								echo $row["txtIntent"];
							}
							else {
								echo "<a href='editStory.php?newsID=" . $_GET["newsID"] . "#intent' class='btn btn-default btn-xs'><i class='fa fa-plus'></i> Add Intent</a>";
							}
						?>
					</td>
				</tr>
			</table>
		</div>
	</div><!--end of panel body-->




	</div>








	<div id="story"><?php echo html_entity_decode(htmlspecialchars_decode($row["txtBody"])); ?></div>


	<div class="panel panel-default" id="facts" style="float: left; width: 95%; clear:both;">
		<div class="panel-heading"><h3>General Information</h3></div>

		<div class="panel-body">
		<div style="width: 45%; float: left; padding: 10px;">

		<table class="table table-hover">
			<tbody>
			<tr>
				<td>Source(s):</td>
				<td><?php

					if($sourceCount > 0) {
						while($sources = mysql_fetch_array($result4)) {
								if(!empty($sources["strFirstName"])) {
									echo "<i class='fa fa-user' rel='tooltip' title='Phone: " . $sources["strPhone"] . "'></i> <a href='mailto:" . $sources["strEmail"] . "'>" . $sources["strFirstName"] . " " . $sources["strLastName"] . "</a><br />";
								}
							}
					}
					else {
						echo "<a href='editStory.php?newsID=" . $_GET["newsID"] . "#sources' class='btn btn-default btn-xs'><i class='fa fa-plus'></i> Add Sources</a>";
					}

				?></td>
			</tr>

			<tr>
				<td>Topic(s):</td>
				<td><?php
					if($topicCount > 0) {
						while($topics = mysql_fetch_array($result3)){
							if(!empty($topics["strTopic"])) {
								echo $topics["strTopic"] . "<br />";
							}
						}
					}
					else {
						echo "<a href='editStory.php?newsID=" . $_GET["newsID"] . "#topics' class='btn btn-default btn-xs'><i class='fa fa-plus'></i> Add Topics</a>";
					}

				?></td>
			</tr>

			<tr>
				<td>Issue(s):</td>
				<td><?php

					if($issueCount > 0) {
						while($issues = mysql_fetch_array($result2)) {
							if(!empty($issues["strIssues"])) {
								echo $issues["strIssues"] . "<br />";
							}
						}
					}
					else {
						echo "<a href='editStory.php?newsID=" . $_GET["newsID"] . "#issues' class='btn btn-default btn-xs'><i class='fa fa-plus'></i> Add Issues</a>";
					}

				 ?></td>
			</tr>
			<tr>
				<td>Related Website(s):</td>
				<td>
					<?php

						for($i=1;$i<6;$i++)
						{
							if(!empty($row["strWebsite" . $i])) {
								echo "<a href='" . $row["strWebsite" . $i] . "'>" . $row["strWebsiteTitle" . $i] . "</a><br/>";
								$website = TRUE;
							}

						}
						if(!$website) {
								echo "<a href='editStory.php?newsID=" . $_GET["newsID"] . "#websites' class='btn btn-default btn-xs'><i class='fa fa-plus'></i> Add Websites</a>";
						}
					?>
				</td>
			</tr>
		</tbody>
		</table>

		</div>
		<div style="width: 45%; float: left; padding:10px;">
			<table class="table table-hover">
			<tbody>
			<tr>
				<td>Department(s):</td>
				<td><?php

					if($deptCount > 0) {
						while($department = mysql_fetch_array($result6)) {
							if(!empty($department["strDeptName"])) {
								echo "<abbr title='" . $department["strCollege"] . "'>" . $department["strDeptName"] . "</abbr><br />";
							}
						}
					}
					else {
						echo "<a href='editStory.php?newsID=" . $_GET["newsID"] . "#depts' class='btn btn-default btn-xs'><i class='fa fa-plus'></i> Add Departments</a>";
					}

					?></td>
			</tr>

			<tr>
				<td>Affiliation(s):</td>
				<td><?php

					if($affiliationCount > 0) {
						while($affiliation = mysql_fetch_array($result7)) {
							if(!empty($affiliation["strAffiliation"])) {
								echo $affiliation["strAffiliation"] . "<br />";
							}
						}
					}
					else {
						echo "<a href='editStory.php?newsID=" . $_GET["newsID"] . "#affiliations' class='btn btn-default btn-xs'><i class='fa fa-plus'></i> Add Affiliations</a>";
					}
					?></td>
			</tr>

			<tr>
				<td>Area(s):</td>
				<td><?php
					if($areaCount > 0) {
						while($area = mysql_fetch_array($result8)) {
							if(!empty($area["strArea"])) {
								echo $area["strArea"] . "<br />";
							}
						}
					}
					else {
						echo "<a href='editStory.php?newsID=" . $_GET["newsID"] . "#areas' class='btn btn-default btn-xs'><i class='fa fa-plus'></i> Add Areas</a>";
					}
					?></td>
			</tr>

		</tobdy>
		</table>
		</div>
	</div>
	</div> <!--end of panel-->
</div>

<div class="panel panel-default" style="width: 30%; min-height: 300px; margin-left:15px; float: left;">
	<div class="panel-heading">
	<h3 style='text-align: center;'>Manage Story</h3>
	</div>

	<div class="panel-body">
	<strong>Status</strong>: <?

			  $sql2 = "SELECT strStatus FROM tblStatus WHERE statusID=" . $row['statusID'];
	          $result2 = mysql_query($sql2);
	          $row2 = mysql_fetch_array($result2);
	          if(!empty($row2["strStatus"])) {
	            echo $row2["strStatus"];
	          } else {
	            echo "No status provided";
	          } ?> <br />

	<strong>Created</strong>: <?php echo  date("m.d.Y", strtotime($row["dateCreated"])) . " at " . date("h:i a", strtotime($row["dateCreated"]))  ?> <br/>
	<strong>Last Modified</strong>: <?php if(!empty($row["dateModified"])) {  echo  date("m.d.Y", strtotime($row["dateModified"])) . " at " . date("h:i a", strtotime($row["dateModified"]));} else { echo "No edits have been made.";} ?> <br/>
	<br />
	<a href='editStory.php?newsID=<?php echo $_GET["newsID"] ?>' class='btn btn-block btn-success'><i class='icon-white fa fa-edit'></i> Edit Story</a>
	<a href='functions/doSaveStory.php?newsID=<?php echo $_GET["newsID"] ?>' class='btn btn-block btn-default'><i class='fa fa-download icon-white'></i> Download Story</a>
	<br />
	</div><!--end of panel body-->
	<div class="panel-footer">

	   <?php
	       //display general error with information
	        if ($_SESSION["error"] != "") {
	          echo "<div class='alert alert-danger alert-block'><h4>We need your attention! <span class='badge badge-important' style='position: relative; top: -2px;'>" . $_GET['count'] . " items</span></h4><p>" . $_SESSION['error'] . "</p></div>";
	          $_SESSION["error"] = "";
	        }
	        if ($_SESSION["success"] != "") {
	          echo "<div class='alert alert-success alert-block'><h4>Success!</h4><p>" . $_SESSION["success"] . "</p></div>";
	          $_SESSION["success"] = "";
	        }

	      ?>

		<form class="form-horizontal" id="stageForm" action="functions/doUpdateStage.php" method="post">
			<div class="control-group">
				 <select class="form-control" name="stage" id="stage">
					<?php
					  $sql = "SELECT * FROM tblStage;";
			          $result = mysql_query($sql);


			            while($stage = mysql_fetch_array($result)) {

			              if($stage["stageID"] == $row["stageID"]) {
			                echo "<option value='" . $stage["stageID"] . "' selected='selected'>" . $stage["strStage"] . "</option>";
			              }
			                else {
			                  echo "<option value='" .  $stage["stageID"] . "'>" . $stage["strStage"] . "</option>";
			                }
			            }
			      ?>
				</select>
				<input type="hidden" name="newsID" value="<?php echo $_GET["newsID"]; ?>">
				<a style="margin-top: 5px;" onClick="doSourceCheck()" rel="tooltip" class="btn btn-block btn-small btn-success"><i class='fa fa-check icon-white' ></i> Update Status</a>
			</div>




			<!-- Modal -->
		<div id="sourceModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		  <div class="modal-content">

		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h3 id="myModalLabel">Do you want to send a note to your source?</h3>
		  </div>
		  <div class="modal-body">
		  	<p class="span5"><span class="label label-info"><i class="fa fa-check icon-white"></i></span> If you wish to send a note to your source along with your story simply type your message below.</p>
		  	<p class="span5"><span class="label label-info"><i class="fa fa-remove icon-white"></i></span> If you wish to just send your story, leave the field below blank.</p>
		    <div class="control-group" style="margin-left: 25px;">

	            <textarea placeholder="Type your note here" class="form-control" name="note" rows="5"></textarea>

	        </div>

		  </div>
		  <div class="modal-footer">
		    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		    <button class="btn btn-primary" onClick="submitStage()">Send Source Check</button>
		  </div>
		  </div> <!-- end of modal content -->
		</div> <!-- end of modal-dialog modal-lg -->
		</div>

		</form>


		<?php
			// get the count of stages available, this is so that it's dynmaic for
			// potentially added stages
			$sql = "SELECT COUNT(stageID) as stageCount FROM tblStage;";
			$results = mysql_query($sql);
			$stageC = mysql_fetch_array($results);
		?>


		<!-- <div class="progress" role="progressbar" style="margin-top:5px;">
		  <div class="progress-bar progress-bar-success progress-bar-striped active" style="width: <?php echo ($row["stageID"]/$stageC["stageCount"])*100 ?>%"> <?php echo number_format(($row["stageID"]/$stageC["stageCount"])*100, 0, '.', ' ') ?>%</div>
		</div> -->
	</div>

</div>
<div><!--end of footer modal-->


<?php
}
else {
	echo "<div class='alert alert-danger alert-block'><h4>Houston, we have a problem!</h4><p>The ID that you provided was not found in the database. It either never existed or was deleted.</p></div>";
}
?>





<script>
function doSourceCheck() {
	setConfirmUnload(false)
	var e = document.getElementById("stage");
	var strStage = e.options[e.selectedIndex].value;

	if(strStage == 4) {
		$('#sourceModal').modal('show')
	}
	else {
		document.getElementById("stageForm").submit();
	}
}

function submitStage() {
	setConfirmUnload(false);
	document.getElementById("stageForm").submit();
}
</script>

<?php
include_once('includes/footer.php');
?>