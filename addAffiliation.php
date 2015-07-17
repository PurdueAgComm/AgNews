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
          echo "<div class='alert alert-error alert-block'><h4>Error!</h4><p>" . $_SESSION["error"] . "</p></div>";
          $_SESSION["error"] = "";
}

?>

<div class="row">
<div class="col-sm-8">
<form class="form-horizontal" method="post" action="functions/doAddAffiliation.php">
  <h1>Add a New Affiliation</h1>
  <div class="form-group <?php if($_SESSION['affiliationError'] == 1) echo 'error'; ?>">
    <div class="col-sm-2">
      <label class="control-label" for="affiliation">Affiliation *</label>
    </div>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="affiliation" placeholder="Affiliation" name="affiliation" value="<?= htmlspecialchars(stripslashes($_SESSION['affiliationAdd']), ENT_QUOTES);?>">
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-4 col-sm-offset-2">
      <button type="submit" class="btn btn-block btn-success btn-large" onClick="setConfirmUnload(false);"><i class="fa fa-plus-circle"></i> Add Affiliation</button>
    </div>
  </div>


</form>
</div>
</div>

<?php
// 07-27: clear these out when leaving the page so the user comes back to a clean form.
$_SESSION["affiliationError"] = 0;
$_SESSION["affiliationAdd"] ="";
$_SESSION["isHiddenAdd"] = "";

?>

<?php
include_once("includes/footer.php");
?>