<?php
include_once('includes/header.php'); // authenticate users, includes db connection

//working list of topics
$sql = "SELECT * FROM tblTopic WHERE isHidden='0' ORDER BY strTopic;";
$result = mysql_query($sql);
$num_results = mysql_num_rows($result);

//deleted list of topics
$sqlDelete = "SELECT * FROM tblTopic WHERE isHidden='1' ORDER BY strTopic;";
$resultDelete = mysql_query($sqlDelete);
$num_resultsDelete = mysql_num_rows($resultDelete);


// test if there is a query error
if(!$result){
	die("database query failure");
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

<h3>Background Topics</h3>

<p>Please note: if you edit a topic, that topic will be edited throughout all recorded stories.</p><?php
             if($_SESSION['topicAddError'] == 1) {
               echo "<div class='alert alert-error'><i class='fa fa-exclamation'></i> Looks like you forgot to enter an topic. Please enter an topic before continuing.</div>";
             }
?>

     <!-- New form: addForm01 -->
   <form class="form-group" name="addForm01" id="addForm01" method="post" enctype="multipart/form-data" action="functions/doTopic.php">

         <!-- New Issue: client side error if field is blank upon "Submit" need to be required-->
      <div class="<?php if($_SESSION['topicAddError'] == 1) echo 'error'; ?>">

         	  <label class="col-sm-2 control-label" for="topicAdd">Add a new Topic</label>

          <div class="controls">
            <div class="input-append col-sm-4">
                 <!-- **07-27: USE the htmlspecialchars(stripslashes ...) to show the content without the escape backslash (\). This would show if there were an error on the page -->
                 <input type="text" class="form-control" id="topicAdd" name="topicAdd" class="textfield" placeholder="Issue" required ="required" value="<?= htmlspecialchars(stripslashes($_SESSION['topicAdd']), ENT_QUOTES);?>" />
            </div>  <!-- input-append -->
              <span><button action="submit" onClick="setConfirmUnload(false);" class="btn btn-primary" name ="submit" id="submit">Add</button> </span>


          </div> <!-- controls -->
       </div> <!-- control group -->
   </form> <!-- addForm01 -->



          <!-- Active Issue list -->


<!-- run through the list of topics and display assign the information from $result to $activity  -->
<?php

$i=0;
 while($activity = mysql_fetch_array($result)) {
$i++;

?>


    <!-- Edit or Delete form: addForm02 -->
 <form class="form-group" name="addForm02" id="addForm02" method="post" enctype="multipart/form-data" action="functions/doTopic.php">

    <!-- Edit or Delete: client side error if field is blank upon "Submit"-->
   <div class="<?php if($activity['strTopic'] == 1) echo 'error'; ?>" >
      <label class="col-sm-2 control-label"></label>
      <div class="controls">
         <div class="input-append col-sm-4">
                      <!-- **07-27: USE the htmlspecialchars(stripslashes ...) to show the content without the escape backslash (\). This would show if there were an error on the page -->
                      <input type="text" class="form-control" id="topicEdDel" name="topicEdDel" class="textfield" required="required" value="<?= htmlspecialchars(stripslashes($activity['strTopic']), ENT_QUOTES);?>" />

         <input type="hidden" class="form-control" id="topicID" name="topicID" class="textfield"  value="<?= $activity['topicID'];?>" />

         <input type="hidden" class="form-control" id="isHidden" name="isHidden" class="textfield"  value="<?= $activity['isHidden'];?>" />

         </div> <!-- input-append: addForm02 -->

            <span id="topicControls">

              <!-- edit button -->
             <button rel="tooltip" data-container="body" onClick="setConfirmUnload(false);" title="Edit the topic" type="submit "id="edit" class="btn btn-default" name="edit" value="edit" onclick="Clicked(this)">Edit <i class="fa fa-edit"></i></button>

              <!-- delete button -->
              <button rel="tooltip" data-container="body" onClick="setConfirmUnload(false);" title="Delete the topic" type="submit" id="delete" class="btn btn-danger" name="delete" value="delete" ><i class="icon-white fa fa-remove"></i></button>


           </span> <!-- topicControls: addForm02 -->


      </div> <!-- controls: addForm02 -->

    </div> <!-- control-group: addForm02 -->

 </form> <!-- end form: addForm02 -->



<?php
 } // end while loop for active topics
?>

</div> <!-- form horizontal -->
</div> <!-- end panel panel-default -->


          <!-- Below are the deleted (isHidden) items -->

<div class="panel panel-default" >
 <div class="panel-body form-horizontal">

          <h3>Archived Topics</h3>

          The following <i>topics</i> may be activated by clicking the checkmark.<br /><br />


<!-- run through the list of topics and display assign the information from $result to $activity -->
<?php

$i=0;
 while($activityDelete = mysql_fetch_array($resultDelete)) {
$i++;

 ?>


       <!-- Activate form: addForm03 -->
 <form class="form-group" name="addForm03" id="addForm03" method="post" enctype="multipart/form-data" action="functions/doTopic.php" onsubmit="return show_reSubmit()" >

    <!-- Activate: client side error if field is blank upon "Submit"-->
    <div class="<?php if($activityDelete['strTopic'] == 1) echo 'error'; ?>" >
        <label class="col-sm-2 control-label"></label>
        <div class="controls">
         <div class="input-append col-sm-4">
                      <!-- **07-27: USE the htmlspecialchars(stripslashes ...) to show the content without the escape backslash (\). This would show if there were an error on the page -->
                      <input type="text" class="form-control" id="topicActivate" name="topicActivate" class="textfield" required="required" value="<?= htmlspecialchars(stripslashes($activityDelete['strTopic']), ENT_QUOTES);?>" />

         <input type="hidden" class="form-control" id="topicID" name="topicID" class="textfield"  value="<?= $activityDelete['topicID'];?>" />

         <input type="hidden" class="form-control" id="isHidden" name="isHidden" class="textfield"  value="<?= $activityDelete['isHidden'];?>" />
         </div> <!-- iinput-append: addForm03 -->
               <!-- activate button -->
              <span><button rel ="tooltip" onClick="setConfirmUnload(false);" title="Activate Issue" id="reSubmit" type="submit" class="btn btn-success" name="reSubmit" ><i class="icon-white fa fa-check"></i></button> </span>


        </div> <!-- controls: addForm03 -->

    </div>  <!-- control-group: addForm03 -->

 </form>  <!-- Activate form: addForm03 -->


<?php
} // end While loop: Activate (isHidden) topics
?>

</div> <!-- form horizontal -->
</div> <!-- end panel panel-default -->


<!-- footer -->
<?php

include_once('includes/footer.php');
// authenticate users, includes db connection

?>
