

<?php
// global includes
include_once('includes/header.php'); // authenticate users, includes db connection


// all news stories
$sql = "SELECT * FROM tblNews INNER JOIN tblNewsWriterPeople ON tblNews.newsID = tblNewsWriterPeople.newsID WHERE tblNews.isHidden=0 AND tblNewsWriterPeople.peopleID ='" . $_SESSION["userID"] . "';";
$result = mysql_query($sql);
$num_results = mysql_num_rows($result);

$redSQL = "SELECT * FROM tblNews INNER JOIN tblNewsWriterPeople ON tblNews.newsID = tblNewsWriterPeople.newsID WHERE tblNews.isHidden=0 AND tblNews.statusID=1 AND tblNewsWriterPeople.peopleID ='" . $_SESSION["userID"] . "';";
$redResult = mysql_query($redSQL);

$yellowSQL = "SELECT * FROM tblNews INNER JOIN tblNewsWriterPeople ON tblNews.newsID = tblNewsWriterPeople.newsID WHERE tblNews.isHidden=0 AND tblNews.statusID=2 AND tblNewsWriterPeople.peopleID ='" . $_SESSION["userID"] . "';";
$yellowResult = mysql_query($yellowSQL);

$normalSQL = "SELECT * FROM tblNews INNER JOIN tblNewsWriterPeople ON tblNews.newsID = tblNewsWriterPeople.newsID WHERE tblNews.isHidden=0 AND tblNews.statusID=3 AND tblNewsWriterPeople.peopleID ='" . $_SESSION["userID"] . "' LIMIT 10;";
$normalResult = mysql_query($normalSQL);
$numNormal = mysql_num_rows($normalResult);


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


      <?php
