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

<form class="form-horizontal" method="post" action="functions/doAddUser.php">
  <h3>Add a New User</h3>
    <div class="control-group <?php if($_SESSION['firstNameError'] == 1) echo 'error'; ?>">
      <label class="control-label" for="filename">First Name</label>
      <div class="controls">
    	<!-- **07-27: we need the stripslashes to return without any \'s. -->
        <input type="text" class="span3" id="filename" placeholder="John" name="firstName" value="<?= htmlspecialchars(stripslashes($_SESSION['firstNameAdd']), ENT_QUOTES);?>" > <span class="inline-help text-error">Required</span>
      </div>
    </div>

    <div class="control-group <?php if($_SESSION['lastNameError'] == 1) echo 'error'; ?>">
      <label class="control-label" for="filename">Last Name</label>
      <div class="controls">
    	<!-- **07-27: we need the stripslashes to return without any \'s. -->
        <input type="text" class="span3" id="filename" placeholder="Doe" name="lastName" value="<?= htmlspecialchars(stripslashes($_SESSION['lastNameAdd']), ENT_QUOTES);?>" > <span class="inline-help text-error">Required</span>
      </div>
    </div>

    <div class="control-group <?php if($_SESSION['aliasError'] == 1) echo 'error'; ?>">
      <label class="control-label" for="filename">Alias</label>
      <div class="controls">
        <input type="text" class="span3" id="filename" placeholder="jdoe" name="alias" value="<?= $_SESSION['aliasAdd'];?>" > <i rel='tooltip' title='This is their Career Account login and must match their Purdue-given account. This is what they will use to log in.' class='icon-question-sign'></i> <span class="inline-help text-error">Use "NA" as the alias for a freelance writer</span>
      </div>
            
    </div>
      

    <div class="control-group <?php if($_SESSION['phoneError'] == 1) echo 'error'; ?>">
      <label class="control-label" for="filename">Phone</label>
      <div class="controls">
        <input type="text" class="span3" id="filename" placeholder="765-XXX-XXXX" name="phone" value="<?= $_SESSION['phoneAdd'];?>" >
      </div>
    </div>

    <div class="control-group <?php if($_SESSION['emailError'] == 1) echo 'error'; ?>">
      <label class="control-label" for="filename">Email</label>
      <div class="controls">
        <input type="text" class="span3" id="filename" placeholder="jdoe@purdue.edu" name="email" value="<?= $_SESSION['emailAdd'];?>" > <span class="inline-help text-error">Required</span>
      </div>
    </div>

    <div class="control-group">
    	<label class="control-label">Staff Role</label>
         
          <div class="controls">
            <label class="checkbox">
             <?php if($_SESSION["isWriterAdd"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isWriter"> Writer   
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isWriter"> Writer   
              <?php } ?>
            </label>
        </div>

        <div class="controls">
            <label class="checkbox">
             <?php if($_SESSION["isSupportAdd"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isSupport"> Support   
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isSupport"> Support   
              <?php } ?>
            </label>
        </div>


        <div class="controls">
            <label class="checkbox">
             <?php if($_SESSION["isAdminAdd"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isAdmin"> Administrator   
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isAdmin"> Administrator   
              <?php } ?>
            </label>
        </div>


        <div class="controls">
            <label class="checkbox">
             <?php if($_SESSION["isSourceAdd"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isSource"> Source   
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isSource"> Source   
              <?php } ?>
            </label>
        </div>        
    </div>

    <div class="well">
      <button type="submit" class="btn btn-block btn-primary btn-large" onClick="setConfirmUnload(false);">Add User</button>

    </div>



</form>


<?php

$_SESSION["firstNameError"] = 0;
$_SESSION["lastNameError"] = 0;
$_SESSION["emailError"] = 0;
$_SESSION["phoneError"] = 0;
$_SESSION["errorCounter"] = 0;
$_SESSION["aliasError"] = 0;
$_SESSION["rolesError"] = 0;

    // 07-27: clear these out when leaving the page so the user comes back to a clean form.
    $_SESSION["firstNameAdd"] ="";
    $_SESSION["lastNameAdd"] = "";
	$_SESSION["emailAdd"] = "";
	$_SESSION["phoneAdd"] = "";
	$_SESSION["aliasAdd"] = "";
	$_SESSION["isWriterAdd"] = "";
	$_SESSION["isSupportAdd"] = "";
	$_SESSION["isAdminAdd"] = "";
	$_SESSION["isSourceAdd"] = "";


?>





<?php 
include_once("includes/footer.php");
?>