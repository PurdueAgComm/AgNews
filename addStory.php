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


      $sql = "SELECT * FROM tblDept WHERE isHidden=0 ORDER BY strDeptName;";
      $result = mysql_query($sql);
      $i = 0;
      while($row = mysql_fetch_array($result)) {
        $deptID[$i] = $row["deptID"];
        $deptName[$i] = $row["strDeptName"];
        $i++;
      }
    ?>

      <h2>Create A New Story</h2>
          <form class="form-group"  name="addForm" id="addForm" method="post" enctype="multipart/form-data" action="functions/doAddStory.php">
            <?php
             if($_SESSION['storyError'] == 1) {
               echo "<div class='alert alert-danger'><i class='fa fa-exclamation-circle'></i> Looks like you forgot to enter a story. Please enter one before continuing.</div>";
             }

              //display general error with information
              if ($_GET["isComplete"] == "false") {
                echo "<div class='alert alert-danger'><h4>We need your attention! <span class='badge badge-important' style='position: relative; top: -2px;'>" . $_GET['count'] . " items</span></h4><p>" . $_SESSION['error'] . "</p></div>";
                $_SESSION["error"] = "";
              }
              if ($_SESSION["success"] != "") {
                echo "<div class='alert alert-success alert-block'><h4>Success!</h4><p>" . $_SESSION["success"] . "</p></div>";
                $_SESSION["success"] = "";
              }
              ?>

            <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">News Story</h3>
                  </div>
              <div class="panel-body form-horizontal">
                <textarea style="width: 98%; height: 200px;" id="tinymce" name="story"><?= htmlspecialchars_decode($_SESSION['story']);?></textarea>
              </div>
            </div> <!-- /.panel -->

            <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Internal Information</h3>
                  </div>
              <div class="panel-body form-horizontal">

                    <div class="form-group <?php if($_SESSION['filenameError'] == 1) echo 'error'; ?>">
                        <label class="col-sm-2 control-label" for="filename">Filename</label>
                         <div class="col-sm-4">
                             <input type="text" class="form-control" id="filename" placeholder="Create a filename" name="filename" value="<?= $_SESSION['filename'];?>" >
                         </div>
                             <span class="inline-help text-danger ">Required</span>

                     </div>

                      <div class="form-group  <?php if($_SESSION['writerError'] == 1) echo 'error'; ?>">
                          <label class="col-sm-2 control-label" style="margin-bottom:10px;" for="writer">Writer(s)</label>
                          <div class="col-sm-4" id="writers">
                            <!-- **07-27: htmlspecialchars(stripslashes) is good here to allow the browser to see the apostrophes AND escape the slashes. This is important for refresh or if there is an error on the page  -->
                                  <input type="text" class="form-control" id="writer1" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify a writer" name="writer1" value="<?php if(!empty($_SESSION["writerID1"])) { echo htmlspecialchars_decode(stripslashes($_SESSION["writerID1"]), ENT_QUOTES); } else { echo htmlspecialchars_decode(stripslashes($_SESSION["firstName"]), ENT_QUOTES) . ' ' . htmlspecialchars_decode(stripslashes($_SESSION["lastName"]), ENT_QUOTES);}?>" />
                          </div>

                            <span id="writerControls"><a onClick="addWriter();" rel="tooltip" title="Show more writer fields" class="btn btn-default">
                            <i class="fa fa-list"></i></a></span><br />

                          <div class="col-sm-4">
                            <div id="shameHideWriters" style="margin-top: 20px;">
                              <input type="text" class="form-control" id="writer2" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify a writer" name="writer2"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['writerID2']), ENT_QUOTES);?>" /><br />
                              <input type="text" class="form-control" id="writer3" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify a writer" name="writer3"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['writerID3']), ENT_QUOTES);?>" /><br />
                              <input type="text" class="form-control" id="writer4" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify a writer" name="writer4"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['writerID4']), ENT_QUOTES);?>" /><br />
                              <input type="text" class="form-control" id="writer5" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify a writer" name="writer5"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['writerID5']), ENT_QUOTES);?>" /><br />
                            </div>
                          </div>
                        </div>

                        <div class="form-group <?php if($_SESSION['intentError'] == 1) echo 'error'; ?> ">
                          <label class="col-sm-2 control-label" for="intent">Intent</label>
                          <div class="col-sm-4">
                            <textarea class="form-control" name="intent">
                              <?= $_SESSION['intent'];?> </textarea>
                          </div>
                        </div>



                          <div class="form-group <?php if($_SESSION['reachError'] == 1) echo 'error'; ?> ">
                            <label class="col-sm-2 control-label" for="reach">Reach</label>
                            <div class="col-sm-4 ">
                              <select name="reach" class="form-control">
                                <?php $reach = array("Select Reach", "Global", "National", "Midwest", "State");
                      foreach($reach as $value) {
                        if ($_SESSION['reach'] == $value)
                         {
                          echo "<option selected='selected' value='".$value."'>".$value."</option>";
                         }
                         else {
                          echo " <option value='".$value."'>".$value."</option> ";
                              }
                        }?>
                            </select>

                          </div>
                        </div>



                </div>
             </div>


           <input type="submit" name="story2" onClick="setConfirmUnload(false);" class="btn btn-default btn-lg btn-block" value="Create Story" />
           <br />



        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">General Information</h3>
          </div>
          <div class="panel-body form-horizontal">
              <div class="form-group <?php if($_SESSION['headlineError'] == 1) echo 'error'; ?>">
                <label class="col-sm-2 control-label" for="headline">Headline</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="headline" placeholder="Create a headline" name="headline" value="<?= $_SESSION['headline'];?>" > <?php if($_SESSION['headlineError'] == 1) echo "<i class='icon-exclamation-sign' rel='tooltip' title='You either left the headline blank or are using a headline that already exists.'></i>"; ?>
                </div>
              </div>


          <div class="form-group <?php if($_SESSION['tweetError'] == 1) echo 'error'; ?>">
            <label class="col-sm-2 control-label" for="tweet">Tweet</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="tweet" placeholder="Specify a custom tweet" name="tweet" value="<?= $_SESSION['tweet'];?>">
            </div>
              <span id="count" class="muted"></span>

          </div>

        <div class="form-group  <?php if($_SESSION['sourceError'] == 1) echo 'error'; ?>">
          <label class="col-sm-2 control-label" style="margin-bottom:10px;" for="source">Source(s)</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="source1" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off"  placeholder="Specify a source" name="source1"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['sourceID1']), ENT_QUOTES); ?>"  />
          </div>

            <span id="sourceControls"><a onClick="addSources();" rel="tooltip" title="Show more Source fields" class="btn btn-default">
            <i class="fa fa-list"></i></a></span> <a rel="tooltip" tabindex="-1" title="Create a new Source profile" data-toggle="modal" href="#myModal" role="button" class="btn btn-default">
            <i class="fa fa-plus-circle"></i></a> <br />
          <div class="col-sm-4">
            <div id="shameHideSources" style="margin-top: 20px;">
              <input type="text" class="form-control" id="source2" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify a source" name="source2"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['sourceID2']), ENT_QUOTES);?>" /><br />
              <input type="text" class="form-control" id="source3" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify a source" name="source3"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['sourceID3']), ENT_QUOTES);?>" /><br />
              <input type="text" class="form-control" id="source4" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify a source" name="source4"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['sourceID4']), ENT_QUOTES);?>" /><br />
              <input type="text" class="form-control" id="source5" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify a source" name="source5"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['sourceID5']), ENT_QUOTES);?>" /><br />
            </div>
          </div>
        </div>

        <div class="form-group  <?php if($_SESSION['departmentError'] == 1) echo 'error'; ?>">
          <label class="col-sm-2 control-label" style="margin-bottom:10px;" for="department">Department(s)</label>

          <div class="col-sm-4">
            <input type="text" class="form-control" id="department1" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify a department" name="department1"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['departmentID1']), ENT_QUOTES);?>" />
          </div>
             <span id="departmentControls"><a onClick="addDepartments();" rel="tooltip" title="Show more Department fields" class="btn btn-default"><i class="fa fa-list"></i></a></span><br/>

          <div class="col-sm-4">
            <div id="shameHideDepartments" style="margin-top: 20px;">
              <input type="text" class="form-control" id="department2" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify a department" name="department2"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['departmentID2']), ENT_QUOTES);?>" /><br />
              <input type="text" class="form-control" id="department3" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify a department" name="department3"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['departmentID3']), ENT_QUOTES);?>" /><br />
              <input type="text" class="form-control" id="department4" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify a department" name="department4"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['departmentID4']), ENT_QUOTES);?>" /><br />
              <input type="text" class="form-control" id="department5" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify a department" name="department5"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['departmentID5']), ENT_QUOTES);?>" /><br />
            </div>
          </div>
        </div>

         <div class="form-group  <?php if($_SESSION['affiliationError'] == 1) echo 'error'; ?>">
          <label class="col-sm-2 control-label" style="margin-bottom:10px;" for="affiliation">Affiliation(s)</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="affiliation1" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify an affiliation" name="affiliation1"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['affiliationID1']), ENT_QUOTES);?>" />
          </div>

             <span id="affiliationControls"><a onClick="addAffiliations();" rel="tooltip" title="Show more Affiliation fields" class="btn btn-default"><i class="fa fa-list"></i></a></span><br />

           <div class="col-sm-4">
            <div id="shameHideAffiliations" style="margin-top: 20px;">
              <input type="text" class="form-control" id="affiliation2" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify an affiliation" name="affiliation2"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['affiliationID2']), ENT_QUOTES);?>" /><br />
              <input type="text" class="form-control" id="affiliation3" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify an affiliation" name="affiliation3"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['affiliationID3']), ENT_QUOTES);?>" /><br />
              <input type="text" class="form-control" id="affiliation4" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify an affiliation" name="affiliation4"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['affiliationID4']), ENT_QUOTES);?>" /><br />
              <input type="text" class="form-control" id="affiliation5" class="typeahead" data-provide="typeahead" data-items="4" autocomplete="off" placeholder="Specify an affiliation" name="affiliation5"  value="<?= htmlspecialchars_decode(stripslashes($_SESSION['affiliationID5']), ENT_QUOTES);?>" /><br />
            </div>
          </div>
        </div>


        <div class="form-group <?php if($_SESSION['datePublishedError'] == 1) echo 'error'; ?>">
          <label class="col-sm-2 control-label" for="datePublished">Publish Date</label>
          <div class="col-sm-4">
            <div class="input-group date datePicker" id="dp3" data-date-format="yyyy-mm-dd">
               <?php
              if($_SESSION['datePublished'] == "") {
                $datePub = "";
              }
              else {
                $datePub = $_SESSION['datePublished'];
              }
             ?>

              <input class="form-control" name="datePublished" size="16" type="text" value="<?= $datePub;?>" readonly>
              <span class="input-group-addon add-on"><i class="fa fa-calendar"></i></span>
          </div>
        </div>
       </div>


          </div>
        </div>


 <!-- end well -->

 <!-- Start Metadata Checkboxes -->
      <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Define Metadata</h3>
                  </div>
              <div class="panel-body form-horizontal">

      <div class="form-group">
          <label class="col-sm-2 control-label metadata" for="isTopStory">This is an  <strong>Agriculture Top Story</strong></label>
          <div class="col-sm-4">
            <label class="checkbox-inline">
             <?php if($_SESSION["isTopStory"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isTopStory"> Yes
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isTopStory"> Yes
              <?php } ?>
            </label>
        </div>
      </div>

      <div class="form-group">
          <label class="col-sm-2 control-label metadata" for="isTopStory">This is an  <strong>Extension Top Story</strong></label>
          <div class="col-sm-4">
            <label class="checkbox-inline">
             <?php if($_SESSION["isExtTopStory"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isExtTopStory"> Yes
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isExtTopStory"> Yes
              <?php } ?>
            </label>
        </div>
      </div>


      <div class="form-group">
          <label class="col-sm-2 control-label metadata" for="isScience">This story is <strong>Science News</strong> </label>
          <div class="col-sm-4">
            <label class="checkbox-inline">
              <?php if($_SESSION["isScience"] == 1) { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" checked="checked" name="isScience"> Yes
              <?php } else { ?>
                <input type="checkbox" id="inlineCheckbox1" value="1" name="isScience"> Yes
              <?php } ?>
            </label>
        </div>
      </div>


        <div class="form-group <?php if($_SESSION['areaError'] == 1) echo 'error'; ?>">
          <label class="col-sm-2 control-label metadata" for="college">Story Type*</label>
          <div class="col-sm-4">
              <?php
              $sql = "SELECT * FROM tblArea;";
              $result = mysql_query($sql);
              $i = 0;

              while($row = mysql_fetch_array($result)) {

              if($_SESSION["area"][$i] != 0) {
                echo "<label class='checkbox-inline'>";
                echo "<input type='checkbox' id='" . $row["areaID"] . "' value='" . $row["areaID"] . "' name='area[" . $i . "]' checked='checked'> " . $row["strArea"];
                echo "</label><br/>";
              }
                else {
                  echo "<label class='checkbox-inline'>";
                  echo "<input type='checkbox' id='" . $row["areaID"] . "' value='" . $row["areaID"] . "' name='area[" . $i . "]'> " . $row["strArea"];
                  echo "</label><br/>";

                }

                $i++;

              }


            ?>
          </div>
        </div>

       <div class="form-group <?php if($_SESSION['topicError'] == 1) echo 'error'; ?>">
          <label class="col-sm-2 control-label metadata" for="college">Background Topic(s)</label>
          <div class="col-sm-4">
              <?php
              $sql = "SELECT * FROM tblTopic WHERE isHidden='0' ORDER BY strTopic;";
              $result = mysql_query($sql);
              $i = 0;

              while($row = mysql_fetch_array($result)) {

              if($_SESSION["topic"][$i] != 0) {
                echo "<label class='checkbox-inline'>";
                echo "<input type='checkbox' id='" . $row["topicID"] . "' value='" . $row["topicID"] . "' name='topic[" . $i . "]' checked='checked'> " . $row["strTopic"];
                echo "</label><br/>";
              }
                else {
                  echo "<label class='checkbox-inline'>";
                  echo "<input type='checkbox' id='" . $row["topicID"] . "' value='" . $row["topicID"] . "' name='topic[" . $i . "]'> " . $row["strTopic"];
                  echo "</label><br/>";

                }

                $i++;

              }


            ?>

          </div>

        </div>


       <div class="form-group <?php if($_SESSION['issueError'] == 1) echo 'error'; ?>">
          <label class="col-sm-2 control-label metadata" for="college">Critical Issue(s)</label>
          <div class="col-sm-4">
              <?php
              $sql = "SELECT * FROM tblIssues WHERE isHidden='0'ORDER BY strIssues;";
              $result = mysql_query($sql);
              $i = 0;

              while($row = mysql_fetch_array($result)) {

              if($_SESSION["issues"][$i] != 0) {
                echo "<label class='checkbox-inline'>";
                echo "<input type='checkbox' id='" . $row["issuesID"] . "' value='" . $row["issuesID"] . "' name='issues[" . $i . "]' checked='checked'> " . $row["strIssues"];
                echo "</label><br/>";
              }
                else {
                  echo "<label class='checkbox-inline'>";
                  echo "<input type='checkbox' id='" . $row["issuesID"] . "' value='" . $row["issuesID"] . "' name='issues[" . $i . "]'> " . $row["strIssues"];
                  echo "</label><br/>";
                }

                $i++;

              }
            ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label metadata" for="isConnections">Featured in:</label>
          <div class="col-sm-8">
            <label class="checkbox-inline">
            <?php if($_SESSION["isConnections"] == 1) { ?>
              <input type="checkbox" id="inlineCheckbox1" checked="checked" value="1" name="isConnections"> Connections
            <?php } else { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" name="isConnections"> Connections
            <?php } ?>
            </label>

            <label class="checkbox-inline">
            <?php if($_SESSION["isAgricultures"] == 1) { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" checked="checked" name="isAgricultures"> Agricultures
            <?php } else { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" name="isAgricultures"> Agricultures
            <?php } ?>
            </label>

            <label class="checkbox-inline">
            <?php if($_SESSION["isColumn"] == 1) { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" checked="checked" name="isColumn"> Columns
            <?php } else { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" name="isColumn"> Columns
            <?php } ?>
            </label>

            <label class="checkbox-inline">
            <?php if($_SESSION["isAnswers"] == 1) { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" checked="checked" name="isAnswers"> Ag Answers
            <?php } else { ?>
              <input type="checkbox" id="inlineCheckbox1" value="1" name="isAnswers"> Ag Answers
            <?php } ?>
            </label>

           </div>
        </div>
    </div>
  </div>
<!-- End MetaData Checkboxes --><!-- End MetaData Checkboxes --><!-- End MetaData Checkboxes --><!-- End MetaData Checkboxes -->


      <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Multimedia</h3>
              </div>
          <div class="panel-body form-horizontal">

              <div class="form-group">
                <label class="col-sm-2 control-label" for="youtube">Youtube Video URL</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="youtube" name="youtube" placeholder="http://www.youtube.com"  value="<?= $_SESSION['youtube'];?>"/></div>
              </div>

        <div class="form-group form-inline">
          <label class="col-sm-2 control-label" for="website1">Related Website</label>
          <div class="col-sm-10">
          Title: <input type="text" class="form-control" id="nameWebsite1" name="nameWebsite1" placeholder="Website Title"  value="<?= $_SESSION['websiteName1'];?>"/> Link: <input type="text" class="form-control" id="website1" name="website1" placeholder="http://www.thewebsite.com"  value="<?= $_SESSION['websiteURL1'];?>"/>
          <span id="websiteControls"><a onClick="addWebsites();" rel="tooltip" title="Show more Related Website fields" class="btn btn-default"><i class="fa fa-list"></i></a></span> <span>Start with <strong>http://</strong> </span><br />
          </div>
        </div>



      <div id="shameHideWebsites">

        <div class="form-group form-inline">
          <label class="col-sm-2 control-label" for="website2">Related Website</label>
          <div class="col-sm-10">
            Title: <input type="text" class="form-control" id="nameWebsite2" name="nameWebsite2" placeholder="Website Title"  value="<?= $_SESSION['websiteName2'];?>"/> Link: <input type="text" class="form-control" id="website2" name="website2" placeholder="http://www.thewebsite.com"  value="<?= $_SESSION['websiteURL2'];?>"/> <span class="muted inline-help"></span> <span>Start with <strong>http://</strong></span>
          </div>
        </div>

        <div class="form-group form-inline">
          <label class="col-sm-2 control-label" for="website3">Related Website</label>
          <div class="col-sm-10">
            Title: <input type="text" class="form-control" id="nameWebsite3" name="nameWebsite3" placeholder="Website Title"  value="<?= $_SESSION['websiteName3'];?>"/> Link: <input type="text" class="form-control" id="website3" name="website3" placeholder="http://www.thewebsite.com"  value="<?= $_SESSION['websiteURL3'];?>"/> <span class="muted inline-help">Start with <strong>http://</strong></span>
          </div>
        </div>


        <div class="form-group form-inline">
          <label class="col-sm-2 control-label" for="website4">Related Website</label>
          <div class="col-sm-10">
             Title: <input type="text" class="form-control" id="nameWebsite4" name="nameWebsite4" placeholder="Website Title"  value="<?= $_SESSION['websiteName4'];?>"/> Link: <input type="text" class="form-control" id="website4" name="website4" placeholder="http://www.thewebsite.com"  value="<?= $_SESSION['websiteURL4'];?>"/> <span class="muted inline-help">Start with <strong>http://</strong></span>
          </div>
        </div>


        <div class="form-group form-inline">
          <label class="col-sm-2 control-label" for="website5">Related Website</label>
          <div class="col-sm-10">
           Title: <input type="text" class="form-control" id="nameWebsite5" name="nameWebsite5" placeholder="Website Title"  value="<?= $_SESSION['websiteName5'];?>"/> Link: <input type="text" class="form-control" id="website5" name="website5" placeholder="http://www.thewebsite.com"  value="<?= $_SESSION['websiteURL5'];?>"/> <span class="muted inline-help">Start with <strong>http://</strong></span>
          </div>
        </div>
        </div>

        <div class="form-group form-inline">
          <label class="col-sm-2 control-label" for="college">Included Media</label>
          <div class="col-sm-7">
              <?php

              if($_SESSION["isPhoto"] != 0) {
                echo "<label class='checkbox-inline'>";
                echo "<input type='checkbox' value='1' name='isPhoto' checked='checked'> Photo";
                echo "</label>";
              }
                else {
                  echo "<label class='checkbox-inline'>";
                  echo "<input type='checkbox' value='1' name='isPhoto'> Photo";
                  echo "</label>";
              }

              if($_SESSION["isVideo"] != 0) {
                echo "<label class='checkbox-inline'>";
                echo "<input type='checkbox' value='1' name='isVideo' checked='checked'> Video";
                echo "</label>";
              }
                else {
                  echo "<label class='checkbox-inline'>";
                  echo "<input type='checkbox' value='1' name='isVideo'> Video";
                  echo "</label>";
              }

              if($_SESSION["isGraphic"] != 0) {
                echo "<label class='checkbox-inline'>";
                echo "<input type='checkbox' value='1' name='isGraphic' checked='checked'> Graphic";
                echo "</label>";
              }
                else {
                  echo "<label class='checkbox-inline'>";
                  echo "<input type='checkbox' value='1' name='isGraphic'> Graphic";
                  echo "</label>";
              }

              if($_SESSION["isAudio"] != 0) {
                echo "<label class='checkbox-inline'>";
                echo "<input type='checkbox' value='1' name='isAudio' checked='checked'> Audio";
                echo "</label>";
              }
                else {
                  echo "<label class='checkbox-inline'>";
                  echo "<input type='checkbox' value='1' name='isAudio'> Audio";
                  echo "</label>";
              }

            ?>
          </div>
        </div>

          </div>
      </div>

        <input type="submit" onClick="setConfirmUnload(false);"  name="story2" class="btn btn-default btn-lg btn-block btn-success" value="Create Story" />



<!-- ************************************************************************-->
<!-- BEGIN MODAL WINDOW -->


<!-- BEGIN MODAL WINDOW -->
<!-- ************************************************************************-->

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add a Source</h3>
  </div>

  <div class="modal-body form-horizontal">

      <div class="form-group<?php if($_SESSION['fname01Error'] == 1) echo 'error'; ?>">
               <label class="col-sm-2 control-label" for="fName01">First Name</label>
         <div class="col-sm-4">
               <input type="text" class="form-control" id="fName01" placeholder="John" name="fname01"  value="<?= $_SESSION['fname01'];?>" />

         </div>
      </div>

      <div class="form-group<?php if($_SESSION['lname01Error'] == 1) echo 'error'; ?>">
              <label class="col-sm-2 control-label" for="lName01">Last Name</label>
         <div class="col-sm-4">
               <input type="text" class="form-control" id="lName01" placeholder="Doe" name="lname01" value="<?= $_SESSION['lname01'];?>" />

         </div>
      </div>

      <div class="form-group<?php if($_SESSION['dept01Error'] == 1) echo 'error'; ?>">
              <label class="col-sm-2 control-label" for="dept01">Department</label>
         <div class="col-sm-4">
               <input type="text" class="form-control" id="dept01" placeholder="Food Sciences" class="typeahead" data-provide="typeahead" data-items="4" name="dept01" value="<?= $_SESSION['dept01'];?>" />

         </div>
       </div>

      <div class="form-group<?php if($_SESSION['email01Error'] == 1) echo 'error'; ?>">
              <label class="col-sm-2 control-label" for="email01">Email</label>
         <div class="col-sm-4">
               <input type="text" class="form-control" id="email01" placeholder="john@purdue.edu" name="email01" value="<?= $_SESSION['email01'];?>" />

         </div>
       </div>

      <div class="form-group<?php if($_SESSION['phone01Error'] == 1) echo 'error'; ?>">
              <label class="col-sm-2 control-label" for="phone01">Phone Number</label>
         <div class="col-sm-4">
               <input type="text" class="form-control" id="phone01" placeholder="XXX-XXX-XXXX" name="phone01" title="Phone Format" data-toggle="tooltip" data-placement ="right" value="<?= $_SESSION['phone01'];?>" />
                </div>
               <span class="help-block muted">Telephone Number Format: XXX-XXX-XXXX</span>

      </div>

  </div>



  <div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
    <input type="submit" onClick="setConfirmUnload(false);" name="source" class="btn btn-primary" id="save" value="Add Source" />


  </div>

  </div>
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
	$_SESSION['vwriterError'] = "";


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
  $("#writerControls").html("<a onClick='hideWriters()' class='btn btn-default'><i class='fa fa-eye-slash'></i></a>");
}

function hideWriters() {
  $("#shameHideWriters").hide();
  $("#writerControls").html("<a onClick='addWriter();'' class='btn btn-default'><i class='fa fa-list'></i></a>");
}

function addSources() {
  $("#shameHideSources").show();
  $("#sourceControls").html("<a onClick='hideSources()' class='btn btn-default'><i class='fa fa-eye-slash'></i></a>");
}

function hideSources() {
  $("#shameHideSources").hide();
  $("#sourceControls").html("<a onClick='addSources();'' class='btn btn-default'><i class='fa fa-list'></i></a>");
}

function addDepartments() {
  $("#shameHideDepartments").show();
  $("#departmentControls").html("<a onClick='hideDepartments()' class='btn btn-default'><i class='fa fa-eye-slash'></i></a>");
}

function hideDepartments() {
  $("#shameHideDepartments").hide();
  $("#departmentControls").html("<a onClick='addDepartments();'' class='btn btn-default'><i class='fa fa-list'></i></a>");
}

function addAffiliations() {
  $("#shameHideAffiliations").show();
  $("#affiliationControls").html("<a onClick='hideAffiliations()' class='btn btn-default'><i class='fa fa-eye-slash'></i></a>");
}

function hideAffiliations() {
  $("#shameHideAffiliations").hide();
  $("#affiliationControls").html("<a onClick='addAffiliations();'' class='btn btn-default'><i class='fa fa-list'></i></a>");
}

function addWebsites() {
  $("#shameHideWebsites").show();
  $("#websiteControls").html("<a onClick='hideWebsites()' class='btn btn-default'><i class='fa fa-eye-slash'></i></a>");
}

function hideWebsites() {
  $("#shameHideWebsites").hide();
  $("#websiteControls").html("<a onClick='addWebsites();'' class='btn btn-default'><i class='fa fa-list'></i></a>");
}



</script>


 <script>
// Allows users to type and will match selection according to available data

 // **07-27: switched the apostrophe and double quotes in echo '"' . $WName . '", '; so the apostrophes do not break the string
 var writer = <?php echo "[";
               foreach($writerName as $wName){
                echo '"' . $wName . '",';
              }
              echo "];"; ?>

 // **07-27: switched the apostrophe and double quotes in echo '"' . $WName . '", '; so the apostrophes do not break the string
 var writer1 = <?php echo "[";
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
        preserveOnPaste: 'p,a[href],i,em,b,span',
        deleteTag: 'delete',
        insertTag: 'insert'
      },
      height: '500'
    });
</script>

<script>
  $("#tweet").keyup(function(){
    $("#count").text((140 - $(this).val().length) + " characters left");
  });
</script>
