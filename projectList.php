<?php
// global includes
include_once('includes/header.php'); // authenticate users, includes db connection
if($_SESSION["isAdmin"] != 1) {
	$_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
	header("Location: error.php");
}



  $storySQL = "SELECT * FROM tblNews WHERE tblNews.isHidden=0 AND strReach='State'  AND txtIntent<>'' AND stageID <> 6  AND stageID <> 5  ORDER BY newsID DESC;";
  $storyResultsState = mysql_query($storySQL);
  $stateNum = mysql_num_rows($storyResultsState);

  $storySQL = "SELECT * FROM tblNews WHERE tblNews.isHidden=0 AND strReach='Midwest' AND txtIntent<>'' AND stageID <> 6 AND stageID <> 5 ORDER BY newsID DESC;";
  $storyResultsRegional = mysql_query($storySQL);
  $regionalNum = mysql_num_rows($storyResultsRegional);

  $storySQL = "SELECT * FROM tblNews WHERE tblNews.isHidden=0 AND strReach='National' AND txtIntent<>'' AND stageID <> 6 AND stageID <> 5  ORDER BY newsID DESC;";
  $storyResultsNational = mysql_query($storySQL);
  $nationalNum = mysql_num_rows($storyResultsNational);

  $storySQL = "SELECT * FROM tblNews WHERE tblNews.isHidden=0 AND strReach='Global' AND txtIntent<>'' AND stageID <> 6 AND stageID <> 5  ORDER BY newsID DESC;";
  $storyResultsGlobal = mysql_query($storySQL);
  $globalNum = mysql_num_rows($storyResultsGlobal);

  $storySQL = "SELECT * FROM tblNews WHERE tblNews.isHidden=0 AND strReach='' AND txtIntent<>'' AND stageID <> 6 AND stageID <> 5  ORDER BY newsID DESC;";
  $storyResultsPending = mysql_query($storySQL);
  $pendingNum = mysql_num_rows($storyResultsPending);

if(!empty($_SESSION["error"])) {
  // if there is an error, display it
  echo "<div class='alert alert-danger alert-block'><h4>Houston, we have a problem!</h4><p>" . $_SESSION["error"] . "</p></div>";
  $_SESSION["error"] = "";
}


  if ($_SESSION["success"] != "") {
          echo "<div class='alert alert-success alert-block'><h4>Success!</h4><p>" . $_SESSION["success"] . "</p></div>";
          $_SESSION["success"] = "";
}

