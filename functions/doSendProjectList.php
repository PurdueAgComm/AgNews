<?php
session_start();
// global includes
include_once('../includes/db.php'); // authenticate users, includes db connection




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


  // Grab the MM contact from the DB
  $sqlMM = "SELECT strEmail FROM tblPeople WHERE strRole='MM' LIMIT 1";
  $result = mysql_query($sqlMM);
  $mmContact = mysql_fetch_array($result);

  $to = $mmContact["strEmail"];

  if(!empty($news["strHeadline"])) {
    $subject = "[AgNews DB] '" . $news["strHeadline"] . "' is now published.";  
    $title = $news["strHeadline"];
  }
  else {
    $subject = "AgComm Work List | " . date("F d, Y");
    $title = $news["strFilename"];
  }

  $message .= "<html><body style='background-color: #fafafa;'>";
  $message .= "<table align='center' width='650' cellpadding='5' cellspacing='5' style='font-family: arial; border: 1px solid #a4a4a4; background-color: #FFF;'>";
  $message .= "<tr><td colspan='4' style='height: 80px; width: 610px; background-color:#FFF;'><img src='http://dev.www.purdue.edu/agnewsdb/img/emailupdate.jpg' alt='You have a new update from AgComm News' /></td></tr>";
  $message .= "<tr><td colspan='3' width='75%'>&nbsp;</td> <td colspan='1' width='25%' align='right'>" . date("M d, Y") . "</td></tr>";
  $message .= "<tr><td colspan='4' width='100%'><table width='100%' border='1' cellpadding='5' cellspacing='0' bordercolor='dfdfdf' style='font-family: arial; border: 1px solid #efefef;'>";

  $message .= "<tr  class='info'>";
  $message .= "<td style='text-align: center; background-color: #d9edf7;' colspan='5'><strong>State</strong></td>";
  $message .= "</tr>";
  $message .= "<tr>";
    $message .= "<th>Filename</th>";
    $message .= "<th>Source</th>";
    $message .= "<th>Writer</th>";
    $message .= "<th>Intent</th>";
    $message .= "<th>Publish Date</th>";
  $message .= "</tr>";

