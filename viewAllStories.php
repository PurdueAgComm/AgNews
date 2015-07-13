
<?php
// global includes
include_once('includes/header.php'); // authenticate users, includes db connection

$redSQL = "SELECT * FROM tblNews WHERE tblNews.isHidden=0 ORDER BY newsID DESC;";
$redResult = mysql_query($redSQL);
$num_results = mysql_num_rows($redResult);



?>
      <h3>All News Stories</h3>


      <?php
      // if there are news stories, post them in table format
      if($num_results > 0) {
      ?>



       <div class="clearfix">
         <a href="addStory.php" style="margin-left: 5px;" class="pull-right btn btn-default">Add Story <i class="fa fa-plus-circle"></i></a>

        <div class="form-group form-inline pull-right">
          <form action="searchResults.php" method="get">
            <input class="form-control" id="appendedInputButtons" type="text" name="q" placeholder="Search Stories">
            <button class="btn btn-default" type="submit"><i class='fa fa-search' onClick="setConfirmUnload(false);"></i></button>
          </form>
        </div>
        </div>

      <table class="table table-striped table-hover table-bordered">
      <tr>
        <td align="center" width="3%"></td>
        <td width="45%"><span rel='tooltip' style='cursor: pointer;' title='If headline is unavailable, it will show the filename.'>Headline</span></td>
        <td width="20%">Date Released</td>
        <td width="20%">Status</td>
        <td width="15%">Admin</td>
      </tr>

      <?php

      // display stories that require their attention first
      while($redRow = mysql_fetch_array($redResult)) {

	      if($redRow["statusID"] == 1) {


	        echo "<tr class='danger'>";
	        echo "<td align='center'><i rel='tooltip' title='This story is waiting on the writer(s).' class='fa fa-times-circle'></i></td>";

	        if(!empty($redRow["strHeadline"])) {
	        	echo "<td><a href='beholdStory.php?newsID=" . $redRow['newsID'] . "'>" . htmlspecialchars(stripslashes($redRow['strHeadline']), ENT_QUOTES) . "</a></td>";
	        }
	        else {
	        	echo "<td><a href='beholdStory.php?newsID=" . $redRow['newsID'] . "'>" . htmlspecialchars(stripslashes($redRow['strFilename']), ENT_QUOTES) . "</a></td>";
	        }


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
	        echo "<td align='center'><a class='btn btn-default btn-sm' href='editStory.php?newsID=" . $redRow["newsID"] . "'' rel='tooltip' title='Edit " . $redRow['strHeadline'] . "'><i class='fa fa-edit'></i></a> ";
            echo "<a class='btn btn-default btn-sm' href='functions/doDeleteStory.php?newsID=" . $redRow["newsID"] . "' rel='tooltip' title='Remove " . $redRow['strHeadline'] . "'><i class='fa fa-remove'></i></a></td>";
	        echo "</tr>";
	      }


		  if($redRow["statusID"] == 2) {
	      // next, display stories that are not published and are waiting on the approval from others


	        echo "<tr class='warning'>";
	        echo "<td align='center'><i rel='tooltip' title='Story is waiting on approval from the coordinator, a source, or M&M.' class='fa fa-minus-circle'></i></td>";

		   if(!empty($redRow["strHeadline"])) {
			 	echo "<td><a href='beholdStory.php?newsID=" . $redRow['newsID'] . "'>" . htmlspecialchars(stripslashes($redRow['strHeadline']), ENT_QUOTES) . "</a></td>";
	        }
	        else {
	        	echo "<td><a href='beholdStory.php?newsID=" . $redRow['newsID'] . "'>" . htmlspecialchars(stripslashes($redRow['strFilename']), ENT_QUOTES) . "</a></td>";
	        }

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
	        echo "<td align='center'><a class='btn btn-default btn-sm' href='editStory.php?newsID=" . $redRow["newsID"] . "'' rel='tooltip' title='Edit " . $redRow['strHeadline'] . "'><i class='fa fa-edit'></i></a> ";
            echo "<a class='btn btn-default btn-sm' href='functions/doDeleteStory.php?newsID=" . $redRow["newsID"] . "' rel='tooltip' title='Remove " . $redRow['strHeadline'] . "'><i class='fa fa-remove'></i></a></td>";
	        echo "</tr>";
	  }

	 	if($redRow["statusID"] == 3) {

	        echo "<tr>";
	        echo "<td align='center'><i rel='tooltip' title='This story has been published succesfully.' class='fa fa-check-circle-o'></i></td>";

		    if(!empty($redRow["strHeadline"])) {
			 	echo "<td><a href='beholdStory.php?newsID=" . $redRow['newsID'] . "'>" . htmlspecialchars(stripslashes($redRow['strHeadline']), ENT_QUOTES) . "</a></td>";
	        }
	        else {
	        	echo "<td><a href='beholdStory.php?newsID=" . $redRow['newsID'] . "'>" . htmlspecialchars(stripslashes($redRow['strFilename']), ENT_QUOTES) . "</a></td>";
	        }

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
	        echo "<td align='center'><a class='btn btn-default btn-sm' href='editStory.php?newsID=" . $redRow["newsID"] . "'' rel='tooltip' title='Edit " . $redRow['strHeadline'] . "'><i class='fa fa-edit'></i></a> ";
            echo "<a class='btn btn-default btn-sm' href='functions/doDeleteStory.php?newsID=" . $redRow["newsID"] . "' rel='tooltip' title='Remove " . $redRow['strHeadline'] . "'><i class='fa fa-remove'></i></a></td>";
	        echo "</tr>";
  		}
  	}





        echo "</table>";
      } // end if (regarding if there are news stories)
      else {
        echo "<div class='alert alert-info'>You have no news stories. <a href='addStory.php'>Create one</a>.</div>";
      }

include_once("includes/footer.php")

        ?>