?>


    <div class="clearfix">
    <a style="margin-bottom: 5px;" class="btn btn-primary pull-right" href="functions/doSendProjectList.php"><i class="fa fa-envelope icon-white"></i> Send to M&M</a>

    <a rel="tooltip" style='margin-right: 5px;' tabindex="-1" title="Update M&M Contact" data-toggle="modal" href="#myModal" role="button" class="btn btn-default pull-right"><i class="fa fa-edit"></i></a>

    </div>
    <table class="clearfix table table-striped table-hover table-bordered">
  		<tr>
  			<th style="text-align: center;" colspan="10">Ag Communication Project List - <?php echo date("F d, Y"); ?></th>
  		</tr>

      <!-- STATE STORIES -->
      <tr  class="info">
        <td style="text-align: center;" colspan="10"><strong>State</strong></td>
      </tr>
      <tr>
        <th>Filename</th>
        <th>Source</th>
        <th>Writer</th>
        <th>Intent</th>
        <th>Publish Date</th>
      </tr>

        <?php

        if($stateNum > 0) {
          while($state = mysql_fetch_array($storyResultsState)) {

            $isPhoto = "";
            $isVideo = "";
            $isGraphic = "";
            $isAudio = "";

            if($state["isPhoto"] == 1) {
              $isPhoto = "&nbsp;&nbsp;&nbsp;&nbsp;Photo<br/>";
            }
            if($state["isVideo"] == 1) {
              $isVideo = "&nbsp;&nbsp;&nbsp;&nbsp;Video<br/>";
            }
            if($state["isGraphic"] == 1) {
              $isGraphic = "&nbsp;&nbsp;&nbsp;&nbsp;Graphic<br/>";
            }
            if($state["isAudio"] == 1) {
              $isAudio = "&nbsp;&nbsp;&nbsp;&nbsp;Audio<br/>";
            }

            echo "<tr>";
            echo "<td><a href='beholdStory.php?newsID=" . $state["newsID"] . "'>" . htmlspecialchars(stripslashes($state["strFilename"]), ENT_QUOTES) . "</a>";
            echo "<br/>" . $isPhoto . $isVideo . $isGraphic . $isAudio;
            echo "</td>";
            echo "<td>";

            $sqlSource = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . $state["newsID"];
            $resultSource = mysql_query($sqlSource);
            while($stateSource = mysql_fetch_array($resultSource)) {
              echo $stateSource["strFirstName"] . " " . $stateSource["strLastName"] . "<br />";
            }

            echo "</td>";
            echo "<td>";

            $sqlWriter = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $state["newsID"];
            $resultWriter = mysql_query($sqlWriter);
            while($stateWriter = mysql_fetch_array($resultWriter)) {
              echo $stateWriter["strFirstName"] . " " . $stateWriter["strLastName"] . "<br />";
            }

            echo "</td>";
            echo "<td>" . $state["txtIntent"] . "</td>";
			if($state["datePublished"] != "0000-00-00") {
			  echo "<td width='15%'>" .  date("F d", strtotime($state["datePublished"])) . "</td>";
			}
			else {
			  echo "<td width='15%'>TBD</td>";
			}
            echo "</tr>";


          } // end while
        } // end if
        else {
          echo "<td colspan='10' style='text-align: center;'><em>There are no stories with state reach.</em></td>";
        }

      ?>




      <!-- REGIONAL STORIES -->
  		<tr  class="info">
  			<td style="text-align: center;" colspan="10"><strong>Midwest</strong></td>
  		</tr>
      <tr>
        <th>Filename</th>
        <th>Source</th>
        <th>Writer</th>
        <th>Intent</th>
        <th>Publish Date</th>
      </tr>

      <?php

        if($regionalNum > 0) {
          while($regional = mysql_fetch_array($storyResultsRegional)) {

            $isPhoto = "";
            $isVideo = "";
            $isGraphic = "";
            $isAudio = "";

            if($regional["isPhoto"] == 1) {
              $isPhoto = "&nbsp;&nbsp;&nbsp;&nbsp;Photo<br/>";
            }
            if($regional["isVideo"] == 1) {
              $isVideo = "&nbsp;&nbsp;&nbsp;&nbsp;Video<br/>";
            }
            if($regional["isGraphic"] == 1) {
              $isGraphic = "&nbsp;&nbsp;&nbsp;&nbsp;Graphic<br/>";
            }
            if($regional["isAudio"] == 1) {
              $isAudio = "&nbsp;&nbsp;&nbsp;&nbsp;Audio<br/>";
            }


            echo "<tr>";
            echo "<td><a href='beholdStory.php?newsID=" . $regional["newsID"] . "'>" . htmlspecialchars(stripslashes($regional["strFilename"]), ENT_QUOTES) . "</a>";
            echo "<br/>" . $isPhoto . $isVideo . $isGraphic . $isAudio;
            echo "</td>";
            echo "<td>";

             $sqlSource = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . $regional["newsID"];
            $resultSource = mysql_query($sqlSource);
            while($regionalSource = mysql_fetch_array($resultSource)) {
              echo $regionalSource["strFirstName"] . " " . $regionalSource["strLastName"] . "<br />";
            }

            echo "</td>";
            echo "<td>";

            $sqlWriter = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $regional["newsID"];
            $resultWriter = mysql_query($sqlWriter);
            while($regionalWriter = mysql_fetch_array($resultWriter)) {
              echo $regionalWriter["strFirstName"] . " " . $regionalWriter["strLastName"] . "<br />";
            }

            echo "</td>";
            echo "<td>" . $regional["txtIntent"] . "</td>";
            if($regional["datePublished"] != "0000-00-00") {
			  echo "<td width='15%'>" .  date("F d", strtotime($regional["datePublished"])) . "</td>";
			}
			else {
			  echo "<td width='15%'>TBD</td>";
			}
            echo "</tr>";

          } // end while
        } // end if
        else {
          echo "<td colspan='10' style='text-align: center;'><em>There are no stories with regional reach.</em></td>";
        }

      ?>


      <!-- NATIONAL STORIES -->
      <tr  class="info">
        <td style="text-align: center;" colspan="10"><strong>National</strong></td>
      </tr>
      <tr>
        <th>Filename</th>
        <th>Source</th>
        <th>Writer</th>
        <th>Intent</th>
        <th>Publish Date</th>
      </tr>

      <?php

        if($nationalNum > 0) {
          while($national = mysql_fetch_array($storyResultsNational)) {

            $isPhoto = "";
            $isVideo = "";
            $isGraphic = "";
            $isAudio = "";

            if($national["isPhoto"] == 1) {
              $isPhoto = "&nbsp;&nbsp;&nbsp;&nbsp;Photo<br/>";
            }
            if($national["isVideo"] == 1) {
              $isVideo = "&nbsp;&nbsp;&nbsp;&nbsp;Video<br/>";
            }
            if($national["isGraphic"] == 1) {
              $isGraphic = "&nbsp;&nbsp;&nbsp;&nbsp;Graphic<br/>";
            }
            if($national["isAudio"] == 1) {
              $isAudio = "&nbsp;&nbsp;&nbsp;&nbsp;Audio<br/>";
            }


            echo "<tr>";
            echo "<td><a href='beholdStory.php?newsID=" . $national["newsID"] . "'>" . htmlspecialchars(stripslashes($national["strFilename"]), ENT_QUOTES) . "</a>";
            echo "<br/>" . $isPhoto . $isVideo . $isGraphic . $isAudio;
            echo "</td>";
            echo "<td>";

            $sqlSource = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . $national["newsID"];
            $resultSource = mysql_query($sqlSource);
            while($nationalSource = mysql_fetch_array($resultSource)) {
              echo $nationalSource["strFirstName"] . " " . $nationalSource["strLastName"] . "<br />";
            }

            echo "</td>";
            echo "<td>";

            $sqlWriter = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $national["newsID"];
            $resultWriter = mysql_query($sqlWriter);
            while($nationalWriter = mysql_fetch_array($resultWriter)) {
              echo $nationalWriter["strFirstName"] . " " . $nationalWriter["strLastName"] . "<br />";
            }

            echo "</td>";
            echo "<td>" . $national["txtIntent"] . "</td>";
            if($national["datePublished"] != "0000-00-00") {
      			  echo "<td width='15%'>" .  date("F d", strtotime($national["datePublished"])) . "</td>";
      			}
      			else {
      			  echo "<td width='15%'>TBD</td>";
      			}
            echo "</tr>";

          } // end while
        } // end if
        else {
          echo "<td colspan='10' style='text-align: center;'><em>There are no stories with national or international reach.</em></td>";
        }

         ?>


      <!-- NATIONAL STORIES -->
      <tr  class="info">
        <td style="text-align: center;" colspan="10"><strong>Global</strong></td>
      </tr>
      <tr>
        <th>Filename</th>
        <th>Source</th>
        <th>Writer</th>
        <th>Intent</th>
        <th>Publish Date</th>
      </tr>

      <?php

        if($globalNum > 0) {
          while($global = mysql_fetch_array($storyResultsGlobal)) {

            $isPhoto = "";
            $isVideo = "";
            $isGraphic = "";
            $isAudio = "";

            if($global["isPhoto"] == 1) {
              $isPhoto = "&nbsp;&nbsp;&nbsp;&nbsp;Photo<br/>";
            }
            if($global["isVideo"] == 1) {
              $isVideo = "&nbsp;&nbsp;&nbsp;&nbsp;Video<br/>";
            }
            if($global["isGraphic"] == 1) {
              $isGraphic = "&nbsp;&nbsp;&nbsp;&nbsp;Graphic<br/>";
            }
            if($global["isAudio"] == 1) {
              $isAudio = "&nbsp;&nbsp;&nbsp;&nbsp;Audio<br/>";
            }


            echo "<tr>";
            echo "<td><a href='beholdStory.php?newsID=" . $global["newsID"] . "'>" . htmlspecialchars(stripslashes($global["strFilename"]), ENT_QUOTES) . "</a>";
            echo "<br/>" . $isPhoto . $isVideo . $isGraphic . $isAudio;
            echo "</td>";
            echo "<td>";

             $sqlSource = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . $global["newsID"];
            $resultSource = mysql_query($sqlSource);
            while($globalSource = mysql_fetch_array($resultSource)) {
              echo $globalSource["strFirstName"] . " " . $globalSource["strLastName"] . "<br />";
            }

            echo "</td>";
            echo "<td>";

            $sqlWriter = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $global["newsID"];
            $resultWriter = mysql_query($sqlWriter);
            while($globalWriter = mysql_fetch_array($resultWriter)) {
              echo $globalWriter["strFirstName"] . " " . $globalWriter["strLastName"] . "<br />";
            }

            echo "</td>";
            echo "<td>" . $global["txtIntent"] . "</td>";
            if($global["datePublished"] != "0000-00-00") {
			  echo "<td width='15%'>" .  date("F d", strtotime($global["datePublished"])) . "</td>";
			}
			else {
			  echo "<td width='15%'>TBD</td>";
			}
            echo "</tr>";

          } // end while
        } // end if
        else {
          echo "<td colspan='10' style='text-align: center;'><em>There are no stories with global reach.</em></td>";
        }



      ?>

      <!-- NATIONAL STORIES -->
      <tr  class="info">
        <td style="text-align: center;" colspan="10"><strong>Development</strong></td>
      </tr>
      <tr>
        <th>Filename</th>
        <th>Source</th>
        <th>Writer</th>
        <th>Intent</th>
        <th>Publish Date</th>
      </tr>

      <?php

        if($pendingNum > 0) {
          while($pending = mysql_fetch_array($storyResultsPending)) {

            $isPhoto = "";
            $isVideo = "";
            $isGraphic = "";
            $isAudio = "";

            if($pending["isPhoto"] == 1) {
              $isPhoto = "&nbsp;&nbsp;&nbsp;&nbsp;Photo<br/>";
            }
            if($pending["isVideo"] == 1) {
              $isVideo = "&nbsp;&nbsp;&nbsp;&nbsp;Video<br/>";
            }
            if($pending["isGraphic"] == 1) {
              $isGraphic = "&nbsp;&nbsp;&nbsp;&nbsp;Graphic<br/>";
            }
            if($pending["isAudio"] == 1) {
              $isAudio = "&nbsp;&nbsp;&nbsp;&nbsp;Audio<br/>";
            }


            echo "<tr>";
            echo "<td><a href='beholdStory.php?newsID=" . $pending["newsID"] . "'>" . htmlspecialchars(stripslashes($pending["strFilename"]), ENT_QUOTES) . "</a>";
            echo "<br/>" . $isPhoto . $isVideo . $isGraphic . $isAudio;
            echo "</td>";
            echo "<td>";

            $sqlSource = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . $pending["newsID"];
            $resultSource = mysql_query($sqlSource);
            while($pendingSource = mysql_fetch_array($resultSource)) {
              echo $pendingSource["strFirstName"] . " " . $pendingSource["strLastName"] . "<br />";
            }

            echo "</td>";
            echo "<td>";

            $sqlWriter = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $pending["newsID"];
            $resultWriter = mysql_query($sqlWriter);
            while($pendingWriter = mysql_fetch_array($resultWriter)) {
              echo $pendingWriter["strFirstName"] . " " . $pendingWriter["strLastName"] . "<br />";
            }

            echo "</td>";
            echo "<td>" . $pending["txtIntent"] . "</td>";
            if($pending["datePublished"] != "0000-00-00") {
			  echo "<td width='15%'>" .  date("F d", strtotime($pending["datePublished"])) . "</td>";
			}
			else {
			  echo "<td width='15%'>TBD</td>";
			}
            echo "</tr>";

          } // end while
        } // end if
        else {
          echo "<td colspan='10' style='text-align: center;'><em>There are no stories in development.</em></td>";
        }

      ?>




    </table>
    <div class="clearfix">
    <a style="margin-top: -15px;" class="btn btn-primary pull-right" href="functions/doSendProjectList.php"><i class="fa fa-envelope icon-white"></i> Send to M&M</a>
    </div>



<!-- Modal -->

<?

$SQL = "SELECT strEmail FROM tblPeople WHERE strRole='MM';";
$result = mysql_query($SQL);
$contact = mysql_fetch_array($result);
?>
<form class="" method="post" action="functions/doUpdateMMContact.php">
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg">
 <div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Update M&M Contact</h3>
  </div>
  <div class="modal-body">
    <p>This form controls the email address that the Project List will be mailed to. The current email address appears below. If you would like to change the email address, simply replace the email address below with the new address and click the Update Contact button below.</p>
      <div style="height:50px;"  class="control-group  <?php if($_SESSION['emailError'] == 1) echo 'error'; ?>">
               <label class="col-sm-2 control-label" for="email">Contact Email:</label>
         <div class="controls">
         <div class="input-append col-sm-4">
               <input type="text" class="form-control" id="email" placeholder="Email Address" name="email"  value="<?php echo $contact['strEmail']; ?>" />
         </div>
       </div>
      </div>
  </div>

  <div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
    <input type="submit" name="source" class="btn btn-primary" id="save" value="Update Contact" />
  </div>
 </form>

</div>
</div>
</div> <!--end of modal content-->


<!-- END MODAL WINDOW -->






<?php
include_once("includes/footer.php");
?>