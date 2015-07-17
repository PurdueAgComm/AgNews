<?php
include_once("includes/header.php");

$userID = (int) $_GET["userID"];
$sql = "SELECT * FROM tblPeople WHERE peopleID=" . $userID;
$result = mysql_query($sql);
$userExists = mysql_numrows($result);
$user = mysql_fetch_array($result);




      if ($_SESSION["success"] != "") {
          echo "<div class='alert alert-success alert-block'><h4>Success!</h4><p>" . $_SESSION["success"] . "</p></div>";
          $_SESSION["success"] = "";
}

      if ($_SESSION["error"] != "") {
          echo "<div class='alert alert-danger alert-block'><h4>Error!</h4><p>" . $_SESSION["error"] . "</p></div>";
          $_SESSION["error"] = "";
}


?>




<?php if(!empty($userID) && $userExists) { ?>
<form class="form-horizontal" method="post" action="functions/doEditUser.php?userID=<?php echo $user['peopleID']?>">
  <h3>Edit a User</h3>
    <div class="form-group<?php if($_SESSION['firstNameError'] == 1) echo 'error'; ?>">
      <label class="col-sm-2 control-label" for="filename">First Name</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="filename" placeholder="John" name="firstName" value="<?= htmlspecialchars(stripslashes($user['strFirstName']), ENT_QUOTES);?>" >
        </div>
        <span class="inline-help text-danger">Required</span>

    </div>

    <div class="form-group<?php if($_SESSION['lastNameError'] == 1) echo 'error'; ?>">
      <label class="col-sm-2 control-label" for="filename">Last Name</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="filename" placeholder="Doe" name="lastName" value="<?= $user['strLastName'];?>" >
      </div>
      <span class="inline-help text-danger">Required</span>

    </div>

    <div class="form-group <?php if($_SESSION['aliasError'] == 1) echo 'error'; ?>">
      <label class="col-sm-2 control-label" for="filename">Alias</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="filename" placeholder="jdoe" name="alias" value="<?= $user['alias'];?>" >
        </div> <i rel='tooltip' data-container="body" title='This is their Career Account login and must match their Purdue-given account. This is what they will use to log in.' class='fa fa-question-circle'></i>
         <span class="inline-help text-danger">Use "NA" as the alias for a freelance writer</span>

    </div>

    <div class="form-group <?php if($_SESSION['phoneError'] == 1) echo 'error'; ?>">
      <label class="col-sm-2 control-label" for="filename">Phone</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="filename" placeholder="765-XXX-XXXX" name="phone" value="<?= $user['strPhone'];?>" >
      </div>
    </div>

    <div class="form-group <?php if($_SESSION['emailError'] == 1) echo 'error'; ?>">
      <label class="col-sm-2 control-label" for="filename">Email</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="filename" placeholder="jdoe@purdue.edu" name="email" value="<?= $user['strEmail'];?>" >
        </div>
         <span class="inline-help text-danger">Required</span>
    </div>

    <div class="form-group">
    	<label class="col-sm-2 control-label">Staff Role</label>
          <div class="col-sm-4" style="margin-left:20px">
            <label class="checkbox">
             <?php if($user["isWriter"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isWriter"> Writer
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isWriter"> Writer
              <?php } ?>
            </label>



            <label class="checkbox">
             <?php if($user["isSupport"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isSupport"> Support
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isSupport"> Support
              <?php } ?>
            </label>




            <label class="checkbox">
             <?php if($user["isAdmin"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isAdmin"> Administrator
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isAdmin"> Administrator
              <?php } ?>
            </label>



            <label class="checkbox">
             <?php if($user["isSource"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isSource"> Source
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isSource"> Source
              <?php } ?>
            </label>

         </div>
    </div>


      <button type="submit" onClick="setConfirmUnload(false);" class="btn btn-block btn-primary btn-large">Update User</button>

</form>
<? }

else {

if($userExists != 1) {
  echo "<div class='alert alert-danger'>User does not exist. <a href='editUser.php'>Try again</a>.</div>";
}
else {


// display all users
  $sql = "SELECT * FROM tblPeople WHERE strRole <> 'MM' ORDER BY strLastName;";
  $result = mysql_query($sql);
?>
<h1>Manage Users</h1>
<p>You can edit a user at any time, simply click their name below. To add a user, click on the "Add User" button.</p>

 <div class="clearfix" style="margin-bottom: 5px;">
        <a href="addUser.php" style="margin-left: 5px;" class="pull-right btn btn-success"><i class="fa fa-plus-circle"></i> Add User</a>


        </div>
<table class="table table-striped table-hover table-bordered">
      <tr>
        <td align="center" width="2%"></td>
        <td width="30%">Name</td>
        <td width="30%">Email</td>
        <td width="10%">Phone</td>
      </tr>

  <?php
    while($user = mysql_fetch_array($result)) {
      echo "<tr>";
      if($user["strRole"] == "Project Manager") {
        echo "<td><i rel='tooltip' title='Project Manager' class='fa fa-star'></i></td>";
      }
	  else if($user["strRole"] == "Coordinator") {
        echo "<td><i rel='tooltip' title='Coordinator' class='fa fa-star-o'></i></td>";
      }
	  else if($user["strRole"] == "IT") {
        echo "<td><i rel='tooltip' title='IT' class='fa fa-star-o'></i></td>";
      }
	  else if($user["strRole"] == "News Assistant") {
        echo "<td><i rel='tooltip' title='News Assistant' class='fa fa-star-o'></i></td>";
      }
      else if($user["isAdmin"]) {
        echo "<td><i rel='tooltip' title='Administrator' class='fa fa-star-o'></i></td>";
	  }
	  else if($user["isSupport"]) {
        echo "<td><i rel='tooltip' title='Support' class='fa fa-star-o'></i></td>";
      }
      else if($user["isWriter"]) {
        echo "<td><i rel='tooltip' title='Writer' class='fa fa-pencil'></i></td>";
      }
      else if($user["isSource"]) {
        echo "<td><i rel='tooltip' title='Source' class='fa fa-globe'></i></td>";
      }
      else {
        echo "<td><i rel='tooltip' title='No Role' class='fa fa-question'></i></td>";
      }
      echo "<td><a href='editUser.php?userID=" . $user["peopleID"] . "'>" . $user["strFirstName"] . " " . $user["strLastName"] . "</a></td>";
      echo "<td>" . $user["strEmail"] . "</td>";
      echo "<td>" . $user["strPhone"] . "</td>";
      echo "</tr>";
    }

  ?>


</table>
<?php } }?>


<?php

$_SESSION["firstNameError"] = 0;
$_SESSION["lastNameError"] = 0;
$_SESSION["emailError"] = 0;
$_SESSION["phoneError"] = 0;
$_SESSION["errorCounter"] = 0;

?>




<?php
include_once("includes/footer.php");
?>