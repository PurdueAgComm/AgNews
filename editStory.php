    <?php
// global includes
include_once('includes/header.php'); // authenticate users, includes db connection
$newsID = (int) $_GET["newsID"];

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

      $sql = "SELECT * FROM tblAffiliation WHERE isHidden=0 ORDER BY strAffiliation;";
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


      $sql = "SELECT * FROM tblDept WHERE isHidden=0 ORDER BY strDeptName;";
      $result = mysql_query($sql);
      $i = 0;
      while($row = mysql_fetch_array($result)) {
        $deptID[$i] = $row["deptID"];
        $deptName[$i] = $row["strDeptName"];
        $i++;
      }


      // GET INFO ABOUT THIS STORY

      $sqlStory = "SELECT * FROM tblNews WHERE newsID=" . $newsID;
      $resultStory = mysql_query($sqlStory);
      $story = mysql_fetch_array($resultStory);


      // get writers
      $sqlWriters = "SELECT tblPeople.peopleID, tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $newsID;
  	  $resultWriters = mysql_query($sqlWriters);

      $sqlSources = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . mysql_escape_string($_GET["newsID"]);
      $resultSources = mysql_query($sqlSources);

      $sqlDepts = "SELECT tblDept.strDeptName, tblDept.strCollege FROM tblDept INNER JOIN tblNewsDept ON tblNewsDept.deptID = tblDept.deptID WHERE tblNewsDept.newsID=" . mysql_escape_string($_GET["newsID"]);
      $resultDepts = mysql_query($sqlDepts);

      $sqlAffiliations = "SELECT tblAffiliation.strAffiliation FROM tblAffiliation INNER JOIN tblNewsAffiliation ON tblNewsAffiliation.affiliationID = tblAffiliation.affiliationID WHERE tblNewsAffiliation.newsID=" . mysql_escape_string($_GET["newsID"]);
      $resultAffiliations = mysql_query($sqlAffiliations);


      $storyTitle = (!empty($story["strHeadline"]) ? $story["strHeadline"] : $story["strFilename"]);

    ?>

      <h3>Update Story: <span class="muted"> <?php echo htmlspecialchars(stripslashes($storyTitle), ENT_QUOTES); ?></span></h3>





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

      <form class="form-horizontal" name="addForm" id="addForm" method="post" enctype="multipart/form-data" action="functions/doEditStory.php?newsID=<?php echo $newsID; ?>">

          <div class="well" style="clear: both;">
           <h3>News Story</h3>
             <?php
             if($_SESSION['storyError'] == 1) {
               echo "<div class='alert alert-error'><i class='icon-exclamation-sign'></i> Looks like you forgot to enter a story. Please enter one before continuing.</div>";
             } ?>

             <textarea style="width: 98%; height: 200px;" id="tinymce" name="story"><?= htmlspecialchars_decode($story["txtBody"]);?></textarea>
          </div>

          <div style="margin-bottom: 20px;">
          <input type="submit" value="Update Story" onClick="setConfirmUnload(false);" class="btn btn-block" />
          </div>

          <div class="well">
            <h3>Internal Information</h3>
            <div class="control-group <?php if($_SESSION['filenameError'] == 1) echo 'error'; ?>">
              <label class="control-label" for="filename">Filename</label>
              <div class="controls">
                <input type="text" class="span3" id="filename" placeholder="Create a filename" name="filename" value="<?= htmlspecialchars(stripslashes($story["strFilename"]), ENT_QUOTES);?>" > <span class="inline-help text-error">Required</span>
              </div>
            </div>

            <div class="control-group  <?php if($_SESSION['writerError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="writer">Writer(s)*<br /></label>
            <div class="controls" id="writers">

                <?php
                $numWriters = 1;

                while($writers = mysql_fetch_array($resultWriters)) {

                  if($numWriters===2) {
                    echo "<div id='shameHideWriters'>";
                  }

                  if(!empty($writers["strFirstName"])) {

                    if($numWriters === 1) {
                      // display control since it's the first box
      			      // **07-27: USE htmlspecialchars on the $writers. SERIOUSLY Don't forget the ENT_QUOTES to hit the apostrophes. We see this info coming into the editStory.php page.
                          echo "<input type='text' class='span3' id='writer" . $numWriters . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a writer' name='writer" . $numWriters . "'  value='" . htmlspecialchars(stripslashes($writers["strFirstName"]), ENT_QUOTES) . " " . htmlspecialchars(stripslashes($writers["strLastName"]), ENT_QUOTES) . "'/><span id='writerControls'> <a onClick='addWriter();' rel='tooltip' title='Show more Writer fields' class='btn btn-small'><i class='icon-list'></i></a></span><br />";
                    }
                    else {
                      // don't display control
                      echo "<input type='text' class='span3' id='writer" . $numWriters . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a writer' name='writer" . $numWriters . "'  value='" . htmlspecialchars(stripslashes($writers["strFirstName"]), ENT_QUOTES) . " " . htmlspecialchars(stripslashes($writers["strLastName"]), ENT_QUOTES) . "'/><br />";
                    }
                  }

                  else {
                    echo "<input type='text' class='span3' id='writer" . $numWriters . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a writer' name='writer" . $numWriters . "'><br />";
                  }


                  $numWriters++;
                }

              for($i=$numWriters; $i<6; $i++) {

                if($i===2) {
                  echo "<div id='shameHideWriters'>";
                }

                if($i==1) {
                  echo "<input type='text' class='span3' id='writer" . $i . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a writer' name='writer" . $i . "'><br />";
                }
                else {
                  echo "<input type='text' class='span3' id='writer" . $i . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a writer' name='writer" . $i . "'><br />";
                }



              }
              ?>
            </div>
          </div>
        </div>

            <a name="intent"></a>
            <div class="control-group <?php if($_SESSION['intentError'] == 1) echo 'error'; ?>">
              <label class="control-label" for="intent">Intent</label>
              <div class="controls">
                <textarea class="span3" name="intent"><?= $story["txtIntent"];?></textarea>
              </div>
            </div>

            <a name="reach"></a>
            <div class="control-group <?php if($_SESSION['reachError'] == 1) echo 'error'; ?>">
              <label class="control-label" for="reach">Reach</label>
              <div class="controls">
               <select name="reach" class="span3">
              <?php
                $reach = array("Select Reach", "Global", "National", "Midwest", "State");
                foreach($reach as $value) {
                  if ($story["strReach"] == $value) {
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

          <div style="margin-bottom: 20px;">
          <input type="submit" value="Update Story" onClick="setConfirmUnload(false);" class="btn btn-block" />
          </div>





        <div class="well">
          <h3>General Information</h3>
        <div class="control-group <?php if($_SESSION['headlineError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="headline">Headline*</label>
          <div class="controls">
            <input type="text" class="span3" id="headline" placeholder="Create a headline" name="headline" value="<?= htmlspecialchars(stripslashes($story["strHeadline"]), ENT_QUOTES);?>"> <?php if($_SESSION['headlineError'] == 1) echo "<i class='icon-exclamation-sign' rel='tooltip' title='You either left the headline blank or are using a headline that already exists.'></i>"; ?>
          </div>
        </div>

        <div class="control-group <?php if($_SESSION['tweetError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="tweet">Tweet*</label>
          <div class="controls">
            <input type="text" class="span3" id="tweet" placeholder="Specify a custom tweet" name="tweet" value="<?= htmlspecialchars(stripslashes($story["strTweet"]), ENT_QUOTES);?>"> <span id="count" class="muted"></span>
          </div>
        </div>


        <a name="sources"></a>
        <div class="control-group  <?php if($_SESSION['sourceError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="source">Source(s)*</label>
          <div class="controls">

            <?php
              $numSources = 1;

              while($sources = mysql_fetch_array($resultSources)) {

                if($numSources===2) {
                  echo "<div id='shameHideSources'>";
                }
                if(!empty($sources["strFirstName"])) {

				  if($numSources === 1) {
                    // display control since it's the first box
                    echo "<input type='text' class='span3' id='source" . $numSources . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a source' name='source" . $numSources . "'  value='" . htmlspecialchars($sources["strFirstName"], ENT_QUOTES) . " " . htmlspecialchars($sources["strLastName"], ENT_QUOTES) . "'/><span id='sourceControls'> <a onClick='addSources();' rel='tooltip' title='Show more Source fields' class='btn btn-small'><i class='icon-list'></i></a></span> <a rel='tooltip' tabindex='-1' title='Create a new Source profile' data-toggle='modal' href='#myModal' role='button' class='btn btn-small'><i class='icon-plus-sign'></i></a><br />";
      			    // **07-27: USE htmlspecialchars on the $sources. SERIOUSLY Don't forget the ENT_QUOTES to hit the apostrophes. We see this info coming into the editStory.php page.

                  }
                  else {
                    // don't display control
                    echo "<input type='text' class='span3' id='source" . $numSources . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a source' name='source" . $numSources . "'  value='" . htmlspecialchars($sources["strFirstName"], ENT_QUOTES) . " " . htmlspecialchars($sources["strLastName"], ENT_QUOTES) . "'/><br />";
                  }
                }

                else {
                  echo "<input type='text' class='span3' id='source" . $numSources . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a source' name='source" . $numSources . "'><br />";
                }


                $numSources++;
              }

            for($i=$numSources; $i<6; $i++) {

              if($i===2) {
                echo "<div id='shameHideSources'>";
              }

              if($i==1) {
                echo "<input type='text' class='span3' id='source" . $i . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a source' name='source" . $i . "'><span id='sourceControls'> <a onClick='addSources();' rel='tooltip' title='Show more Source fields' class='btn btn-small'><i class='icon-list'></i></a></span> <a rel='tooltip' tabindex='-1' title='Create a new Source profile' data-toggle='modal' href='#myModal' role='button' class='btn btn-small'><i class='icon-plus-sign'></i></a><br />";

              }
              else {
                echo "<input type='text' class='span3' id='source" . $i . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a source' name='source" . $i . "'><br />";
              }
            }
            ?>
            </div>
          </div>
        </div>


        <a name="depts"></a>
        <div class="control-group  <?php if($_SESSION['departmentError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="department">Department(s)*</label>
          <div class="controls">
             <?php
              $numDepts = 1;

              while($depts = mysql_fetch_array($resultDepts)) {

                if($numDepts===2) {
                  echo "<div id='shameHideDepartments'>";
                }

                if(!empty($depts["strDeptName"])) {

                  if($numDepts === 1) {
                    // display control since it's the first box
                    echo "<input type='text' class='span3' id='department" . $numDepts . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a department' name='department" . $numDepts . "'  value='" . htmlspecialchars(stripslashes($depts["strDeptName"]), ENT_QUOTES) .  "'/><span id='departmentControls'> <a onClick='addDepartments();' rel='tooltip' title='Show more Department fields' class='btn btn-small'><i class='icon-list'></i></a></span><br />";
                  }
                  else {
                    // don't display control
                    echo "<input type='text' class='span3' id='department" . $numDepts . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a department' name='department" . $numDepts . "'  value='" . htmlspecialchars(stripslashes($depts["strDeptName"]), ENT_QUOTES) . "'/><br />";
                  }
                }

                else {
                  echo "<input type='text' class='span3' id='department" . $numDepts . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a department' name='department" . $numDepts . "'><br />";
                }


                $numDepts++;
              }

            for($i=$numDepts; $i<6; $i++) {

              if($i===2) {
                echo "<div id='shameHideDepartments'>";
              }

              if($i==1) {
                echo "<input type='text' class='span3' id='department" . $i . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a department' name='department" . $i . "'><span id='departmentControls'> <a onClick='addDepartments();' rel='tooltip' title='Show more Department fields' class='btn btn-small'><i class='icon-list'></i></a></span><br />";
              }
              else {
                echo "<input type='text' class='span3' id='department" . $i . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a department' name='department" . $i . "'><br />";
              }
            }
            ?>


            </div>
          </div>
        </div>

         <a name="affiliations"></a>
         <div class="control-group  <?php if($_SESSION['affiliationError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="affiliation">Affiliation(s)</label>
          <div class="controls">

            <?php
              $numAffiliations = 1;

              while($affiliations = mysql_fetch_array($resultAffiliations)) {

                if($numAffiliations===2) {
                  echo "<div id='shameHideAffiliations'>";
                }

                if(!empty($affiliations["strAffiliation"])) {

                  if($numAffiliations === 1) {
                    // display control since it's the first box
                    echo "<input type='text' class='span3' id='affiliation" . $numAffiliations . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a affiliation' name='affiliation" . $numAffiliations . "'  value='" . htmlspecialchars(stripslashes($affiliations["strAffiliation"]), ENT_QUOTES) .  "'/> <span id='affiliationControls'> <a onClick='addAffiliations();' rel='tooltip' title='Show more Affiliation fields' class='btn btn-small'><i class='icon-list'></i></a></span><br />";
                  }
                  else {
                    // don't display control
                    echo "<input type='text' class='span3' id='affiliation" . $numAffiliations . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a affiliation' name='affiliation" . $numAffiliations . "'  value='" . htmlspecialchars(stripslashes($affiliations["strAffiliation"]), ENT_QUOTES) . "'/><br />";
                  }
                }

                else {
                  echo "<input type='text' class='span3' id='affiliation" . $numAffiliations . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a affiliation' name='affiliation" . $numAffiliations . "'><br />";
                }
                $numAffiliations++;
              }

            for($i=$numAffiliations; $i<6; $i++) {

              if($i===2) {
                echo "<div id='shameHideAffiliations'>";
              }

              if($i==1) {
                echo "<input type='text' class='span3' id='affiliation" . $i . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a affiliation' name='affiliation" . $i . "'><span id='affiliationControls'> <a onClick='addAffiliations();' rel='tooltip' title='Show more Affiliation fields' class='btn btn-small'><i class='icon-list'></i></a></span><br />";
              }
              else {
                echo "<input type='text' class='span3' id='affiliation" . $i . "' class='typeahead' data-provide='typeahead' data-items='4' placeholder='Specify a affiliation' name='affiliation" . $i . "'><br />";
              }

            }
            ?>

            </div>
          </div>
        </div>

        <a name="pubDate"></a>
        <div class="control-group <?php if($_SESSION['datePublishedError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="datePublished">Publish Date</label>
          <div class="controls">
            <div class="input-append date datePicker" id="dp3" data-date-format="yyyy-mm-dd">
            <?php
              if($story["datePublished"] == "0000-00-00") {
                $datePub = "";
              }
              else {
                $datePub = $story["datePublished"];
              }
             ?>

              <input class="span2" name="datePublished" size="16" type="text" value="<?= $datePub; ?>" readonly><span class="add-on"><i class="icon-th"></i></span>
            </div>
          </div>
        </div>


          <a name="areas"></a>
         <div class="control-group <?php if($_SESSION['areaError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="college">Area(s)*</label>
          <div class="controls">
         <?php
            $i = 1;
            $sql = "SELECT * FROM tblArea;";
            $result = mysql_query($sql);
            while($row = mysql_fetch_array($result)) {
                $sql2 = "SELECT * FROM tblNewsArea WHERE newsID=" . $newsID . " AND areaID=" . $row["areaID"];
                $result2 = mysql_query($sql2);
                $row2 = mysql_fetch_array($result2);

                if($row2["newsAreaID"] != "") {
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

          <a name="storyURL"></a>
         <div class="control-group <?php if($_SESSION['urlError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="url">Story URL</label>
          <div class="controls">
            <div class="input-append">
              <span class="add-on"><i class="icon-tag"></i></span>
              <input type="text" class="span3" id="url" placeholder="Enter the URL of the News Story" name="url" value="<?= $story["strURL"];?>"> <button rel="tooltip" title="Shortcut to save story." onClick="setConfirmUnload(false);"  type="submit" class="btn" /><i class="icon-refresh"></i></button>
            </div>
          </div>
        </div>

        <a name="imageURL"></a>
        <div class="control-group <?php if($_SESSION['imageError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="image">Story Image</label>
          <div class="controls">
            <div class="input-append">
              <span class="add-on"><i class="icon-picture"></i></span>
              <input type="text" class="span3" id="image" placeholder="Enter URL of Story Photo" name="image" value="<?= $story["strImage"];?>"> <button rel="tooltip" title="Shortcut to save story." onClick="setConfirmUnload(false);"  type="submit" class="btn" /><i class="icon-refresh"></i></button>
            </div>

          </div>
        </div>

        <div class="control-group">
          <div class="controls">

          </div>
       </div>

      </div> <!-- end well -->

      <div style="margin-bottom: 20px;">
          <input type="submit" value="Update Story" onClick="setConfirmUnload(false);"  class="btn btn-block" />
      </div>

      <div class="well">
      <h3>Define Metadata</h3>

      <div class="control-group">
          <label class="control-label" for="isTopStory">This is an <strong>Agriculture Top Story</strong></label>
          <div class="controls">
            <label class="checkbox">
              <?php if($story["isTopStory"] == 1) { ?>
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
              <?php if($story["isScience"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" checked="checked" name="isScience"> Yes
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isScience"> Yes
              <?php } ?>
            </label>
        </div>
      </div>



      <a name="topics"></a>
       <div class="control-group <?php if($_SESSION['topicError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="college">Background Topic(s)</label>
          <div class="controls">

          <?php
            $i = 1;
            $sql = "SELECT * FROM tblTopic WHERE isHidden=0 ORDER BY strTopic;";
            $result = mysql_query($sql);
            while($row = mysql_fetch_array($result)) {
                $sql2 = "SELECT * FROM tblNewsTopic WHERE isHidden=0 AND newsID=" . $newsID . " AND topicID=" . $row["topicID"];
                $result2 = mysql_query($sql2);
                $row2 = mysql_fetch_array($result2);

                if($row2["newsTopicID"] != "") {
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

       <a name="issues"></a>
       <div class="control-group <?php if($_SESSION['issueError'] == 1) echo 'error'; ?>">
          <label class="control-label" for="college">Critical Issue(s)</label>
          <div class="controls">
            <?php
              $i = 1;
              $sql = "SELECT * FROM tblIssues WHERE isHidden=0 ORDER BY strIssues;";
              $result = mysql_query($sql);
              while($row = mysql_fetch_array($result)) {
                  $sql2 = "SELECT * FROM tblNewsIssues WHERE isHidden=0 AND newsID=" . $newsID . " AND issuesID=" . $row["issuesID"];
                  $result2 = mysql_query($sql2);
                  $row2 = mysql_fetch_array($result2);

                  if($row2["newsIssuesID"] != "") {
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
            <?php if($story["isConnections"] == 1) { ?>
              <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isConnections"> Connections
            <?php } else { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" name="isConnections"> Connections
            <?php } ?>
            </label>

            <label class="checkbox">
            <?php if($story["isAgricultures"] == 1) { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" checked="checked" name="isAgricultures"> Agricultures
            <?php } else { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" name="isAgricultures"> Agricultures
            <?php } ?>
            </label>

            <label class="checkbox">
            <?php if($story["isColumn"] == 1) { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" checked="checked" name="isColumn"> Columns
            <?php } else { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" name="isColumn"> Columns
            <?php } ?>
            </label>

            <label class="checkbox">
            <?php if($story["isAnswers"] == 1) { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" checked="checked" name="isAnswers"> Ag Answers
            <?php } else { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" name="isAnswers"> Ag Answers
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
            <input type="text" class="span3" id="youtube" name="youtube" placeholder="http://www.youtube.com"  value="<?= $story["strVideo"] ?>"/>
          </div>
        </div>


        <a name="websites"></a>
        <div class="control-group">
          <label class="control-label" for="website1">Related Website</label>
          <div class="controls">
            Title: <input type="text" class="span3" id="nameWebsite1" name="nameWebsite1" placeholder="Website Title"  value="<?= $story['strWebsiteTitle1'];?>"/> Link: <input type="text" class="span3" id="website1" name="website1" placeholder="http://www.thewebsite.com"  value="<?= $story['strWebsite1'];?>"/> <span class="muted inline-help">Start with <strong>http://</strong></span>
          </div>
        </div>

        <div id="shameHideWebsites">

        <div class="control-group">
          <label class="control-label" for="website2">Related Website</label>
          <div class="controls">
            Title: <input type="text" class="span3" id="nameWebsite2" name="nameWebsite2" placeholder="Website Title"  value="<?= $story['strWebsiteTitle2'];?>"/> Link: <input type="text" class="span3" id="website2" name="website2" placeholder="http://www.thewebsite.com"  value="<?= $story['strWebsite2'];?>"/>  <span class="muted inline-help">Start with <strong>http://</strong></span>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="website3">Related Website</label>
          <div class="controls">
            Title: <input type="text" class="span3" id="nameWebsite3" name="nameWebsite3" placeholder="Website Title"  value="<?= $story['strWebsiteTitle3'];?>"/> Link: <input type="text" class="span3" id="website3" name="website3" placeholder="http://www.thewebsite.com"  value="<?= $story['strWebsite3'];?>"/> <span class="muted inline-help">Start with <strong>http://</strong></span>
          </div>
        </div>


        <div class="control-group">
          <label class="control-label" for="website4">Related Website</label>
          <div class="controls">
             Title: <input type="text" class="span3" id="nameWebsite4" name="nameWebsite4" placeholder="Website Title"  value="<?= $story['strWebsiteTitle4'];?>"/> Link: <input type="text" class="span3" id="website4" name="website4" placeholder="http://www.thewebsite.com"  value="<?= $story['strWebsite4'];?>"/> <span class="muted inline-help">Start with <strong>http://</strong></span>
          </div>
        </div>


        <div class="control-group">
          <label class="control-label" for="website5">Related Website</label>
          <div class="controls">
            Title: <input type="text" class="span3" id="nameWebsite5" name="nameWebsite5" placeholder="Website Title"  value="<?= $story['strWebsiteTitle5'];?>"/> Link: <input type="text" class="span3" id="website5" name="website5" placeholder="http://www.thewebsite.com"  value="<?= $story['strWebsite5'];?>"/> <span class="muted inline-help">Start with <strong>http://</strong></span>
          </div>
        </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="college">Included Media</label>
          <div class="controls">
              <?php

              if($story["isPhoto"] != 0) {
                echo "<label class='checkbox inline'>";
                echo "<input type='checkbox' value='1' name='isPhoto' checked='checked'> Photo";
                echo "</label>";
              }
                else {
                  echo "<label class='checkbox inline'>";
                  echo "<input type='checkbox' value='1' name='isPhoto'> Photo";
                  echo "</label>";
              }

              if($story["isVideo"] != 0) {
                echo "<label class='checkbox inline'>";
                echo "<input type='checkbox' value='1' name='isVideo' checked='checked'> Video";
                echo "</label>";
              }
                else {
                  echo "<label class='checkbox inline'>";
                  echo "<input type='checkbox' value='1' name='isVideo'> Video";
                  echo "</label>";
              }

              if($story["isGraphic"] != 0) {
                echo "<label class='checkbox inline'>";
                echo "<input type='checkbox' value='1' name='isGraphic' checked='checked'> Graphic";
                echo "</label>";
              }
                else {
                  echo "<label class='checkbox inline'>";
                  echo "<input type='checkbox' value='1' name='isGraphic'> Graphic";
                  echo "</label>";
              }

              if($story["isAudio"] != 0) {
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

      </div>

      <div class="well">
        <input type="submit" onClick="setConfirmUnload(false);"  name="story2" class="btn btn-large btn-block btn-primary" value="Create Story" />
      </div>


<!-- ************************************************************************-->
<!-- BEGIN MODAL WINDOW -->


<!-- BEGIN MODAL WINDOW -->
<!-- ************************************************************************-->

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add a Source</h3>
  </div>

  <div class="modal-body">

      <div class="control-group <?php if($_SESSION['fname01Error'] == 1) echo 'error'; ?>">
               <label class="control-label" for="fName01">First Name</label>
         <div class="controls">
               <input type="text" class="span3" id="fName01" placeholder="John" name="fname01"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION["fname01"]), ENT_QUOTES);?>" />
               <!-- **07-27: htmlspecialchars_decode is used to take care of the single quote possible within the name. This interprets the code stored in the database to display the actual character -->

         </div>
      </div>

      <div class="control-group <?php if($_SESSION['lname01Error'] == 1) echo 'error'; ?>">
              <label class="control-label" for="lName01">Last Name</label>
         <div class="controls">
               <input type="text" class="span3" id="lName01" placeholder="Doe" name="lname01" value="<?= htmlspecialchars_decode(stripslashes($_SESSION["lname01"]), ENT_QUOTES);?>" />
               <!-- **07-27: htmlspecialchars_decode is used to take care of the single quote possible within the name. This interprets the code stored in the database to display the actual character -->
         </div>
      </div>

      <div class="control-group <?php if($_SESSION['dept01Error'] == 1) echo 'error'; ?>">
              <label class="control-label" for="dept01">Department</label>
         <div class="controls">
        <input type="text" class="span3" id="dept01" placeholder="Food Sciences" class="typeahead" data-provide="typeahead" data-items="4" name="dept01" value="<?= htmlspecialchars_decode(stripslashes($_SESSION['dept01']), ENT_QUOTES);?>" />

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


<!-- ************************************************************************-->
<!-- END MODAL WINDOW -->


<!-- END MODAL WINDOW -->
<!-- ************************************************************************-->


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


// global includes
include_once('includes/footer.php'); // authenticate users, includes db connection
?>


 <!-- PAGE-SPECIFIC SCRIPTS // addStory.php -->

<script type="text/javascript">


   $("#shameHideWriters").hide();
   $("#shameHideDepartments").hide();
   $("#shameHideSources").hide();
   $("#shameHideAffiliations").hide();




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

</script>


 <script>
// Allows users to type and will match selection according to available data
 // **07-27: switched the apostrophe and double quotes in echo '"' . $WName . '", '; so the apostrophes do not break the string
 var writer = <?php echo "[";
               foreach($writerName as $wName) {
                echo '"' . $wName . '",';
              }
              echo "];"; ?>


 var department = <?php echo "[";
               foreach($deptName as $dName) {
                echo '"' . $dName . '",';
              }
              echo "];"; ?>

 // **07-27: switched the apostrophe and double quotes in echo '"' . $sName . '", '; so the apostrophes do not break the string
 var source = <?php echo "[";
               foreach($sourceName as $sName) {
                echo '"' . $sName . '",';
              }
              echo "];"; ?>

 var affiliation = <?php echo "[";
               foreach($affiliationName as $aName) {
                echo '"' . $aName . '",';
              }
              echo "];"; ?>


//TODO: fix this shame

  $('#writer1').typeahead({source: writer});
  $('#writer2').typeahead({source: writer});
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
        preserveOnPaste: 'p,a[href],i,em,b,span[id,class]',
        deleteTag: 'delete',
        insertTag: 'insert',
      },
      height: '350'
    });


window.scrollTo(0, 0);
$('#headline').focus().blur()
</script>

<script>
  $("#tweet").keyup(function(){
    $("#count").text((140 - $(this).val().length) + " characters left");
  });
</script>