//  STATE
  if($stateNum > 0) {
          while($state = mysql_fetch_array($storyResultsState)) {
            $message .= "<tr>";
            $message .= "<td>" . $state["strFilename"];
			
			if($state["isVideo"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Video";
				}

			if($state["isPhoto"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Photo";
				}				
			if($state["isAudio"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Audio";
				}
			if($state["isGraphic"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Graphic";
				}
				
			$message .= "</td>";
            $message .= "<td>";

         

             $sqlSource = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . $state["newsID"];
            $resultSource = mysql_query($sqlSource);
            while($stateSource = mysql_fetch_array($resultSource)) {
              $message .= $stateSource["strFirstName"] . " " . $stateSource["strLastName"] . "<br />";
            }

            $message .= "</td>";
            $message .= "<td>";

            $sqlWriter = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $state["newsID"];
            $resultWriter = mysql_query($sqlWriter);
            while($stateWriter = mysql_fetch_array($resultWriter)) {
              $message .= $stateWriter["strFirstName"] . " " . $stateWriter["strLastName"] . "<br />";
            }
           
            $message .= "</td>";
            $message .= "<td>" . $state["txtIntent"] . "</td>";
            if($state["datePublished"] != "0000-00-00") {
              $message .=  "<td width='15%'>" .  date("F d", strtotime($state["datePublished"])) . "</td>";
            }
            else {
              $message .=  "<td width='15%'>TBD</td>";
            }
            $message .= "</tr>";

          } // end while
        } // end if
        else {
          $message .= "<td colspan='5' style='text-align: center;'><em>There are no stories with state reach.</em></td>";
        }


  $message .= "<tr  class='info'>";
  $message .= "<td style='text-align: center; background-color: #d9edf7;' colspan='5'><strong>Midwest</strong></td>";
  $message .= "</tr>";
  $message .= "<tr>";
    $message .= "<th>Filename</th>";
    $message .= "<th>Source</th>";
    $message .= "<th>Writer</th>";
    $message .= "<th>Intent</th>";
    $message .= "<th>Publish Date</th>";
  $message .= "</tr>";

// REGIONAL
        if($regionalNum > 0) {
          while($regional = mysql_fetch_array($storyResultsRegional)) {
            $message .= "<tr>";
            $message .= "<td>" . $regional["strFilename"];
			
			if($regional["isVideo"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Video";
				}

			if($regional["isPhoto"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Photo";
				}				
			if($regional["isAudio"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Audio";
				}
			if($regional["isGraphic"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Graphic";
				}
				
			$message .= "</td>";
            $message .= "<td>";

         

             $sqlSource = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . $regional["newsID"];
            $resultSource = mysql_query($sqlSource);
            while($regionalSource = mysql_fetch_array($resultSource)) {
              $message .= $regionalSource["strFirstName"] . " " . $regionalSource["strLastName"] . "<br />";
            }

            $message .= "</td>";
            $message .= "<td>";

            $sqlWriter = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $regional["newsID"];
            $resultWriter = mysql_query($sqlWriter);
            while($regionalWriter = mysql_fetch_array($resultWriter)) {
              $message .= $regionalWriter["strFirstName"] . " " . $regionalWriter["strLastName"] . "<br />";
            }
           
            $message .= "</td>";
            $message .= "<td>" . $regional["txtIntent"] . "</td>";
            if($regional["datePublished"] != "0000-00-00") {
              $message .=  "<td width='15%'>" .  date("F d", strtotime($regional["datePublished"])) . "</td>";
            }
            else {
              $message .=  "<td width='15%'>TBD</td>";
            }
            $message .= "</tr>";

          } // end while
        } // end if
        else {
          $message .= "<td colspan='5' style='text-align: center;'><em>There are no stories with regional reach.</em></td>";
        }


  $message .= "<tr  class='info'>";
  $message .= "<td style='text-align: center; background-color: #d9edf7;' colspan='5'><strong>National</strong></td>";
  $message .= "</tr>";
  $message .= "<tr>";
    $message .= "<th>Filename</th>";
    $message .= "<th>Source</th>";
    $message .= "<th>Writer</th>";
    $message .= "<th>Intent</th>";
    $message .= "<th>Publish Date</th>";
  $message .= "</tr>";

// NATIONAL
        if($nationalNum > 0) {
          while($national = mysql_fetch_array($storyResultsNational)) {
            $message .= "<tr>";
            $message .= "<td>" . $national["strFilename"];
			
			if($national["isVideo"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Video";
				}

			if($national["isPhoto"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Photo";
				}				
			if($national["isAudio"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Audio";
				}
			if($national["isGraphic"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Graphic";
				}
				
			$message .= "</td>";
            $message .= "<td>";

         

             $sqlSource = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . $national["newsID"];
            $resultSource = mysql_query($sqlSource);
            while($nationalSource = mysql_fetch_array($resultSource)) {
              $message .= $nationalSource["strFirstName"] . " " . $nationalSource["strLastName"] . "<br />";
            }

            $message .= "</td>";
            $message .= "<td>";

            $sqlWriter = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $national["newsID"];
            $resultWriter = mysql_query($sqlWriter);
            while($nationalWriter = mysql_fetch_array($resultWriter)) {
              $message .= $nationalWriter["strFirstName"] . " " . $nationalWriter["strLastName"] . "<br />";
            }
           
            $message .= "</td>";
            $message .= "<td>" . $national["txtIntent"] . "</td>";
            if($national["datePublished"] != "0000-00-00") {
              $message .=  "<td width='15%'>" .  date("F d", strtotime($national["datePublished"])) . "</td>";
            }
            else {
              $message .=  "<td width='15%'>TBD</td>";
            }
            $message .= "</tr>";

          } // end while
        } // end if
        else {
          $message .= "<td colspan='5' style='text-align: center;'><em>There are no stories with national reach.</em></td>";
        }

    $message .= "<tr  class='info'>";
    $message .= "<td style='text-align: center; background-color: #d9edf7;' colspan='5'><strong>Global</strong></td>";
    $message .= "</tr>";
    $message .= "<tr>";
    $message .= "<th>Filename</th>";
    $message .= "<th>Source</th>";
    $message .= "<th>Writer</th>";
    $message .= "<th>Intent</th>";
    $message .= "<th>Publish Date</th>";
    $message .= "</tr>";

// GLOBAL
        if($globalNum > 0) {
          while($global = mysql_fetch_array($storyResultsGlobal)) {
            $message .= "<tr>";
            $message .= "<td>" . $global["strFilename"];
			
			if($global["isVideo"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Video";
				}

			if($global["isPhoto"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Photo";
				}				
			if($global["isAudio"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Audio";
				}
			if($global["isGraphic"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Graphic";
				}
				
			$message .= "</td>";
            $message .= "<td>";

         

             $sqlSource = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . $global["newsID"];
            $resultSource = mysql_query($sqlSource);
            while($globalSource = mysql_fetch_array($resultSource)) {
              $message .= $globalSource["strFirstName"] . " " . $globalSource["strLastName"] . "<br />";
            }

            $message .= "</td>";
            $message .= "<td>";

            $sqlWriter = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $global["newsID"];
            $resultWriter = mysql_query($sqlWriter);
            while($globalWriter = mysql_fetch_array($resultWriter)) {
              $message .= $globalWriter["strFirstName"] . " " . $globalWriter["strLastName"] . "<br />";
            }
           
            $message .= "</td>";
            $message .= "<td>" . $global["txtIntent"] . "</td>";
            if($global["datePublished"] != "0000-00-00") {
              $message .=  "<td width='15%'>" .  date("F d", strtotime($global["datePublished"])) . "</td>";
            }
            else {
              $message .=  "<td width='15%'>TBD</td>";
            }
            $message .= "</tr>";

          } // end while
        } // end if
        else {
          $message .= "<td colspan='5' style='text-align: center;'><em>There are no stories with global reach.</em></td>";
        }

  $message .= "<tr  class='info'>";
  $message .= "<td style='text-align: center; background-color: #d9edf7;' colspan='5'><strong>Development</strong></td>";
  $message .= "</tr>";
  $message .= "<tr>";
    $message .= "<th>Filename</th>";
    $message .= "<th>Source</th>";
    $message .= "<th>Writer</th>";
    $message .= "<th>Intent</th>";
    $message .= "<th>Publish Date</th>";
  $message .= "</tr>";

// PENDING OR DEVELOPMENT
 if($pendingNum > 0) {
          while($pending = mysql_fetch_array($storyResultsPending)) {
            $message .= "<tr>";
            $message .= "<td>" . $pending["strFilename"];
			
			if($pending["isVideo"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Video";
				}

			if($pending["isPhoto"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Photo";
				}				
			if($pending["isAudio"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Audio";
				}
			if($pending["isGraphic"] == 1) {
				
				$message .="</br>" . "&nbsp;&nbsp;&nbsp;&nbsp;Graphic";
				}
				
			$message .= "</td>";
            $message .= "<td>";

         

            $sqlSource = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsSourcePeople ON tblNewsSourcePeople.peopleID = tblPeople.peopleID WHERE tblNewsSourcePeople.newsID=" . $pending["newsID"];
            $resultSource = mysql_query($sqlSource);
            while($pendingSource = mysql_fetch_array($resultSource)) {
              $message .= $pendingSource["strFirstName"] . " " . $pendingSource["strLastName"] . "<br />";
            }

            $message .= "</td>";
            $message .= "<td>";

            $sqlWriter = "SELECT tblPeople.strFirstName, tblPeople.strLastName, tblPeople.strPhone, tblPeople.strEmail FROM tblPeople INNER JOIN tblNewsWriterPeople ON tblNewsWriterPeople.peopleID = tblPeople.peopleID WHERE tblNewsWriterPeople.newsID=" . $pending["newsID"];
            $resultWriter = mysql_query($sqlWriter);
            while($pendingWriter = mysql_fetch_array($resultWriter)) {
              $message .= $pendingWriter["strFirstName"] . " " . $pendingWriter["strLastName"] . "<br />";
            }
           
            $message .= "</td>";
            $message .= "<td>" . $pending["txtIntent"] . "</td>";
            if($pending["datePublished"] != "0000-00-00") {
              $message .=  "<td width='15%'>" .  date("F d", strtotime($pending["datePublished"])) . "</td>";
            }
            else {
              $message .=  "<td width='15%'>TBD</td>";
            }
            $message .= "</tr>";

          } // end while
        } // end if
        else {
          $message .= "<td colspan='10' style='text-align: center;'><em>There are no stories in development.</em></td>";
        }

  $sqlCoord = "SELECT strEmail FROM tblPeople WHERE strRole='Coordinator';";
  $result = mysql_query($sqlCoord);
  $coord = mysql_fetch_array($result);

  $message .= "</table></td></tr>";
  $message .= "</table>";
  $message .= "</body></html>";
  $message = chunk_split(base64_encode($message));
  $headers = "From:noreplyagnews@purdue.edu\r\n";
  $headers .= "CC:" . $coord["strEmail"] . "\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  $headers .= "Content-Transfer-Encoding: base64\r\n\r\n";
  mail($to,$subject,$message,$headers);
  $_SESSION["success"] = "The Work List has successfully been sent to M&M.";
  header("Location: ../projectList.php");

?>