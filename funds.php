<?php
include_once('includes/header.php'); // authenticate users, includes db connection

//working list of funds
$sql = "SELECT * FROM tblFund WHERE isHidden='0' ORDER BY strFund;";
$result = mysql_query($sql);
$num_results = mysql_num_rows($result);

//deleted list of funds
$sqlDelete = "SELECT * FROM tblFund WHERE isHidden='1' ORDER BY strFund;";
$resultDelete = mysql_query($sqlDelete);
$num_resultsDelete = mysql_num_rows($resultDelete);

// test if there is a query error
if(!$result){
  die("<div class='alert alert-danger'>There was an issue querying the database.</div>");
}
       //display general error with information
      if ($_SESSION["success"] != "") {
          echo "<div class='alert alert-success alert-block'><h4>Success!</h4><p>" . $_SESSION["success"] . "</p></div>";
          $_SESSION["success"] = "";
}
      if ($_SESSION["error"] != "") {
          echo "<div class='alert alert-error alert-block'><h4>Error!</h4><p>" . $_SESSION["error"] . "</p></div>";
          $_SESSION["error"] = "";
}
?>


<div class="panel panel-default" >
 <div class="panel-body form-horizontal">
<h1>Funding Options</h1>

<p>If you edit a fund, that fund will be edited throughout all recorded stories.</p>
<br />
<?php
   if($_SESSION['fundAddError'] == 1) {
     echo "<div class='alert alert-error'><i class='fa fa-exclamation'></i> Looks like you forgot to enter a fund. Please enter an fund before continuing.</div>";
   }
?>
  <!-- New form: addForm01 -->
   <form class="form-group" name="addForm01" id="addForm01" method="post" enctype="multipart/form-data" action="functions/doFund.php">
      <!-- New Issue: client side error if field is blank upon "Submit" need to be required-->
      <div class="<?php if($_SESSION['fundAddError'] == 1) echo 'error'; ?>">
        <label class="col-sm-2 control-label" for="fundAdd">Add a new fund</label>
          <div class="controls">
            <div class="input-append col-sm-4">
               <!-- **07-27: USE the htmlspecialchars(stripslashes ...) to show the content without the escape backslash (\). This would show if there were an error on the page -->
               <input type="text" class="form-control" id="fundAdd" name="fundAdd" class="textfield" placeholder="Issue" required ="required" value="<?= htmlspecialchars(stripslashes($_SESSION['fundAdd']), ENT_QUOTES);?>" />
            </div>  <!-- input-append -->
              <button action="submit" onClick="setConfirmUnload(false);" class="btn btn-success" name ="submit" id="submit"><i class="fa fa-plus-circle"></i> Add fund</button>
          </div> <!-- controls -->
       </div> <!-- control group -->
   </form> <!-- addForm01 -->

<?php
$i=0;
 while($activity = mysql_fetch_array($result)) {
$i++;
?>

<!-- Edit or Delete form: addForm02 -->
 <form class="form-group" name="addForm02" id="addForm02" method="post" enctype="multipart/form-data" action="functions/doFund.php">
  <!-- Edit or Delete: client side error if field is blank upon "Submit"-->
   <div class="<?php if($activity['strfund'] == 1) echo 'error'; ?>" >
      <label class="col-sm-2 control-label"></label>
      <div class="controls">
         <div class="input-append col-sm-4">
        <!-- **07-27: USE the htmlspecialchars(stripslashes ...) to show the content without the escape backslash (\). This would show if there were an error on the page -->
        <input type="text" class="form-control" id="fundEdDel" name="fundEdDel" class="textfield" required="required" value="<?= htmlspecialchars(stripslashes($activity['strFund']), ENT_QUOTES);?>" />
         <input type="hidden" class="form-control" id="fundID" name="fundID" class="textfield"  value="<?= $activity['fundID'];?>" />
         <input type="hidden" class="form-control" id="isHidden" name="isHidden" class="textfield"  value="<?= $activity['isHidden'];?>" />
         </div> <!-- input-append: addForm02 -->
            <span id="fundControls">
              <!-- edit button -->
             <button rel="tooltip" data-container="body" onClick="setConfirmUnload(false);" title="Edit the fund" type="submit "id="edit" class="btn btn-default" name="edit" value="edit" onclick="Clicked(this)"><i class="fa fa-edit"></i> Edit</button>
              <!-- delete button -->
              <button rel="tooltip" data-container="body" onClick="setConfirmUnload(false);" title="Archive the fund" type="submit" id="delete" class="btn btn-default" name="delete" value="delete" ><i class="icon-white fa fa-archive"></i> Archive</button>
           </span> <!-- fundControls: addForm02 -->
      </div> <!-- controls: addForm02 -->
    </div> <!-- control-group: addForm02 -->
 </form> <!-- end form: addForm02 -->
<?php
 } // end while loop for active funds
?>
</div> <!-- form horizontal -->
</div> <!-- end panel panel-default -->


<!-- Below are the deleted (isHidden) items -->
<div class="panel panel-default" >
 <div class="panel-body form-horizontal">

<h1>Archived Funds</h1>
<!-- run through the list of funds and display assign the information from $result to $activity -->
<?php
$i=0;
 while($activityDelete = mysql_fetch_array($resultDelete)) {
$i++;
 ?>
 <!-- Activate form: addForm03 -->
 <form class="form-group" name="addForm03" id="addForm03" method="post" enctype="multipart/form-data" action="functions/doFund.php" onsubmit="return show_reSubmit()" >
    <!-- Activate: client side error if field is blank upon "Submit"-->
    <div class="<?php if($activityDelete['strfund'] == 1) echo 'error'; ?>" >
        <label class="col-sm-2 control-label"></label>
        <div class="controls">
        <div class="input-append col-sm-4">
          <!-- **07-27: USE the htmlspecialchars(stripslashes ...) to show the content without the escape backslash (\). This would show if there were an error on the page -->
          <input type="text" class="form-control" id="fundActivate" name="fundActivate" class="textfield" required="required" value="<?= htmlspecialchars(stripslashes($activityDelete['strFund']), ENT_QUOTES);?>" />
          <input type="hidden" class="form-control" id="fundID" name="fundID" class="textfield"  value="<?= $activityDelete['fundID'];?>" />
          <input type="hidden" class="form-control" id="isHidden" name="isHidden" class="textfield"  value="<?= $activityDelete['isHidden'];?>" />
        </div> <!-- iinput-append: addForm03 -->
         <!-- activate button -->
        <span><button rel ="tooltip" onClick="setConfirmUnload(false);" title="Recover fund" id="reSubmit" type="submit" class="btn btn-default" name="reSubmit" ><i class="icon-white fa fa-undo"></i> Recover</button> </span>        </div> <!-- controls: addForm03 -->
    </div>  <!-- control-group: addForm03 -->
 </form>  <!-- Activate form: addForm03 -->
<?php
} // end While loop: Activate (isHidden) funds
?>
</div> <!-- form horizontal -->
</div> <!-- end panel panel-default -->


<!-- footer -->
<?php

include_once('includes/footer.php');
// authenticate users, includes db connection

?>
