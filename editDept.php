<?php 
include_once("includes/header.php");

$deptID = (int) $_GET["deptID"];
$sql = "SELECT * FROM tblDept WHERE deptID=" . $deptID;
$resultDept = mysql_query($sql);
$deptExists = mysql_numrows($resultDept);
$deptArray = mysql_fetch_array($resultDept);


      if ($_SESSION["success"] != "") {
          echo "<div class='alert alert-success alert-block'><h4>Success!</h4><p>" . $_SESSION["success"] . "</p></div>";
          $_SESSION["success"] = "";
}

      if ($_SESSION["error"] != "") {
          echo "<div class='alert alert-error alert-block'><h4>Error!</h4><p>" . $_SESSION["error"] . "</p></div>";
          $_SESSION["error"] = "";
}
 
  // display al list of ACTIVE departments
  $sql = "SELECT * FROM tblDept WHERE isHidden=0 ORDER BY strDeptName;";
  $result = mysql_query($sql);

  // display al list of ARCHIVED departments
  $sqlArch = "SELECT * FROM tblDept WHERE isHidden=1 ORDER BY strDeptName;";
  $resultArch = mysql_query($sqlArch);
    
  // if we don't have a specific department ID, show me the list of departments in the database.
  if(empty($deptID)) { ?>  

    <h3>Manage Departments</h3>
    <p>You can edit a department at any time, simply click the department below. 
     To add a department, click on the "Add Department" button.</p>
    <p>Archive any department by clicking the red button in the "Archive" column. </p>
    <div class="clearfix" style="margin-bottom: 5px;">
      <a href="addDept.php" style="margin-left: 5px"; class="pull-right btn">Add Department <i class="icon-plus-sign"></i></a>
     <p><?php echo "<i rel='tooltip' title='College of Agriculture' class='icon-flag'></i>";?><font size=1> College of Agriculture department</font></p>  
    </div>

    <table class="table table-striped table-hover table-bordered">
        <tr>
          <td align="center" width="3%"></td>
          <td width="30%">Department</td>
          <td width="30%">College/Entity</td>
          <td width="10%">Archive</td>
        </tr>
        
        <!-- run through all of the departments and print them to the table. -->
        <?php
          while($dept = mysql_fetch_array($result)) 
        {
          echo "<tr>";
        ?>
            <!-- the form should go above so we get to use the POST funtionality and also the row height is optimal -->
    <form class="form-horizontal" name="delete" id="delete" method="post" enctype="multipart/form-data" action="functions/doEditDept.php"> 
        
    <?php     
        if($dept["strCollege"] == "College of Agriculture") 
        {
          echo "<td><i rel='tooltip' title='College of Agriculture' class='icon-flag'></i></td>";
        }
          else if($dept["strCollege"] !="Other Colleges/Entities") 
          {
            echo "<td><i rel='tooltip' title='Other Colleges/Entitiles' class='icon-star'></i></td>";
          }
      
            else if($dept["strCollege"]==" ") 
            {
              echo "<td><i rel='tooltip' title='No Role' class='icon-question-sign'></i></td>";
            }
         echo "<td><a href='editDept.php?deptID=" . $dept["deptID"] . "'>" . $dept["strDeptName"] . "</a></td>";
         echo "<td>" . $dept["strCollege"] . "</td>";
         echo "<td>" . ""?>
 
         <!-- Hidden fields to send info over to archive the department indicated -->
         <input type="hidden" class="span3" id="isHidden" name="isHidden" class="textfield"  value="<?= $dept['isHidden'];?>" /> 
         <input type="hidden" class="span3" id="deptID" name="deptID" class="textfield"  value="<?= $dept["deptID"];?>" /> 
         <input type="hidden" class="span3" id="deptName" name="deptName" class="textfield"  value="<?= $dept["strDeptName"];?>" /> 
     
         <!-- delete button -->
         <button rel="tooltip" onClick="setConfirmUnload(false);" title="Delete the department" type="submit" id="delete" class="btn btn-danger" name="delete" value="delete" ><i class="icon-white icon-remove"></i></button>

    </form> <!-- end form: delete -->
         
    <?php  
      echo "</td>" . "</tr>";
        } // END while $dept = mysql_fetch_array($result) statement
    ?>

    </table> <!-- the above table is for the ACTIVE departments -->

    <?php
      if(!empty($resultArch)) 
      { 
    ?>  
      <h3 id='archDept'>Archived Departments</h3>
      <p>You may activate a department at any time. Click on the green box in the "Active" column to add the department to the active department list.</p>

      <table class="table table-striped table-hover table-bordered">
         <tr>
            <td align="center" width="3%"></td>
            <td width="30%">Department</td>
            <td width="30%">College/Entity</td>
          <td width="10%">Activate</td>
            </tr>        

       <?php
       while($deptArch = mysql_fetch_array($resultArch)) 
       {
          echo "<tr>";?>

          <!-- the form should go above so we get to use the POST funtionality and also the row height is optimal -->          
          <form class="form-horizontal" name="activate" id="activate" method="post" enctype="multipart/form-data" action="functions/doEditDept.php"> 
                       
            <?php
              if($deptArch["strCollege"] == "College of Agriculture") 
              {
                echo "<td><i rel='tooltip' title='Project Manager' class='icon-flag'></i></td>";
              }
                else if($deptArch["strCollege"] !="College of Agriculture") 
                {
                  echo "<td><i rel='tooltip' title='Campus Colleges/Entitiles' class='icon-star'></i></td>";
                }          
                  else if($deptArch["strCollege"]==" ") 
                  {
                    echo "<td><i rel='tooltip' title='No Role' class='icon-question-sign'></i></td>";
                  }
           echo "<td><a href='editDept.php?deptID=" . $deptArch["deptID"] . "'>" . $deptArch["strDeptName"] . "</a></td>";
           echo "<td>" . $deptArch["strCollege"] . "</td>";
           echo "<td>" ?>
                
           <!-- Hidden fields to send info over to activate the department indicated -->
           <input type="hidden" class="span3" id="isHidden" name="isHidden" class="textfield"  value="<?= $deptArch['isHidden'];?>" /> 
           <input type="hidden" class="span3" id="deptID" name="deptID" class="textfield"  value="<?= $deptArch["deptID"];?>" /> 
           <input type="hidden" class="span3" id="deptName" name="deptName" class="textfield"  value="<?= $deptArch["strDeptName"];?>" /> 
             
            <!-- activate button -->
           <button rel="tooltip" onClick="setConfirmUnload(false);" title="Activate the department" type="submit" id="activate" class="btn btn-success" name="activate" value="activate" ><i class="icon-white icon-ok"></i></button>
 
          </form> <!-- end form: activate -->

      
    <?php  
      echo "</td>" . "</tr>";
       } // END $deptArch = mysql_fetch_array($resultArch) - while statement
    ?>

      </table> <!-- the above table is for the ARCHIVED departments -->

<!-- *************  Below changes the page to the "edit a single department" once a link is pressed ******************************* -->
      <?php 
      } // END if the archived results are NOT empty - while statement
 
      } // end if $deptID is empty, which means the list of departments will show as we are not on just one exact one to give is the ID.
      else if(!empty($deptID)) 
        { //**echo $deptArray["deptID"]; ?> 
        <form class="form-horizontal" name="edit" id="edit" method="post" action="functions/doEditDept.php?deptID=<?php echo $deptArray["deptID"]?>">
        <h3>Edit a Department</h3>
  
          <div class="control-group <?php if($_SESSION['deptNameError'] == 1) echo 'error'; ?>">
             <label class="control-label" for="department">Department Name</label>
            
             <div class="controls">
               <input type="text" class="span3" id="deptName" placeholder="Agricultural Communication" name="deptName" value="<?= htmlspecialchars(stripslashes($deptArray['strDeptName']), ENT_QUOTES);?>" > <span class="inline-help text-error">Required</span>
               <input type="hidden" class="span3" id="deptID" name="deptID" class="textfield"  value="<?= $deptArray["deptID"];?>" /> 

             </div>
          </div>

          <div class="control-group <?php if($_SESSION['collegeError'] == 1) echo 'error'; ?>">
             <label class="control-label" for="college">College/Entity</label>
            
             <div class="controls">
               <input type="text" class="span3" id="college" placeholder="College of Agriculture" name="college" value="<?= htmlspecialchars(stripslashes($deptArray["strCollege"]), ENT_QUOTES);?>" > <span class="inline-help text-error">Required</span>
             </div>
          </div>


          <div class="well">
            <button type="submit" onClick="setConfirmUnload(false);" name="edit" value="edit" id="edit" class="btn btn-block btn-primary btn-large">Update Department</button>
          </div>
        </form>

        <?php
        } // END if $deptID is NOT empty, which means the specific department will show so we can edit. Just one exact one to give is the ID.
        ?>

<!-- Above changes the page to the "edit a single department" ******************************************* -->

<?php

// clear the errors on refresh
$_SESSION["errorCounter"] = 0;
$_SESSION["collegeError"] = 0;
$_SESSION['deptNameError'] = 0;

?>

<?php 
include_once("includes/footer.php");
?>