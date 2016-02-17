

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
// hack to display new features message for users who haven't logged in since last version
// ************************************************************************************************************************************
// ************************************************************************************************************************************
//    // CHANGE COOKIE NAME TO THE NAME OF THE CURRENT VERSION FOR IT TO SHOW UP AGAIN
// ************************************************************************************************************************************
// ************************************************************************************************************************************
if(!isset($_COOKIE['201'])) { ?>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Changelog - v2.0.1</h3>
      </div>
      <div class="panel-body">
          <p><label class="label label-success">Feature</label> <strong>Changelog Message</strong>: You'll receive a message outlining the latest changes to the AgNews Database the first time you login once an update has been released.</li></p>
          <p><label class="label label-success">Feature</label> <strong>Search</strong>: You can now search <code>Headlines</code> in addition to <code>Filenames</code>.</p>
          <p><label class="label label-warning">Bug Fix</label> <strong>Your News Stories</strong>: Fixed an issue where users couldn't edit or delete stories from their dashboard.</p>
      </div>
    </div>
<?
  // set a cookie to expire in a year
  setcookie("201", "true", time()+60*60*24*365);
}
//END DISPLAY OF CHANGELOG
?>

<!-- What's currently in development and hasn't launched -->
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Changelog - v2.1.0</h3>
      </div>
      <div class="panel-body">
          <p><label class="label label-success">Feature</label> <strong>Select to receive Extension Depot news in your email</strong>: For the administrators that need to receive the Extension Depot stories in their email (in order to add it manually to the Depot), they can now select to receive these updates in their user profile rather than coded in manually by MMU Web.</p>
          <p><label class="label label-success">Feature</label> <strong>Extension Depot Manager Role</strong>: A user can now be assigned to the role of Extension Depot Manager. This user will receive updates when any user creates a new writer in order to manage the available writers in the Extension Depot</p>
          <p><label class="label label-success">Feature</label> <strong>Custom Reports</strong>: If you're an administrator, you're now able to create reports that fit your needs. Visit the control panel to make your custom report.</p>
          <p><label class="label label-danger">Removed</label> <strong>Change Confirmation</strong>: Removed the change confirmation when navigating away from a page when a form input has been changed.</p>
      </div>
    </div>

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
        <a href="addStory.php" style="margin-left: 5px; margin-bottom:5px;" class="pull-right btn btn-default"><i class="fa fa-plus-circle"></i> Add Story</a>

        <form class="form-inline" action="searchResults.php" method="get">
          <div class="form-group pull-right">
            <input class="form-control" id="appendedInputButtons" type="text" name="q" placeholder="Search Stories">
            <button class="btn btn-default" type="submit"><i class='fa fa-search' onClick="setConfirmUnload(false);"></i></button>
          </div>
        </form>
      </div>

      <div class="panel panel-default"> <!-- for round corners -->
      <table class="table table-striped table-hover table-bordered">
      <tr>
        <td align="center" style="width: 3%"></td>
        <td style="width: 45%">Filename</td>
        <td style="width: 20%">Date Released</td>
        <td style="width: 20%">Status</td>
        <td style="width: 10%">Admin</td>
      </tr>

      <?php

      // display stories that require their attention first
      while($redRow = mysql_fetch_array($redResult)) {
        // check date
        echo "<tr class='danger'>";
        echo "<td align='center'><i rel='tooltip' title='This story is waiting on the writer(s).' class='fa fa-minus-circle'></i></td>";
        echo "<td><a href='beholdStory.php?newsID=" . $redRow['newsID'] . "'>" . htmlspecialchars(stripslashes($redRow['strFilename']), ENT_QUOTES) . "</a></td>";

        if($redRow["datePublished"] != "0000-00-00") {
          echo "<td>" .  date("F d, Y", strtotime($redRow["datePublished"])) . "</td>";
        }
        else {
          echo "<td>TBD</td>";
        }

        echo "<td>";
        $sql2 = "SELECT strStatus FROM tblStatus WHERE statusID=" . $redRow['statusID'];
        $result2 = mysql_query($sql2);
        $row2 = mysql_fetch_array($result2);
        if(!empty($row2["strStatus"])) {
          echo $row2["strStatus"];
        } else {
          echo "No status provided";
        }
        echo "</td>";
        echo "<td align='center'><a class='btn btn-default btn-sm' href='editStory.php?newsID=" . $redRow["newsID"] . "' rel='tooltip' title='Edit " . $redRow['strFilename'] . "'><i class='fa fa-edit'></i></a> ";
        echo "<a class='btn btn-default btn-sm' href='functions/doDeleteStory.php?newsID=" . $redRow["newsID"] . "' rel='tooltip' title='Remove " . $redRow['strFilename'] . "'><i class='fa fa-times'></i></a></td>";
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
        echo "<td align='center'><i rel='tooltip' title='Story is waiting on approval from the coordinator, a source, or M&M.' class='fa fa-minus-circle'></i></td>";
        echo "<td><a href='beholdStory.php?newsID=" . $yellowRow['newsID'] . "'>" . $yellowRow['strFilename'] . "</a></td>";

        if($yellowRow["datePublished"] != "0000-00-00") {
          echo "<td>" .  date("F d, Y", strtotime($yellowRow["datePublished"])) . "</td>";
        }
        else {
          echo "<td>TBD</td>";
        }

        echo "<td>";
        $sql2 = "SELECT strStatus FROM tblStatus WHERE statusID=" . $yellowRow['statusID'];
        $result2 = mysql_query($sql2);
        $row2 = mysql_fetch_array($result2);
        if(!empty($row2["strStatus"])) {
          echo $row2["strStatus"];
        } else {
          echo "No status provided";
        }
        echo "</td>";
        echo "<td align='center'><a class='btn btn-default btn-sm' href='editStory.php?newsID=" . $yellowRow["newsID"] . "' rel='tooltip' title='Edit " . $yellowRow['strFilename'] . "'><i class='fa fa-edit'></i></a> ";
        echo "<a class='btn btn-default btn-sm' href='functions/doDeleteStory.php?newsID=" . $yellowRow["newsID"] . "' rel='tooltip' title='Remove " . $yellowRow['strFilename'] . "'><i class='fa fa-times'></i></a></td>";
        echo "</tr>";
      }

      // finally, show their published stories
      while($normalRow = mysql_fetch_array($normalResult)) {
        if($limit < 5) {
        // check date
        $ts = strtotime($normalRow["datePublished"]);
        if ($ts === false || $ts == "1969-12-31")
          $datePublished = "TBD";
        else
          $datePublished = date("m/d/y", $ts);

        echo "<tr>";
        echo "<td align='center'><i rel='tooltip' title='This story has been published successfully.' class='fa fa-check-circle-o'></i></td>";
        echo "<td><a href='beholdStory.php?newsID=" . $normalRow['newsID'] . "'>" . $normalRow['strFilename'] . "</a></td>";

        if($normalRow["datePublished"] != "0000-00-00") {
          echo "<td>" .  date("F d, Y", strtotime($normalRow["datePublished"])) . "</td>";
        }
        else {
          echo "<td>TBD</td>";
        }

        echo "<td>";
        $sql2 = "SELECT strStatus FROM tblStatus WHERE statusID=" . $normalRow['statusID'];
        $result2 = mysql_query($sql2);
        $row2 = mysql_fetch_array($result2);
        if(!empty($row2["strStatus"])) {
          echo $row2["strStatus"];
        } else {
          echo "No status provided";
        }
        echo "</td>";
        echo "<td align='center'><a class='btn btn-default btn-sm' href='editStory.php?newsID=" . $normalRow["newsID"] . "' rel='tooltip' title='Edit " . $normalRow['strFilename'] . "'><i class='fa fa-edit'></i></a> ";
        echo "<a class='btn btn-default btn-sm' href='functions/doDeleteStory.php?newsID=" . $normalRow["newsID"] . "' rel='tooltip' title='Remove " . $normalRow['strFilename'] . "'><i class='fa fa-times'></i></a></td>";
        echo "</tr>";
        $limit++;
      } //end limit if
    } // end sql while
      if($limit > 4) {
        echo "<tr>";
        echo "<td colspan='5'>";
        echo "<a href='viewAllStories.php' class='btn btn-sm btn-block btn-link'><i class='fa fa-newspaper-o'></i> View All Stories</a>";
        echo "</td>";
        echo "</tr>";
      }
        echo "</table>";
        echo "</div>";
      } // end if (regarding if there are news stories)
      else {
        echo "<div class='alert alert-info'>You have no news stories. <a href='addStory.php'>Create one</a>.</div>";
      }
        ?>


    <?php
// global includes
include_once('includes/footer.php'); // authenticate users, includes db connection
?>
