<?php
include_once("includes/header.php");
if($_SESSION["isAdmin"] != 1) {
  $_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
  header("Location: error.php");
}

      if ($_SESSION["success"] != "") {
          echo "<div class='alert alert-success alert-block'><h4>Success!</h4><p>" . $_SESSION["success"] . "</p></div>";
          $_SESSION["success"] = "";
}

      if ($_SESSION["error"] != "") {
          echo "<div class='alert alert-danger alert-block'><h4>Error!</h4><p>" . $_SESSION["error"] . "</p></div>";
          $_SESSION["error"] = "";
}

?>

<form class="form-horizontal" method="post" action="functions/doAddDept.php">
  <h3>Add a New Department</h3>
    <div class="form-group <?php if($_SESSION['deptNameError'] == 1) echo 'error'; ?>">
      <label class="col-sm-2 control-label" for="department">Department</label>
      <div class="col-sm-4">
      <!-- **07-27: we need the stripslashes to return without any \'s. -->
        <input type="text" class="form-control" id="department" placeholder="Agricultural Communication" name="department" value="<?= htmlspecialchars(stripslashes($_SESSION['deptNameAdd']), ENT_QUOTES);?>" >
      </div>
         <span class="inline-help text-danger">Required</span>

    </div>

    <div class="form-group <?php if($_SESSION['collegeError'] == 1) echo 'error'; ?>">
      <label class="col-sm-2 control-label" for="college">College/Entity</label>
      <div class="col-sm-4">
      <!-- **07-27: we need the stripslashes to return without any \'s. -->
        <input type="text" class="form-control" id="college" placeholder="College of Agriculture" name="college" value="<?= htmlspecialchars(stripslashes($_SESSION['collegeAdd']), ENT_QUOTES);?>" >
      </div>
      <span class="inline-help text-danger">Required</span>

    </div>

      <button type="submit" class="btn btn-block btn-primary btn-large" onClick="setConfirmUnload(false);">Add Department</button>


</form>

<?php
// 07-27: clear these out when leaving the page so the user comes back to a clean form.
$_SESSION["deptNameError"] = 0;
$_SESSION["collegeError"] = 0;

$_SESSION["deptNameAdd"] ="";
$_SESSION["collegeAdd"] = "";
$_SESSION["isHiddenAdd"] = "";

?>

<?php
include_once("includes/footer.php");
?>