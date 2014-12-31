    <?php
// global includes
include_once('includes/header.php'); // authenticate users, includes db connection



  // ##################################################################
  //  Dynamically produce names of WRITERS and SOURCES and AFFILIATIONS
  // ##################################################################
      $sql = "SELECT * FROM tblPeople;";
      $result = mysql_query($sql);
      $i = 0;
      while($row = mysql_fetch_array($result)) {
       
        if($row["isWriter"] == 1) {
            $writerID[$i] = $row["peopleID"];
            $writerName[$i] = $row["strFirstName"] . " " . $row["strLastName"];
 		}
        if($row["isSource"] == 1) {
            $sourceID[$i] = $row["peopleID"];
            $sourceName[$i] = $row["strFirstName"] . " " . $row["strLastName"]; //actual dropdown values before completing the sale
          }

        $i++; 
      }

      $sql = "SELECT * FROM tblAffiliation;";
      $result = mysql_query($sql);
      $i = 0;
      while($row = mysql_fetch_array($result)) {
        $affiliationID[$i] = $row["affiliationID"];
        $affiliationName[$i] = $row["strAffiliation"];
        $i++;
      }

    // ##################################################################
    //  Dynamically produce names of TOPICS, ISSUES, and AREAS, DEPTS
    // ##################################################################

      $sql = "SELECT * FROM tblTopic ORDER BY strTopic;";
      $result = mysql_query($sql);
      $i = 0;
      while($row = mysql_fetch_array($result)) {
        $topicID[$i] = $row["topicID"];
        $topicName[$i] = $row["strTopic"];
        $i++;
      }

      $sql = "SELECT * FROM tblIssues ORDER BY strIssues;";
      $result = mysql_query($sql);
      $i = 0;
      while($row = mysql_fetch_array($result)) {
        $issueID[$i] = $row["issuesID"];
        $issueName[$i] = $row["strIssues"];
        $i++;
      }


      $sql = "SELECT * FROM tblDept;";
      $result = mysql_query($sql);
      $i = 0;
      while($row = mysql_fetch_array($result)) {
        $deptID[$i] = $row["deptID"];
        $deptName[$i] = $row["strDeptName"];
        $i++;
      }
    ?>
 
<script type="text/javascript">


    function toggleSub(box, id) {
        // get reference to related content to display/hide
        var el = document.getElementById(id);
        
        if ( box.checked === true ) {
            el.style.display = 'block';
        } else {
            el.style.display = 'none';
        }
    }
        
    window.onload = function() {
        var create = document.forms['addForm'].elements['create'];		
        create.checked = false; // for soft reload
		var publish = document.forms['addForm'].elements['publish'];
        publish.checked = false; // for soft reload
        
        // attach function that calls toggleSub to onclick property of checkbox
        // toggleSub args: checkbox clicked on (this), id of element to show/hide
        create.onclick = function() { toggleSub(this, 'create_sub'); };
		publish.onclick = function() { toggleSub(this, 'publish_sub'); };
    };

</script>
     

 
      <h1>Reports</h1>


      <?php

       //display general error with information
        if ($_SESSION["error"] !== "") {
          echo "<div class='alert alert-error alert-block'><h4>We need your attention! <span class='badge badge-important' style='position: relative; top: -2px;'>" . $_GET['count'] . " items</span></h4><p>" . $_SESSION['error'] . "</p></div>";
          $_SESSION["error"] = "";
        }
        if ($_SESSION["success"] != "") {
          echo "<div class='alert alert-success alert-block'><h4>Success!</h4><p>" . $_SESSION["success"] . "</p></div>";
          $_SESSION["success"] = "";
        }

      ?>
    
      <form class="form-horizontal" name="addForm" id="addForm" method="post" enctype="multipart/form-data" action="functions/doExportNewsByDate.php">


      <div class="well">
            <h3>All Published News Stories Within a Date Range</h3>



        <div class="well">
          <h3>Report by Date</h3>
          
          
     <!-- below is the toggleForm -->     
    <form id="toggleForm" class="demoForm" >
    <p>
     <label class="checkbox">
     <input type="checkbox" value="1" name="publish"></input>Build a report by <strong>Published Date</strong></label>
    
    </p>

    <p>
     <label class="checkbox">
     <input type="checkbox" value="1" name="create"></input>Build a report by <strong>Creation Date</strong></label>
    
    </p>

