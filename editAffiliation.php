<?php
include_once("includes/header.php");

$affiliationID = (int) $_GET["affiliationID"];
$sql = "SELECT * FROM tblAffiliation WHERE affiliationID=" . $affiliationID;
$resultAffiliation = mysql_query($sql);
$affiliationExists = mysql_numrows($resultAffiliation);
$affiliationArray = mysql_fetch_array($resultAffiliation);


      if ($_SESSION["success"] != "") {
          echo "<div class='alert alert-success alert-block'><h4>Success!</h4><p>" . $_SESSION["success"] . "</p></div>";
          $_SESSION["success"] = "";
}

      if ($_SESSION["error"] != "") {
          echo "<div class='alert alert-danger alert-block'><h4>Error!</h4><p>" . $_SESSION["error"] . "</p></div>";
          $_SESSION["error"] = "";
}

  // display al list of ACTIVE affiliations
  $sql = "SELECT * FROM tblAffiliation WHERE isHidden=0 ORDER BY strAffiliation;";
  $result = mysql_query($sql);

  // display al list of ARCHIVED affiliations
  $sqlArch = "SELECT * FROM tblAffiliation WHERE isHidden=1 ORDER BY strAffiliation;";
  $resultArch = mysql_query($sqlArch);

  // if we don't have a specific department ID, show me the list of departments in the database.
  if(empty($affiliationID)) { ?>

    <h3>Manage Affiliations</h3>
    <p>You can edit an affiliation at any time, simply click the affiliation below.
     To add a affiliation, click on the "Add Affiliation" button.</p>
    <p>Archive any affiliation by clicking the red button in the "Archive" column. </p>
    <div class="clearfix" style="margin-bottom: 5px;">
      <a href="addAffiliation.php" style="margin-left: 5px"; class="pull-right btn btn-default">Add Affiliation <i class="fa fa-plus-circle"></i></a>
    </div>

    <table class="table table-striped table-hover table-bordered">
        <tr>
          <td width="30%">Affiliation</td>
          <td width="10%">Archive</td>
        </tr>

        <!-- run through all of the departments and print them to the table. -->
        <?php
          while($affiliation = mysql_fetch_array($result))
        {
          echo "<tr>";
        ?>
            <!-- the form should go above so we get to use the POST funtionality and also the row height is optimal -->
    <form class="form-horizontal" name="delete" id="delete" method="post" enctype="multipart/form-data" action="functions/doEditAffiliation.php">

   <?php
         echo "<td><a href='editAffiliation.php?affiliationID=" . $affiliation["affiliationID"] . "'>" . $affiliation["strAffiliation"] . "</a></td>";
         echo "<td>" . ""?>

         <!-- Hidden fields to send info over to archive the department indicated -->
         <input type="hidden" class="span3" id="isHidden" name="isHidden" class="textfield"  value="<?= $affiliation['isHidden'];?>" />
         <input type="hidden" class="span3" id="affiliationID" name="affiliationID" class="textfield"  value="<?= $affiliation["affiliationID"];?>" />
         <input type="hidden" class="span3" id="affiliation" name="affiliation" class="textfield"  value="<?= $affiliation["strAffiliation"];?>" />

         <!-- delete button -->
         <button rel="tooltip" onClick="setConfirmUnload(false);" title="Delete the affiliation" type="submit" id="delete" class="btn btn-danger" name="delete" value="delete" ><i class="icon-white fa fa-remove"></i></button>

    </form> <!-- end form: delete -->

    <?php
      echo "</td>" . "</tr>";
        } // END while $affiliation = mysql_fetch_array($result) statement
    ?>

    </table> <!-- the above table is for the ACTIVE departments -->

    <?php
      if(!empty($resultArch))
      {
    ?>
      <h3 id='archAffiliation'>Archived Affiliations</h3>
      <p>You may activate an affiliation at any time. Click on the green box in the "Active" column to add the affiliation to the active affiliation list.</p>

      <table class="table table-striped table-hover table-bordered">
         <tr>
            <td width="30%">Affiliation</td>
          <td width="10%">Activate</td>
            </tr>

       <?php
       while($affiliationArch = mysql_fetch_array($resultArch))
       {
          echo "<tr>";?>

          <!-- the form should go above so we get to use the POST funtionality and also the row height is optimal -->
          <form class="form-horizontal" name="activate" id="activate" method="post" enctype="multipart/form-data" action="functions/doEditAffiliation.php">

           <?php
           echo "<td><a href='editAffiliation.php?affiliationID=" . $affiliationArch["affiliationID"] . "'>" . $affiliationArch["strAffiliation"] . "</a></td>";
           echo "<td>" ?>

           <!-- Hidden fields to send info over to activate the department indicated -->
           <input type="hidden" class="span3" id="isHidden" name="isHidden" class="textfield"  value="<?= $affiliationArch['isHidden'];?>" />
           <input type="hidden" class="span3" id="affiliationID" name="affiliationID" class="textfield"  value="<?= $affiliationArch["affiliationID"];?>" />
           <input type="hidden" class="span3" id="affilation" name="affiliation" class="textfield"  value="<?= $affiliationArch["strAffiliation"];?>" />

            <!-- activate button -->
           <button rel="tooltip" onClick="setConfirmUnload(false);" title="Activate the affiliation" type="submit" id="activate" class="btn btn-success" name="activate" value="activate" ><i class="icon-white fa fa-check"></i></button>

          </form> <!-- end form: activate -->


    <?php
      echo "</td>" . "</tr>";
       } // END $affiliationArch = mysql_fetch_array($resultArch) - while statement
    ?>

      </table> <!-- the above table is for the ARCHIVED affiliations -->

<!-- *************  Below changes the page to the "edit a single affiliation" once a link is pressed ******************************* -->
      <?php
      } // END if the archived results are NOT empty - while statement

      } // end if $affiliationID is empty, which means the list of affiliations will show as we are not on just one exact one to give is the ID.
      else if(!empty($affiliationID))
        { ?>
        <form class="form-horizontal" name="edit" id="edit" method="post" action="functions/doEditAffiliation.php?affiliationID=<?php echo $affiliationArray["affiliationID"]?>">
        <h3>Edit an Affiliation</h3>

          <div class="form-group <?php if($_SESSION['affiliationError'] == 1) echo 'error'; ?>">
             <label class="col-sm-2 control-label" for="affiliation">Affiliation</label>

             <div class="col-sm-4">
               <input type="text" class="form-control" id="affiliation" placeholder="Affiliation" name="affiliation" value="<?= htmlspecialchars(stripslashes($affiliationArray["strAffiliation"]), ENT_QUOTES);?>" >
                </div>
                <span class="inline-help text-danger">Required</span>
               <input type="hidden" class="span3" id="affiliationID" name="affiliationID" class="textfield"  value="<?= $affiliationArray["affiliationID"];?>" />


          </div>


            <button type="submit" onClick="setConfirmUnload(false);" name="edit" value="edit" id="edit" class="btn btn-block btn-primary btn-large">Update Affiliation</button>

        </form>

        <?php
        } // END if $affiliationID is NOT empty, which means the specific department will show so we can edit. Just one exact one to give is the ID.
        ?>

<!-- Above changes the page to the "edit a single department" ******************************************* -->

<?php

// clear the errors on refresh
$_SESSION["errorCounter"] = 0;
$_SESSION['affiliationError'] = 0;

?>

<?php
include_once("includes/footer.php");
?>