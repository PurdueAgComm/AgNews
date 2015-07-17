  <?php
include_once('includes/header.php'); // authenticate users, includes db connection
if($_SESSION["isAdmin"] != 1) {
	$_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
	header("Location: error.php");
}

$sql = "SELECT * FROM tblActivity INNER JOIN tblNews ON tblActivity.newsID = tblNews.newsID ORDER BY activityID DESC LIMIT 100;";
$result = mysql_query($sql);
$num_results = mysql_num_rows($result);

$sql = "SELECT * FROM tblActivity WHERE newsID IS NULL ORDER BY activityID DESC LIMIT 100";
$result3 = mysql_query($sql) OR die(mysql_error());
$num_results2 = mysql_num_rows($result3);
?>

<h1>News Activity Log</h1>
<p class="text-right"><a href="#other" class="btn btn-default btn-mini"><i class="fa fa-arrow-down"></i> Jump to other activity</a></p>


      <?php

        // if there are news stories, post them in table format
        if($num_results > 0) {
       ?>

       <table class="table table-striped table-hover table-bordered">
      	 <tr>
         <td width="20%">User</td>
         <td width="30%">Activity</td>
         <td width="30%">Story</td>
         <td width="20%">Time</td>
         </tr>

       <?php
 	     // display stories that require their attention first
	      while($activity = mysql_fetch_array($result)) {




		        echo "<tr><td>" . $activity["strFirstName"] . " " . $activity["strLastName"] . "</td>";
		        echo "<td>" . $activity["strActivity"] . "</td>";

            if(!empty($activity["strHeadline"])) {
		          echo "<td><a href='beholdStory.php?newsID=" . $activity["newsID"] . "''>" . $activity["strHeadline"] . "</a></td>";
            }
            else {
              echo "<td><a href='beholdStory.php?newsID=" . $activity["newsID"] . "''>" . htmlspecialchars(stripslashes($activity["strFilename"]), ENT_QUOTES) . "</a></td>";
            }

		        echo "<td>" . date("m.d.Y", strtotime($activity["dateTimeStamp"])) . " at " . date("h:i a", strtotime($activity["dateTimeStamp"])) .  "</td></tr>";


	      }
	      echo "</table>";
      } // end if (regarding if there are news stories)
      else {
        echo "<div class='alert alert-info'>There is no activity.</div>";
      }
      ?>
            <h3><a name="other"></a>Activity Not Related with News Stories</h3>

      <?php

         if($num_results2 > 0) {
       ?>



       <table class="table table-striped table-hover table-bordered">
         <tr>
         <td width="20%">User</td>
         <td width="30%">Activity</td>
         <td width="20%">Time</td>
         </tr>

       <?php

       // display stories that require their attention first
        while($activity = mysql_fetch_array($result3)) {


            echo "<tr><td>" . $activity["strFirstName"] . " " . $activity["strLastName"] . "</td>";
            echo "<td>" . $activity["strActivity"] . "</td>";
            echo "<td>" . date("m.d.Y", strtotime($activity["dateTimeStamp"])) . " at " . date("h:i a", strtotime($activity["dateTimeStamp"])) .  "</td></tr>";


        }
        echo "</table>";
      } // end if (regarding if there are news stories)
      else {
        echo "<div class='alert alert-info'>There is no activity.</div>";
      }



include_once('includes/footer.php'); // authenticate users, includes db connection
?>