<!-- This is for the PUBLISH date choice -->

  <div style="display:none" id="publish_sub">
        <div class="control-group <?php if($_SESSION['datePublishedBeginError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="datePublishedBegin">Publish Date Start</label>
          <div class="controls">
            <div class="input-append date datePicker" id="dp3" data-date-format="yyyy-mm-dd">
               <?php 
              if($_SESSION['datePublishedBegin'] == "") {
                $datePubBegin = "";
              } 
              else {
                $datePubBegin = $_SESSION['datePublishedBegin'];
              }
             ?>

              <input class="span2" id="datePublishedBegin" name="datePublishedBegin" size="16" type="text" value="<?= $datePubBegin;?>" ><span class="add-on"><i class="icon-th"></i></span> 
          </div>
        </div>
       </div>
       
         <div class="control-group <?php if($_SESSION['datePublishedEndError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="datePublishedEnd">Publish Date End</label>
          <div class="controls">
            <div class="input-append date datePicker" id="dp3" data-date-format="yyyy-mm-dd">
               <?php 
              if($_SESSION['datePublishedEnd'] == "") {
                $datePubEnd = "";
              } 
              else {
                $datePubEnd = $_SESSION['datePublishedEnd'];
              }
             ?>

              <input class="span2" id="datePublishedEnd" name="datePublishedEnd" size="16" type="text" value="<?= $datePubEnd;?>" ><span class="add-on"><i class="icon-th"></i></span> 
            </div>
          </div>
         </div>
</div> <!-- end PUBLISH DATE choice
       

<!-- ****END publish date choice -->


    <div style="display:none" id="create_sub">
     
<!-- BELOW this is where we put the div "active_sub" stuff that will show when clicked. This would be the Creation dates this time -->

      <div class="control-group <?php if($_SESSION['dateCreatedBeginError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="dateCreatedBegin">Created Date Start</label>
          <div class="controls">
            <div class="input-append date datePicker" id="dp3" data-date-format="yyyy-mm-dd">
               <?php 
              if($_SESSION['dateCreatedBegin'] == "") {
                $dateCreatedBegin = "";
              } 
              else {
                $dateCreatedBegin = $_SESSION['dateCreatedBegin'];
              }
             ?>

              <input class="span2" id="dateCreatedBegin" name="dateCreatedBegin" size="16" type="text" value="<?= $dateCreatedBegin;?>" ><span class="add-on"><i class="icon-th"></i></span> 
          </div>
        </div>
       </div> <!--End Creation Date Begin -->
       
       
       <div class="control-group <?php if($_SESSION['dateCreatedEndError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="dateCreatedEnd">Created Date End</label>
          <div class="controls">
            <div class="input-append date datePicker" id="dp3" data-date-format="yyyy-mm-dd">
               <?php 
              if($_SESSION['dateCreatedEnd'] == "") {
                $dateCreatedEnd = "";
              } 
              else {
                $dateCreatedEnd = $_SESSION['dateCreatedEnd'];
              }
             ?>

              <input class="span2" id="dateCreatedEnd" name="dateCreatedEnd" size="16" type="text" value="<?= $dateCreatedEnd;?>" ><span class="add-on"><i class="icon-th"></i></span> 
          </div>
        </div>
       </div>       
       

<!-- ABOVE this is where we put the div "active_sub" stuff that will show when clicked. This would be the Creation dates this time -->

</div>

 </div>
 
       <div class="well">      
        <input type="submit" onClick="setConfirmUnload(false);"  name="pubs" class="btn btn-large btn-block btn-primary" value="Generate News Release Report" />
      </div>

 
 </form> <!-- END toggle Form with hide/show date fields -->       
          
          
          <!-- ******************************** PLAYING UP THERE ***********************************-->
  
</div>

</form>  <!-- END addForm which is the form for hte entire page  -->   


<h3>Reports</h3>


