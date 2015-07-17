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

<div class="row">
<div class="col-sm-8">
<form class="form-horizontal" method="post" action="functions/doAddDept.php">
  <h1>Add a New Department</h1>
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
    <div class="form-group">
      <div class="col-sm-4 col-sm-offset-2">
        <button type="submit" class="btn btn-success btn-block btn-large" onClick="setConfirmUnload(false);"><i class="fa fa-plus-circle"></i> Add Department</button>
      </div>
    </div>




</form>
</div>
</div>

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