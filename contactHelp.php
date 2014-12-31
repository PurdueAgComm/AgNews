<?php
include_once('includes/header.php'); // authenticate users, includes db connection

$sql = "SELECT * FROM tblPeople WHERE strRole='Project Manager'";
$result = mysql_query($sql);
$contact = mysql_fetch_array($result);



      if ($_SESSION["success"] != "") {
          echo "<div class='alert alert-success alert-block'><h4>Success!</h4><p>" . $_SESSION["success"] . "</p></div>";
          $_SESSION["success"] = "";
}
      if ($_SESSION["error"] != "") {
          echo "<div class='alert alert-error alert-block'><h4>Error!</h4><p>" . $_SESSION["error"] . "</p></div>";
          $_SESSION["error"] = "";
}


?>


  <h3>Get Help</h3>

  	<p><p><span class="label label-info">Read First!</span> Before sending a message, please take some time to look through the extensive documentation provided to you in our <a href="help.php">help section</a>. If you can't find what you're looking for there, then please send us a message.</p>
  	<p>Your email is being sent to <i class="icon-user"></i> <strong><?php echo $contact["strFirstName"] . " " . $contact["strLastName"]; ?></strong>, the MMU contact for this project.</p>
	<hr style="margin-top:20px; margin-bottom: 20px;">
	
	<form class="form-horizontal" method="post" action="functions/doSendHelp.php">	
    <input type="hidden"  name="name"  value="<?= $_SESSION['userName'];?>" >
    <input type="hidden"  name="alias" value="<?= $_SESSION['user'];?>" > 
    <input type="hidden"  name="phone" value="<?= $_SESSION['userPhone'];?>" >
    <input type="hidden"  name="email" value="<?= $_SESSION['userEmail'];?>" > 
	
	<div class="control-group <?php if($_SESSION['topicError'] == 1) echo 'error'; ?>">
      <label class="control-label" for="topic">Topic</label>
      <div class="controls">
        <select name="topic">
        	<option>Select a topic</option>
        	<option>Ask For Help</option>
        	<option>Report a Bug</option>
        	<option>Request a Feature</option>
        </select>
      </div>
    </div>

    <div class="control-group <?php if($_SESSION['topicError'] == 1) echo 'error'; ?>">
      <label class="control-label" for="message">Message:</label>
      <div class="controls">
            <textarea class="span5" style="height: 150px;" name="message"></textarea>
      </div>
    </div>
      <button type="submit" class="btn btn-block btn-primary btn-large" onClick="setConfirmUnload(false);"><i class='icon-envelope icon-white'></i> Send Message</button>
</form>






<?php
include_once('includes/footer.php');
?>