<div class="row-fluid">
	<div class='span4 well'>
		<h4 class="text-center"><a href="functions/doExportNewsPublished.php">Download News <br /> Published</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="functions/doExportNewsPublished.php">Download  <i class="icon-download-alt"></i></a></p>
	</div>

	<div class='span4 well'>
		<h4 class="text-center"><a href="functions/doExportNewsByWriters.php">Download News <br/>Sorted By Writers</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="functions/doExportNewsByWriters.php">Download  <i class="icon-download-alt"></i></a></p>
	</div>
        
	<div class='span4 well'>
		<h4 class="text-center"><a href="functions/doExportNewsBySource.php">Download News <br/>Sorted By Sources</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="functions/doExportNewsBySource.php">Download  <i class="icon-download-alt"></i></a></p>
	</div>
    
</div>
    

<div class="row-fluid">
	<div class='span4 well'>
		<h4 class="text-center"><a href="functions/doExportNewsByArea.php">Download News <br/>Sorted By Areas</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="functions/doExportNewsByArea.php">Download  <i class="icon-download-alt"></i></a></p>
	</div>

	<div class='span4 well'>
		<h4 class="text-center"><a href="functions/doExportNewsByTopic.php">Download News <br/>Sorted By Topics</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="functions/doExportNewsByTopic.php">Download  <i class="icon-download-alt"></i></a></p>
	</div>

	<div class='span4 well'>
		<h4 class="text-center"><a href="functions/doExportNewsByIssue.php">Download News <br/>Sorted By Issues</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="functions/doExportNewsByIssue.php">Download  <i class="icon-download-alt"></i></a></p>
	</div>

</div>


<div class="row-fluid">
	<div class='span4 well'>
		<h4 class="text-center"><a href="functions/doExportNewsByDept.php">Download News <br/>Sorted By Department</a></h4>
		<p class="text-center"><img src="img/cp/Cloud-Download.png" width="20%" height="20%" alt="Download Log"></p>
		
		<p><a class='btn btn-block btn-small' <a href="functions/doExportNewsByDept.php">Download  <i class="icon-download-alt"></i></a></p>
	</div>

</div>



    <?php
	
$_SESSION["datePublishedBeginError"] = 0; 
$_SESSION["datePublishedEndError"] = 0;
$_SESSION["dateCreatedBeginError"] = 0; 
$_SESSION["dateCreatedEndError"] = 0;
$_SESSION["errorCounter"] = 0; 
$_SESSION["datePublishedBegin"] = "";
$_SESSION["datePublishedEnd"] = "";
$_SESSION["dateCreatedBegin"] = "";
$_SESSION["dateCreatedEnd"] = "";
$_SESSION["publish"] = "";
$_SESSION["create"] = "";
	
// global includes
include_once('includes/footer.php'); // authenticate users, includes db connection	

?>

 

<!-- DATE PICKER CODE -->
<script type="text/javascript" src="js/datepick/js/bootstrap-datepicker.js"></script>
 <link href="js/datepick/css/datepicker.css" media="all" rel="stylesheet" type="text/css" />
<script>

  $('.datePicker').datepicker({
    autoclose: "true"
});
</script>

<!-- ICE CODE-->
<script type="text/javascript" src="includes/ICE/ice-master.min.js"></script>
<script type="text/javascript" src="includes/ICE/lib/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
// ICE tracks changes by user and allows users to accept or reject changes using tinyMCE. 
// TODO: username from database with id

    tinymce.init({
      invalid_elements : "span", // removes word spans!!
      mode: "exact",
      elements: "tinymce",
      theme: "advanced",
      plugins: 'ice,icesearchreplace',
      theme_advanced_buttons1: "bold,italic,underline,link,|,bullist,numlist,|,undo,redo,code,|,search,replace,|,ice_togglechanges,ice_toggleshowchanges,iceacceptall,icerejectall,iceaccept,icereject",
      theme_advanced_buttons2: "",
      theme_advanced_buttons3: "",
      theme_advanced_buttons4: "",
      theme_advanced_toolbar_location: "top",
      theme_advanced_toolbar_align: "left",
      extended_valid_elements: "p,span[*],delete[*],insert[*]",
      ice: {
        user: { name: '<?php echo $_SESSION["userName"]; ?>', id: <?php echo $_SESSION["userID"]; ?>},
        preserveOnPaste: 'p,a[href],i,em,b,span',
        deleteTag: 'delete',
        insertTag: 'insert'
      },
      height: '500'
    });
</script>
