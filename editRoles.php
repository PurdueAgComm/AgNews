<?php
// global includes
include_once('includes/header.php'); // authenticate users, includes db connection
if($_SESSION["isAdmin"] != 1) {
	$_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
	header("Location: error.php");
}

      if ($_SESSION["success"] != "") {
          echo "<div class='alert alert-success alert-block'><h4>Success!</h4><p>" . $_SESSION["success"] . "</p></div>";
          $_SESSION["success"] = "";
}
      if ($_SESSION["error"] != "") {
          echo "<div class='alert alert-error alert-block'><h4>Error!</h4><p>" . $_SESSION["error"] . "</p></div>";
          $_SESSION["error"] = "";
}

?>

<h3>Update Roles</h3>



<form class="form-group form-horizontal" action="functions/doEditRole.php" method="post">
 <div class="<?php if($_SESSION['coordinatorError'] == 1) echo 'error'; ?>">
         <label class="col-sm-2 control-label" for="fName01">Coordinator</label>
         <div class="controls">
         <div class="col-sm-4">
               <select class="form-control" name="coordinator">
				<?php
					$sql = "SELECT * FROM tblPeople WHERE (strRole <> 'MM' AND strRole <> 'IT') AND isAdmin=1 ORDER BY strLastName";
					$result = mysql_query($sql);
					while($people = mysql_fetch_array($result)) {

						if($people["strRole"] == "Coordinator")
						{
							echo "<option value='" . $people["peopleID"] . "' selected='selected'>" . $people["strFirstName"] . " " . $people["strLastName"] . "</option>";
						}
						else {
							echo "<option value='" . $people["peopleID"] . "'>" . $people["strFirstName"] . " " . $people["strLastName"] . "</option>";
						}

					}
				?>

               </select>
                 <input type="hidden" name="roleAction" value="coordinator" />
               </div>

               <button class="btn btn-success" action="submit" onClick="setConfirmUnload(false);"><i class="fa fa-check icon-white" ></i></button>
               <span rel='tooltip' title='The Coordinator of the News Unit will receive updates when stories are progressed to the "Coordinator Review" status.'><i class='fa fa-question-circle'></i>
         </div>
      </div>
</form>

<form class="form-group form-horizontal" action="functions/doEditRole.php" method="post">
 <div class="<?php if($_SESSION['adminError'] == 1) echo 'error'; ?>">
         <label class="col-sm-2 control-label" for="fName01">News Assistant</label>
         <div class="controls">
         <div class="col-sm-4">
               <select class="form-control" name="assistant">
				<?php
					$sql = "SELECT * FROM tblPeople WHERE (strRole <> 'MM' AND strRole <> 'IT') AND isAdmin=1 || isSupport=1 ORDER BY strLastName";
					$result = mysql_query($sql);
					while($people = mysql_fetch_array($result)) {

						if($people["strRole"] == "News Assistant")
						{
							echo "<option value='" . $people["peopleID"] . "' selected='selected'>" . $people["strFirstName"] . " " . $people["strLastName"] . "</option>";
						}
						else {
							echo "<option value='" . $people["peopleID"] . "'>" . $people["strFirstName"] . " " . $people["strLastName"] . "</option>";
						}

					}
				?>

               </select>
               <input type="hidden" name="roleAction" value="assistant" />
           </div>
               <button class="btn btn-success" onClick="setConfirmUnload(false);" action="submit"><i class="fa fa-check icon-white"></i></button>
               <span rel='tooltip' title='The News Assistant Role receives an email update when stories are progressed to the "M&M Review" status prompting them to log in, update the story URL, and publish the story.'><i class='fa fa-question-circle'></i>
         </div>
      </div>
</form>

<form class="form-group form-horizontal" action="functions/doEditRole.php" method="post">
 <div class="<?php if($_SESSION['adminError'] == 1) echo 'error'; ?>">
         <label class="col-sm-2 control-label" for="fName01">MMU Administrator</label>
         <div class="controls">
         <div class="col-sm-4">
               <select class="form-control" name="manager">
				<?php
					$sql = "SELECT * FROM tblPeople WHERE (strRole <> 'MM' AND strRole <> 'IT') AND isAdmin=1  ORDER BY strLastName";
					$result = mysql_query($sql);
					while($people = mysql_fetch_array($result)) {

						if($people["strRole"] == "Project Manager")
						{
							echo "<option value='" . $people["peopleID"] . "' selected='selected'>" . $people["strFirstName"] . " " . $people["strLastName"] . "</option>";
						}
						else {
							echo "<option value='" . $people["peopleID"] . "'>" . $people["strFirstName"] . " " . $people["strLastName"] . "</option>";
						}

					}
				?>

               </select>
               <input type="hidden" name="roleAction" value="administrator" />
           </div>
               <button onClick="setConfirmUnload(false);" class="btn btn-success" action="submit"><i class="fa fa-check icon-white"></i></button>
              <span rel='tooltip' title='The MMU Administrator is the MMU contact for this website. All help emails will be sent to this person.'><i class='fa fa-question-circle'></i>
         </div>
      </div>
</form>





<?php
include_once("includes/footer.php");
?>