/*
        $today = strtotime('now');
        $yesterday = strtotime('-1 day', $today);

        echo "<h3>Recent Activity<span rel='tooltip' title='Shows activity in the last 48 hours made by others.'><i class='fa fa-question-circle'></i></span></h3>";
        echo "<div class='row-fluid'>";


        $sql = "SELECT * FROM tblActivity INNER JOIN tblNews ON tblNews.newsID=tblActivity.newsID WHERE tblActivity.peopleID <> " . $_SESSION["userID"] . " ORDER BY tblActivity.dateTimeStamp DESC LIMIT 3";
        $result = mysql_query($sql);

        while($newsActivityEach = mysql_fetch_array($result)) {
          $activityDate = strtotime($newsActivityEach["dateTimeStamp"]) - $yesterday;
          // post only if the activity is within the last 48 hours
          if($activityDate <= 86400 && $activityDate > 0) {
            echo "<div class='span4 well'>";
            if(!empty($newsActivityEach["strHeadline"])) {
              echo "<p><strong><a href='beholdStory.php?newsID=" . $newsActivityEach["newsID"] . "'>" . $newsActivityEach["strHeadline"] . "</a></strong><br /><small class='muted' rel='tooltip' style='cursor:pointer' title='Activity made on " .  $newsActivityEach["dateTimeStamp"] . "'>" . $newsActivityEach["strFirstName"] . " " . $newsActivityEach["strLastName"] .  "</small>";
            }
            else {
              echo "<p><strong><a href='beholdStory.php?newsID=" . $newsActivityEach["newsID"] . "'>" . $newsActivityEach["strFilename"] . "</a></strong><br /><small class='muted' rel='tooltip' style='cursor:pointer' title='Activity made on " .  $newsActivityEach["dateTimeStamp"] . "'>" . $newsActivityEach["strFirstName"] . " " . $newsActivityEach["strLastName"] .  "</small>";
            }
            echo "<p>" . $newsActivityEach["strActivity"] . "</p>";
            echo "<p><a class='btn btn-block btn-small' <a href='beholdStory.php?newsID=" . $newsActivityEach["newsID"] . "'>View Story <i class='icon-arrow-right'></i></a></p>";
            echo "</div>";
            $activityCount++;
          }
        }

        if($activityCount == 0) {
            echo "<div class='alert alert-info'>You have no recent activity.</div>";

        }

        echo "</div>";




        $sql = "SELECT * FROM tblActivity INNER JOIN tblNews ON tblNews.newsID=tblActivity.newsID WHERE tblActivity.peopleID <> " . $_SESSION["userID"];
        $result = mysql_query($sql);
        $newsActivity = mysql_fetch_array($result);

        // $sql = "SELECT * FROM tblNewsWriterPeople WHERE newsID=" . $newsActivity["newsID"] . " AND peopleID=" . $_SESSION["userID"];
        // $result = mysql_query($sql);

        $today = strtotime('now');
        $yesterday = strtotime('-1 day', $today);



      if((mysql_num_rows($result) > 0))   {
         echo "<h3>Recent Activity<span rel='tooltip' title='Shows activity in the last 48 hours made by others.'><i class='icon-question-sign'></i></h3>";
         echo "<div class='row-fluid'>";


        $sql = "SELECT * FROM tblActivity INNER JOIN tblNews ON tblNews.newsID=tblActivity.newsID WHERE tblActivity.peopleID <> " . $_SESSION["userID"] . " ORDER BY tblActivity.dateTimeStamp DESC LIMIT 3";
        $result = mysql_query($sql);

        while($newsActivityEach = mysql_fetch_array($result)) {

          $activityDate = strtotime($newsActivityEach["dateTimeStamp"]) - $yesterday;

          // post only if the activity is within the last 48 hours
          if($activityDate <= 86400 && $activityDate > 0) {
            echo "<div class='span4 well'>";
            if(!empty($newsActivityEach["strHeadline"])) {
              echo "<p><strong><a href='beholdStory.php?newsID=" . $newsActivityEach["newsID"] . "'>" . $newsActivityEach["strHeadline"] . "</a></strong><br /><small class='muted' rel='tooltip' style='cursor:pointer' title='Activity made on " .  $newsActivityEach["dateTimeStamp"] . "'>" . $newsActivityEach["strFirstName"] . " " . $newsActivityEach["strLastName"] .  "</small>";
            }
            else {
              echo "<p><strong><a href='beholdStory.php?newsID=" . $newsActivityEach["newsID"] . "'>" . $newsActivityEach["strFilename"] . "</a></strong><br /><small class='muted' rel='tooltip' style='cursor:pointer' title='Activity made on " .  $newsActivityEach["dateTimeStamp"] . "'>" . $newsActivityEach["strFirstName"] . " " . $newsActivityEach["strLastName"] .  "</small>";
            }
            echo "<p>" . $newsActivityEach["strActivity"] . "</p>";
            echo "<p><a class='btn btn-block btn-small' <a href='beholdStory.php?newsID=" . $newsActivityEach["newsID"] . "'>View Story <i class='icon-arrow-right'></i></a></p>";
            echo "</div>";
            $activityCount++;
          }
        }

        echo "</div>";


      }
      else {
       echo "<div class='alert alert-info'>You have no recent activity.</div>";
      }

      */

      ?>



      <h3>Your News Stories</h3>


      <?php
      // if there are news stories, post them in table format
      if($num_results > 0) {

        if($numNormal > 11) {
          echo "<div class='alert alert-info'>Not all of your <strong>published</strong> stories are showing. <a href='viewAllStories.php'>View all stories</a></div>.";
        }
      ?>



      <p>This section is populated with stories that involve you. <a href="viewAllStories.php">View all stories</a>.</p>

       <div class="clearfix">
        <a href="addStory.php" style="margin-left: 5px; margin-bottom:5px;" class="pull-right btn btn-default">Add Story <i class="fa fa-plus-circle"></i></a>

        <div class="form-group pull-right">
          <form action="searchResults.php" method="get" style="margin-top:5px;">
            <input class="col-md-9" id="appendedInputButtons" type="text" name="q" placeholder="Search Stories">
            <button class=".btn .btn-default" type="submit"><i class='fa fa-search' onClick="setConfirmUnload(false);"></i></button>
          </form>
        </div>
        </div>

      <div class="panel panel-default"> <!-- for round corners -->
      <table class="table table-striped table-hover table-bordered">
      <tr>
        <td align="center" width="3%"></td>
        <td width="55%">Filename</td>
        <td width="20%">Date Released</td>
        <td width="20%">Status</td>
        <td width="5%">Admin</td>
      </tr>

      <?php

      // display stories that require their attention first
      while($redRow = mysql_fetch_array($redResult)) {
        // check date


        echo "<tr class='danger'>";
        echo "<td align='center' width='3%''><i rel='tooltip' title='This story is waiting on the writer(s).' class='fa fa-minus-circle'></i></td>";
        echo "<td width='55%'><a href='beholdStory.php?newsID=" . $redRow['newsID'] . "'>" . htmlspecialchars(stripslashes($redRow['strFilename']), ENT_QUOTES) . "</a></td>";

        if($redRow["datePublished"] != "0000-00-00") {
          echo "<td width='15%'>" .  date("F d, Y", strtotime($redRow["datePublished"])) . "</td>";
        }
        else {
          echo "<td width='15%'>TBD</td>";
        }

        echo "<td width='20%'>";
        $sql2 = "SELECT strStatus FROM tblStatus WHERE statusID=" . $redRow['statusID'];
        $result2 = mysql_query($sql2);
        $row2 = mysql_fetch_array($result2);
        if(!empty($row2["strStatus"])) {
          echo $row2["strStatus"];
        } else {
          echo "No status provided";
        }
        echo "</td>";
        echo "<td align='center' width='5%''><a href='editStory.php?newsID=" . $redRow["newsID"] . "'' rel='tooltip' title='Edit " . $redRow['strFilename'] . "'> <i class='fa fa-edit'> </i></a> <a href='functions/doDeleteStory.php?newsID=" . $redRow["newsID"] . "' rel='tooltip' title='Remove " . $redRow['strFilename'] . "'><i class='fa fa-remove'></i></a></td>";
        echo "</tr>";
      }


      // next, display stories that are not published and are waiting on the approval from others
      while($yellowRow = mysql_fetch_array($yellowResult)) {
        // check date
        $ts = strtotime($yellowRow["datePublished"]);
        if ($ts === false)
          $datePublished = "TBD";
        else
          $datePublished = date("m/d/y", $ts);


        echo "<tr class='warning'>";
        echo "<td align='center' width='3%''><i rel='tooltip' title='Story is waiting on approval from the coordinator, a source, or M&M.' class='fa fa-minus-circle'></i></td>";
        echo "<td width='55%'><a href='beholdStory.php?newsID=" . $yellowRow['newsID'] . "'>" . $yellowRow['strFilename'] . "</a></td>";

        if($yellowRow["datePublished"] != "0000-00-00") {
          echo "<td width='15%'>" .  date("F d, Y", strtotime($yellowRow["datePublished"])) . "</td>";
        }
        else {
          echo "<td width='15%'>TBD</td>";
        }

        echo "<td width='20%'>";
        $sql2 = "SELECT strStatus FROM tblStatus WHERE statusID=" . $yellowRow['statusID'];
        $result2 = mysql_query($sql2);
        $row2 = mysql_fetch_array($result2);
        if(!empty($row2["strStatus"])) {
          echo $row2["strStatus"];
        } else {
          echo "No status provided";
        }
        echo "</td>";
        echo "<td align='center' width='5%''><a href='editStory.php?newsID=" . $yellowRow["newsID"] . "' rel='tooltip' title='Edit " . $yellowRow['strFilename'] . "'><i class='fa fa-edit'></i></a> <a href='functions/doDeleteStory.php?newsID=" . $yellowRow["newsID"] . "' rel='tooltip' title='Remove " . $yellowRow['strFilename'] . "'><i class='fa fa-remove'></i></a></td>";
        echo "</tr>";
      }

      // finally, show their published stories
      // TODO: limit #
      while($normalRow = mysql_fetch_array($normalResult)) {
        // check date
        $ts = strtotime($normalRow["datePublished"]);
        if ($ts === false || $ts == "1969-12-31")
          $datePublished = "TBD";
        else
          $datePublished = date("m/d/y", $ts);

        echo "<tr>";
        echo "<td align='center' width='3%''><i rel='tooltip' title='This story has been published successfully.' class='fa fa-check-circle-o'></i></td>";
        echo "<td width='55%'><a href='beholdStory.php?newsID=" . $normalRow['newsID'] . "'>" . $normalRow['strFilename'] . "</a></td>";

        if($normalRow["datePublished"] != "0000-00-00") {
          echo "<td width='15%'>" .  date("F d, Y", strtotime($normalRow["datePublished"])) . "</td>";
        }
        else {
          echo "<td width='15%'>TBD</td>";
        }

        echo "<td width='20%'>";
        $sql2 = "SELECT strStatus FROM tblStatus WHERE statusID=" . $normalRow['statusID'];
        $result2 = mysql_query($sql2);
        $row2 = mysql_fetch_array($result2);
        if(!empty($row2["strStatus"])) {
          echo $row2["strStatus"];
        } else {
          echo "No status provided";
        }
        echo "</td>";
        echo "<td align='center' width='5%''><a href='editStory.php?newsID=" . $normalRow["newsID"] . "' rel='tooltip' title='Edit " . $normalRow['strFilename'] . "'><i class='fa fa-edit'></i></a> <a href='functions/doDeleteStory.php?newsID=" . $normalRow["newsID"] . "' rel='tooltip' title='Remove " . $normalRow['strFilename'] . "'><i class='fa fa-times'></i></a></td>";
        echo "</tr>";
      }





        echo "</table>";

        echo "</div>";
      } // end if (regarding if there are news stories)
      else {
        echo "<div class='alert alert-info'>You have no news stories. <a href='addStory.php'>Create one</a>.</div>";
      }
        ?>

    <a href="getNotified.php"><img style="border:1px solid #dedede; width:100%; " src="img/signupalerts.jpg" alt="sign up for alerts" /></a>

    <?php
// global includes
include_once('includes/footer.php'); // authenticate users, includes db connection
?>
