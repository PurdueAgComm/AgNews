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
            $writerName[$i] = $row["strLastName"] . ", " . $row["strFirstName"];

          }

        if($row["isSource"] == 1) {
            $sourceID[$i] = $row["peopleID"];
            $sourceName[$i] = $row["strFirstName"] . " " . $row["strLastName"];
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

      $sql = "SELECT * FROM tblTopic;";
      $result = mysql_query($sql);
      $i = 0;
      while($row = mysql_fetch_array($result)) {
        $topicID[$i] = $row["topicID"];
        $topicName[$i] = $row["strTopic"];
        $i++;
      }

      $sql = "SELECT * FROM tblIssues;";
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



      <h1>Create A New Story</h1>


      <?php

       //display general error with information
        if ($_GET["isComplete"] == "false") {
          echo "<div class='alert alert-error alert-block'><h4>We need your attention! <span class='badge badge-important' style='position: relative; top: -2px;'>" . $_GET['count'] . " items</span></h4><p>" . $_SESSION['error'] . "</p></div>";
          $_SESSION["error"] = "";
        }
        if ($_SESSION["success"] != "") {
          echo "<div class='alert alert-success alert-block'><h4>Success!</h4><p>" . $_SESSION["success"] . "</p></div>";
          $_SESSION["success"] = "";
        }

      ?>

      <form class="form-horizontal" name="addForm" id="addForm" method="post" enctype="multipart/form-data" action="functions/doAddStory.php">

          <div class="well">
           <h3>News Story</h3>
             <?php
             if($_SESSION['storyError'] == 1) {
               echo "<div class='alert alert-error'><i class='icon-exclamation-sign'></i> Looks like you forgot to enter a story. Please enter one before continuing.</div>";
             } ?>

             <textarea style="width: 98%; height: 200px;" id="tinymce" name="story"><?= htmlspecialchars_decode($_SESSION['story']);?></textarea>
          </div>

          <div class="well">
            <h3>Internal Information</h3>
            <div class="control-group <?php if($_SESSION['filenameError'] == 1) echo 'error'; ?>">
              <label class="control-label" for="filename">Filename</label>
              <div class="controls">
                <input type="text" class="span3" id="filename" placeholder="Create a filename" name="filename" value="<?= $_SESSION['filename'];?>" > <span class="inline-help text-error">Required</span>
              </div>
            </div>

            <div class="control-group  <?php if($_SESSION['writerError'] == 1) echo 'error'; ?>">
              <label class="control-label" for="writer">Writer(s)<br /></label>
              <div class="controls" id="writers">
              <input type="text" class="span3" id="writer1" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a writer" name="writer1"  value="<?php if(!empty($_SESSION['writerID1'])) { echo $_SESSION['writerID1']; } else { echo $_SESSION['lastName'] . ', ' . $_SESSION['firstName'];}?>" /> <span id="writerControls"> <a onClick="addWriter();" rel="tooltip" title="Show more Writer fields" class="btn btn-small"><i class="fa fa-list"></i></a></span> <br />

<!--here-->
              <div id="shameHideWriters">
                <input type="text" class="span3" id="writer2" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a writer" name="writer2"  value="<?= $_SESSION['writerID2'];?>"/><br />
                <input type="text" class="span3" id="writer3" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a writer" name="writer3"  value="<?= $_SESSION['writerID3'];?>"/><br />
                <input type="text" class="span3" id="writer4" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a writer" name="writer4"  value="<?= $_SESSION['writerID4'];?>"/><br />
                <input type="text" class="span3" id="writer5" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a writer" name="writer5"  value="<?= $_SESSION['writerID5'];?>"/><br />
              </div>
            </div>
          </div>


            <div class="control-group <?php if($_SESSION['intentError'] == 1) echo 'error'; ?>">
              <label class="control-label" for="intent">Intent</label>
              <div class="controls">
                <textarea class="span3" name="intent"><?= $_SESSION['intent'];?></textarea>
              </div>
            </div>

            <div class="control-group <?php if($_SESSION['reachError'] == 1) echo 'error'; ?>">
              <label class="control-label" for="reach">Reach</label>
              <div class="controls">
               <select name="reach" class="span3">
              <?php
                $reach = array("Select Reach", "Global", "National", "Midwest", "State");
                foreach($reach as $value) {
                  if ($_SESSION['reach'] == $value) {
                    echo "<option selected='selected' value='".$value."'>".$value."</option>";
                  } else {
                    echo "<option value='".$value."'>".$value."</option>";
                  }
                }
              ?>
            </select>

              </div>
            </div>

          </div>

          <div class="well">
           <input type="submit" name="story2" onClick="setConfirmUnload(false);" class="btn btn-large btn-block btn-primary" value="Create Story" />
         </div>


        <div class="well">
          <h3>General Information</h3>
        <div class="control-group <?php if($_SESSION['headlineError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="headline">Headline</label>
          <div class="controls">
            <input type="text" class="span3" id="headline" placeholder="Create a headline" name="headline" value="<?= $_SESSION['headline'];?>" > <?php if($_SESSION['headlineError'] == 1) echo "<i class='icon-exclamation-sign' rel='tooltip' title='You either left the headline blank or are using a headline that already exists.'></i>"; ?>
          </div>
        </div>
        <div class="control-group  <?php if($_SESSION['sourceError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="source">Sources(s)</label>
          <div class="controls">
            <input type="text" class="span3" id="source1" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a source" name="source1"  value="<?= $_SESSION['sourceID1'];?>"  /> <span id="sourceControls"><a onClick="addSources();" rel="tooltip" title="Show more Source fields" class="btn btn-small"><i class="fa fa-list"></i></a></span> <a rel="tooltip" tabindex="-1" title="Create a new Source profile" data-toggle="modal" href="#myModal" role="button" class="btn btn-small"><i class="icon-plus-sign"></i></a> <br />
            <div id="shameHideSources">
              <input type="text" class="span3" id="source2" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a source" name="source2"  value="<?= $_SESSION['sourceID2'];?>"/><br />
              <input type="text" class="span3" id="source3" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a source" name="source3"  value="<?= $_SESSION['sourceID3'];?>"/><br />
              <input type="text" class="span3" id="source4" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a source" name="source4"  value="<?= $_SESSION['sourceID4'];?>"/><br />
              <input type="text" class="span3" id="source5" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a source" name="source5"  value="<?= $_SESSION['sourceID5'];?>"/><br />
            </div>
          </div>
        </div>
        <div class="control-group  <?php if($_SESSION['departmentError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="department">Department(s)</label>
          <div class="controls">
            <input type="text" class="span3" id="department1" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a department" name="department1"  value="<?= $_SESSION['departmentID1'];?>" /> <span id="departmentControls"><a onClick="addDepartments();" rel="tooltip" title="Show more Department fields" class="btn btn-small"><i class="fa fa-list"></i></a></span><br/>
            <div id="shameHideDepartments">
              <input type="text" class="span3" id="department2" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a department" name="department2"  value="<?= $_SESSION['departmentID2'];?>"/><br />
              <input type="text" class="span3" id="department3" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a department" name="department3"  value="<?= $_SESSION['departmentID3'];?>"/><br />
              <input type="text" class="span3" id="department4" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a department" name="department4"  value="<?= $_SESSION['departmentID4'];?>"/><br />
              <input type="text" class="span3" id="department5" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify a department" name="department5"  value="<?= $_SESSION['departmentID5'];?>"/><br />
            </div>
          </div>
        </div>

         <div class="control-group  <?php if($_SESSION['affiliationError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="affiliation">Affiliation(s)</label>
          <div class="controls">
            <input type="text" class="span3" id="affiliation1" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify an affiliation" name="affiliation1"  value="<?= $_SESSION['affiliationID1'];?>" /> <span id="affiliationControls"><a onClick="addAffiliations();" rel="tooltip" title="Show more Affiliation fields" class="btn btn-small"><i class="fa fa-list"></i></a></span><br />
            <div id="shameHideAffiliations">
              <input type="text" class="span3" id="affiliation2" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify an affiliation" name="affiliation2"  value="<?= $_SESSION['affiliationID2'];?>" /><br />
              <input type="text" class="span3" id="affiliation3" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify an affiliation" name="affiliation3"  value="<?= $_SESSION['affiliationID3'];?>" /><br />
              <input type="text" class="span3" id="affiliation4" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify an affiliation" name="affiliation4"  value="<?= $_SESSION['affiliationID4'];?>" /><br />
              <input type="text" class="span3" id="affiliation5" class="typeahead" data-provide="typeahead" data-items="4" placeholder="Specify an affiliation" name="affiliation5"  value="<?= $_SESSION['affiliationID5'];?>" /><br />
            </div>
          </div>
        </div>

        <div class="control-group <?php if($_SESSION['datePublishedError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="datePublished">Publish Date</label>
          <div class="controls">
            <div class="input-append date datePicker" id="dp3" data-date-format="yyyy-mm-dd">
               <?php
              if($_SESSION['datePublished'] == "") {
                $datePub = "";
              }
              else {
                $datePub = $_SESSION['datePublished'];
              }
             ?>

              <input class="span2" name="datePublished" size="16" type="text" value="<?= $datePub;?>" readonly><span class="add-on"><i class="icon-th"></i></span>
            </div>
          </div>
        </div>
      </div> <!-- end well -->


      <div class="well">
      <h3>Define Metadata</h3>

      <div class="control-group">
          <label class="control-label" for="isTopStory">This is an  <strong>Agriculture Top Story</strong></label>
          <div class="controls">
            <label class="checkbox">
             <?php if($_SESSION["isTopStory"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isTopStory"> Yes
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isTopStory"> Yes
              <?php } ?>
            </label>
        </div>
      </div>

      <div class="control-group">
          <label class="control-label" for="isTopStory">This is an  <strong>Extension Top Story</strong></label>
          <div class="controls">
            <label class="checkbox">
             <?php if($_SESSION["isExtTopStory"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isExtTopStory"> Yes
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isExtTopStory"> Yes
              <?php } ?>
            </label>
        </div>
      </div>


      <div class="control-group">
          <label class="control-label" for="isScience">This story is <strong>science news</strong> </label>
          <div class="controls">
            <label class="checkbox">
              <?php if($_SESSION["isScience"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" checked="checked" name="isScience"> Yes
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isScience"> Yes
              <?php } ?>
            </label>
        </div>
      </div>


        <div class="control-group <?php if($_SESSION['areaError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="college">Area(s)*</label>
          <div class="controls">
              <?php
              $sql = "SELECT * FROM tblArea;";
              $result = mysql_query($sql);
              $i = 0;

              while($row = mysql_fetch_array($result)) {

              if($_SESSION["area"][$i] != 0) {
                echo "<label class='checkbox inline'>";
                echo "<input type='checkbox' id='" . $row["areaID"] . "' value='" . $row["areaID"] . "' name='area[" . $i . "]' checked='checked'> " . $row["strArea"];
                echo "</label>";
              }
                else {
                  echo "<label class='checkbox inline'>";
                  echo "<input type='checkbox' id='" . $row["areaID"] . "' value='" . $row["areaID"] . "' name='area[" . $i . "]'> " . $row["strArea"];
                  echo "</label>";

                }

                $i++;

              }


            ?>
          </div>
        </div>

       <div class="control-group <?php if($_SESSION['topicError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="college">Background Topic(s)</label>
          <div class="controls">
              <?php
              $sql = "SELECT * FROM tblTopic WHERE isHidden='0';";
              $result = mysql_query($sql);
              $i = 0;

              while($row = mysql_fetch_array($result)) {

              if($_SESSION["topic"][$i] != 0) {
                echo "<label class='checkbox'>";
                echo "<input type='checkbox' id='" . $row["topicID"] . "' value='" . $row["topicID"] . "' name='topic[" . $i . "]' checked='checked'> " . $row["strTopic"];
                echo "</label>";
              }
                else {
                  echo "<label class='checkbox'>";
                  echo "<input type='checkbox' id='" . $row["topicID"] . "' value='" . $row["topicID"] . "' name='topic[" . $i . "]'> " . $row["strTopic"];
                  echo "</label>";

                }

                $i++;

              }


            ?>

          </div>

        </div>


       <div class="control-group <?php if($_SESSION['issueError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="college">Critical Issue(s)</label>
          <div class="controls">
              <?php
              $sql = "SELECT * FROM tblIssues WHERE isHidden='0';";
              $result = mysql_query($sql);
              $i = 0;

              while($row = mysql_fetch_array($result)) {

              if($_SESSION["issues"][$i] != 0) {
                echo "<label class='checkbox'>";
                echo "<input type='checkbox' id='" . $row["issuesID"] . "' value='" . $row["issuesID"] . "' name='issues[" . $i . "]' checked='checked'> " . $row["strIssues"];
                echo "</label>";
              }
                else {
                  echo "<label class='checkbox'>";
                  echo "<input type='checkbox' id='" . $row["issuesID"] . "' value='" . $row["issuesID"] . "' name='issues[" . $i . "]'> " . $row["strIssues"];
                  echo "</label>";
                }

                $i++;

              }
            ?>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="isConnections">Featured in:</label>
          <div class="controls">
            <label class="checkbox">
            <?php if($_SESSION["isConnections"] == 1) { ?>
              <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isConnections"> Connections
            <?php } else { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" name="isConnections"> Connections
            <?php } ?>
            </label>

            <label class="checkbox">
            <?php if($_SESSION["isAgricultures"] == 1) { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" checked="checked" name="isAgricultures"> Agricultures
            <?php } else { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" name="isAgricultures"> Agricultures
            <?php } ?>
            </label>

            <label class="checkbox">
            <?php if($_SESSION["isColumn"] == 1) { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" checked="checked" name="isColumn"> Columns
            <?php } else { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" name="isColumn"> Columns
            <?php } ?>
            </label>

           </div>
        </div>



      </div> <!-- end well -->

      <div class="well">
      <h3>Multimedia</h3>

        <div class="control-group">
          <label class="control-label" for="youtube">Youtube Video URL</label>
          <div class="controls">
            <input type="text" class="span3" id="youtube" name="youtube" placeholder="http://www.youtube.com"  value="<?= $_SESSION['youtube'];?>"/>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="website1">Related Website</label>
          <div class="controls">
            Title: <input type="text" class="span3" id="nameWebsite1" name="nameWebsite1" placeholder="Website Title"  value="<?= $_SESSION['websiteName1'];?>"/> Link: <input type="text" class="span3" id="website1" name="website1" placeholder="http://www.thewebsite.com"  value="<?= $_SESSION['websiteURL1'];?>"/> <span id="websiteControls"><a onClick="addWebsites();" rel="tooltip" title="Show more Related Website fields" class="btn btn-small"><i class="fa fa-list"></i></a></span> <span class="muted inline-help">Start with <strong>http://</strong></span> <br />
          </div>
        </div>

        <div id="shameHideWebsites">

        <div class="control-group">
          <label class="control-label" for="website2">Related Website</label>
          <div class="controls">
            Title: <input type="text" class="span3" id="nameWebsite2" name="nameWebsite2" placeholder="Website Title"  value="<?= $_SESSION['websiteName2'];?>"/> Link: <input type="text" class="span3" id="website2" name="website2" placeholder="http://www.thewebsite.com"  value="<?= $_SESSION['websiteURL2'];?>"/> <span class="muted inline-help">Start with <strong>http://</strong></span>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="website3">Related Website</label>
          <div class="controls">
            Title: <input type="text" class="span3" id="nameWebsite3" name="nameWebsite3" placeholder="Website Title"  value="<?= $_SESSION['websiteName3'];?>"/> Link: <input type="text" class="span3" id="website3" name="website3" placeholder="http://www.thewebsite.com"  value="<?= $_SESSION['websiteURL3'];?>"/> <span class="muted inline-help">Start with <strong>http://</strong></span>
          </div>
        </div>


        <div class="control-group">
          <label class="control-label" for="website4">Related Website</label>
          <div class="controls">
             Title: <input type="text" class="span3" id="nameWebsite4" name="nameWebsite4" placeholder="Website Title"  value="<?= $_SESSION['websiteName4'];?>"/> Link: <input type="text" class="span3" id="website4" name="website4" placeholder="http://www.thewebsite.com"  value="<?= $_SESSION['websiteURL4'];?>"/> <span class="muted inline-help">Start with <strong>http://</strong></span>
          </div>
        </div>


        <div class="control-group">
          <label class="control-label" for="website5">Related Website</label>
          <div class="controls">
           Title: <input type="text" class="span3" id="nameWebsite5" name="nameWebsite5" placeholder="Website Title"  value="<?= $_SESSION['websiteName5'];?>"/> Link: <input type="text" class="span3" id="website5" name="website5" placeholder="http://www.thewebsite.com"  value="<?= $_SESSION['websiteURL5'];?>"/> <span class="muted inline-help">Start with <strong>http://</strong></span>
          </div>
        </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="college">Included Media</label>
          <div class="controls">
              <?php

              if($_SESSION["isPhoto"] != 0) {
                echo "<label class='checkbox inline'>";
                echo "<input type='checkbox' value='1' name='isPhoto' checked='checked'> Photo";
                echo "</label>";
              }
                else {
                  echo "<label class='checkbox inline'>";
                  echo "<input type='checkbox' value='1' name='isPhoto'> Photo";
                  echo "</label>";
              }

              if($_SESSION["isVideo"] != 0) {
                echo "<label class='checkbox inline'>";
                echo "<input type='checkbox' value='1' name='isVideo' checked='checked'> Video";
                echo "</label>";
              }
                else {
                  echo "<label class='checkbox inline'>";
                  echo "<input type='checkbox' value='1' name='isVideo'> Video";
                  echo "</label>";
              }

              if($_SESSION["isGraphic"] != 0) {
                echo "<label class='checkbox inline'>";
                echo "<input type='checkbox' value='1' name='isGraphic' checked='checked'> Graphic";
                echo "</label>";
              }
                else {
                  echo "<label class='checkbox inline'>";
                  echo "<input type='checkbox' value='1' name='isGraphic'> Graphic";
                  echo "</label>";
              }

              if($_SESSION["isAudio"] != 0) {
                echo "<label class='checkbox inline'>";
                echo "<input type='checkbox' value='1' name='isAudio' checked='checked'> Audio";
                echo "</label>";
              }
                else {
                  echo "<label class='checkbox inline'>";
                  echo "<input type='checkbox' value='1' name='isAudio'> Audio";
                  echo "</label>";
              }




            ?>
          </div>
        </div>




      </div> <!-- end well -->

      <div class="well">
        <input type="submit" onClick="setConfirmUnload(false);"  name="story2" class="btn btn-large btn-block btn-primary" value="Create Story" />
      </div>


<!-- Modal -->

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add a Source</h3>
  </div>

  <div class="modal-body">

      <div class="control-group <?php if($_SESSION['fname01Error'] == 1) echo 'error'; ?>">
               <label class="control-label" for="fName01">First Name</label>
         <div class="controls">
               <input type="text" class="span3" id="fName01" placeholder="John" name="fname01"  value="<?= $_SESSION['fname01'];?>" />

         </div>
      </div>

      <div class="control-group <?php if($_SESSION['lname01Error'] == 1) echo 'error'; ?>">
              <label class="control-label" for="lName01">Last Name</label>
         <div class="controls">
               <input type="text" class="span3" id="lName01" placeholder="Doe" name="lname01" value="<?= $_SESSION['lname01'];?>" />

         </div>
      </div>

      <div class="control-group <?php if($_SESSION['dept01Error'] == 1) echo 'error'; ?>">
              <label class="control-label" for="dept01">Department</label>
         <div class="controls">
               <input type="text" class="span3" id="dept01" placeholder="Food Sciences" class="typeahead" data-provide="typeahead" data-items="4" name="dept01" value="<?= $_SESSION['dept01'];?>" />

         </div>
       </div>

      <div class="control-group <?php if($_SESSION['email01Error'] == 1) echo 'error'; ?>">
              <label class="control-label" for="email01">Email</label>
         <div class="controls">
               <input type="text" class="span3" id="email01" placeholder="john@purdue.edu" name="email01" value="<?= $_SESSION['email01'];?>" />

         </div>
       </div>

      <div class="control-group <?php if($_SESSION['phone01Error'] == 1) echo 'error'; ?>">
              <label class="control-label" for="phone01">Phone Number</label>
         <div class="controls">
               <input type="text" class="span3" id="phone01" placeholder="XXX-XXX-XXXX" name="phone01" title="Phone Format" data-toggle="tooltip" data-placement ="right" value="<?= $_SESSION['phone01'];?>" />
               <span class="help-block muted">Telephone Number Format: XXX-XXX-XXXX</span>
         </div>
      </div>

  </div>



  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <input type="submit" onClick="setConfirmUnload(false);" name="source" class="btn btn-primary" id="save" value="Add Source" />


  </div>

</div>

 </form>

<!-- END MODAL WINDOW -->


<!-- END MODAL WINDOW -->


    <?php

	$_SESSION["fname01Error"] = 0;
	$_SESSION["lname01Error"] = 0;
	$_SESSION["email01Error"] = 0;
	$_SESSION["phone01Error"] = 0;
	$_SESSION["dept01Error"] = 0;
	$_SESSION["errorCounter"] = 0;
	$_SESSION["errorSameSource"] = 0;
    $_SESSION['fname01'] = "";
	$_SESSION['lname01'] = "";
	$_SESSION['dept01']	= "";
	$_SESSION['email01'] = "";
	$_SESSION['phone01'] = "";
    $_SESSION["writerID1"]= "";

// global includes
include_once('includes/footer.php'); // authenticate users, includes db connection

?>


 <!-- PAGE-SPECIFIC SCRIPTS // addStory.php -->

<script type="text/javascript">

   $("#shameHideWriters").hide();
   $("#shameHideDepartments").hide();
   $("#shameHideSources").hide();
   $("#shameHideAffiliations").hide();
   $("#shameHideWebsites").hide();



</script>

 <script>
function addWriter() {
  $("#shameHideWriters").show();
  $("#writerControls").html("<a onClick='hideWriters()' class='btn btn-small'><i class='icon-eye-close'></i></a>");
}

function hideWriters() {
  $("#shameHideWriters").hide();
  $("#writerControls").html("<a onClick='addWriter();'' class='btn btn-small'><i class='icon-list'></i></a>");
}

function addSources() {
  $("#shameHideSources").show();
  $("#sourceControls").html("<a onClick='hideSources()' class='btn btn-small'><i class='icon-eye-close'></i></a>");
}

function hideSources() {
  $("#shameHideSources").hide();
  $("#sourceControls").html("<a onClick='addSources();'' class='btn btn-small'><i class='icon-list'></i></a>");
}

function addDepartments() {
  $("#shameHideDepartments").show();
  $("#departmentControls").html("<a onClick='hideDepartments()' class='btn btn-small'><i class='icon-eye-close'></i></a>");
}

function hideDepartments() {
  $("#shameHideDepartments").hide();
  $("#departmentControls").html("<a onClick='addDepartments();'' class='btn btn-small'><i class='icon-list'></i></a>");
}

function addAffiliations() {
  $("#shameHideAffiliations").show();
  $("#affiliationControls").html("<a onClick='hideAffiliations()' class='btn btn-small'><i class='icon-eye-close'></i></a>");
}

function hideAffiliations() {
  $("#shameHideAffiliations").hide();
  $("#affiliationControls").html("<a onClick='addAffiliations();'' class='btn btn-small'><i class='icon-list'></i></a>");
}

function addWebsites() {
  $("#shameHideWebsites").show();
  $("#websiteControls").html("<a onClick='hideWebsites()' class='btn btn-small'><i class='icon-eye-close'></i></a>");
}

function hideWebsites() {
  $("#shameHideWebsites").hide();
  $("#websiteControls").html("<a onClick='addWebsites();'' class='btn btn-small'><i class='icon-list'></i></a>");
}



</script>


 <script>
// Allows users to type and will match selection according to available data

 var writer = <?php echo "[";
               foreach($writerName as $wName) {
                echo "'" . $wName . "',";
              }
              echo "];"; ?>

 var writer1 = <?php echo "[";
               foreach($writerName as $wName) {
                echo "'" . $wName . "',";
              }
              echo "];"; ?>

 var department = <?php echo "[";
               foreach($deptName as $dName) {
                echo "'" . $dName . "',";
              }
              echo "];"; ?>

 var source = <?php echo "[";
               foreach($sourceName as $sName) {
                echo "'" . $sName . "',";
              }
              echo "];"; ?>

 var affiliation = <?php echo "[";
               foreach($affiliationName as $aName) {
                echo "'" . $aName . "',";
              }
              echo "];"; ?>


  $('#writer1').typeahead({source: writer});
  $('#writer2').typeahead({source: writer1});
  $('#writer3').typeahead({source: writer});
  $('#writer4').typeahead({source: writer});
  $('#writer5').typeahead({source: writer});

  $('#department1').typeahead({source: department});
  $('#department2').typeahead({source: department});
  $('#department3').typeahead({source: department});
  $('#department4').typeahead({source: department});
  $('#department5').typeahead({source: department});


  $('#dept01').typeahead({source: department})


  $('#source1').typeahead({source: source});
  $('#source2').typeahead({source: source});
  $('#source3').typeahead({source: source});
  $('#source4').typeahead({source: source});
  $('#source5').typeahead({source: source});


  $('#affiliation1').typeahead({source: affiliation});
  $('#affiliation2').typeahead({source: affiliation});
  $('#affiliation3').typeahead({source: affiliation});
  $('#affiliation4').typeahead({source: affiliation});
  $('#affiliation5').typeahead({source: affiliation});

</script>



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
