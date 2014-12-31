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

<form class="form-horizontal" method="post" action="functions/doAddAffiliation.php">
  <h3>Add a New Affiliation</h3>
    <div class="control-group <?php if($_SESSION['affiliationError'] == 1) echo 'error'; ?>">
      <label class="control-label" for="affiliation">Affiliation</label>
      <div class="controls">
      <!-- **07-27: we need the stripslashes to return without any \'s. -->
        <input type="text" class="span3" id="affiliation" placeholder="Affiliation" name="affiliation" value="<?= htmlspecialchars(stripslashes($_SESSION['affiliationAdd']), ENT_QUOTES);?>" > <span class="inline-help text-error">Required</span>
      </div>
    </div>
       
    <div class="well">
      <button type="submit" class="btn btn-block btn-primary btn-large" onClick="setConfirmUnload(false);">Add Affiliation</button>
    </div>

</form>

<?php
// 07-27: clear these out when leaving the page so the user comes back to a clean form.
$_SESSION["affiliationError"] = 0;

$_SESSION["affiliationAdd"] ="";
$_SESSION["isHiddenAdd"] = "";

?>

<?php 
include_once("includes/footer.php");
?>