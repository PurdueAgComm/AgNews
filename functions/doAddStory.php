<?php
session_start();

// global includes
include_once('../includes/db.php'); // includes db connection
// Function page for addStory.php
// creates new story/validates
// #############################################################
// Grab information from last page and save
// #############################################################
$_SESSION["filename"] = mysql_real_escape_string($_POST["filename"]);
$_SESSION["intent"] = mysql_real_escape_string($_POST["intent"]);
$_SESSION["reach"] = mysql_real_escape_string($_POST["reach"]);
$_SESSION["headline"] = mysql_real_escape_string(str_replace('"', "''", $_POST["headline"]));
$_SESSION["tweet"] = mysql_real_escape_string($_POST["tweet"]);

if(!empty($_POST["datePublished"])) {
	$_SESSION["datePublished"] = mysql_real_escape_string(date('Y-m-d', strtotime($_POST["datePublished"])));
}
else {
	$_SESSION["datePublished"] = '';
}

$_SESSION["peopleID"] = mysql_real_escape_string($_POST["peopleID"]);

$_SESSION["strFirstName"] = mysql_real_escape_string($_POST["strfirstName"]);
$_SESSION["strLastName"] = mysql_real_escape_string($_POST["strlastName"]);

$_SESSION["writer1"] = mysql_real_escape_string($_POST["writer1"]);

$_SESSION["source1"] = mysql_real_escape_string($_POST["source1"]);
$_SESSION["department1"] = mysql_real_escape_string($_POST["department1"]);
$_SESSION["affiliation1"] = mysql_real_escape_string($_POST["affiliation1"]);
$_SESSION["college"] = mysql_real_escape_string($_POST["college"]);
$_SESSION["area"] = mysql_real_escape_string($_POST["area"]);
$_SESSION["topic"] = mysql_real_escape_string($_POST["topic"]);
$_SESSION["issue"] = mysql_real_escape_string($_POST["issue"]);
$_SESSION["photo"] = mysql_real_escape_string($_POST["image"]);
$_SESSION["youtube"] = mysql_real_escape_string($_POST["youtube"]);

$_SESSION["websiteName1"] = mysql_real_escape_string($_POST["nameWebsite1"]);
$_SESSION["websiteName2"] = mysql_real_escape_string($_POST["nameWebsite2"]);
$_SESSION["websiteName3"] = mysql_real_escape_string($_POST["nameWebsite3"]);
$_SESSION["websiteName4"] = mysql_real_escape_string($_POST["nameWebsite4"]);
$_SESSION["websiteName5"] = mysql_real_escape_string($_POST["nameWebsite5"]);

$_SESSION["websiteURL1"] = mysql_real_escape_string($_POST["website1"]);
$_SESSION["websiteURL2"] = mysql_real_escape_string($_POST["website2"]);
$_SESSION["websiteURL3"] = mysql_real_escape_string($_POST["website3"]);
$_SESSION["websiteURL4"] = mysql_real_escape_string($_POST["website4"]);
$_SESSION["websiteURL5"] = mysql_real_escape_string($_POST["website5"]);

// save  in session in case they error out
for($i=1; $i<6; $i++) {
	$_SESSION["writerID" . $i] = mysql_real_escape_string($_POST["writer" . $i]);
	$_SESSION["sourceID" . $i] = mysql_real_escape_string($_POST["source" . $i]);
	$_SESSION["affiliationID" . $i] = mysql_real_escape_string($_POST["affiliation" . $i]);
	$_SESSION["departmentID" . $i] = mysql_real_escape_string($_POST["department" . $i]);
}

$_SESSION["area"] = $_POST["area"];
$_SESSION["fund"] = $_POST["fund"];
$_SESSION["topic"] = $_POST["topic"];
$_SESSION["issues"] = $_POST["issues"];
$_SESSION["college"] = $_POST["college"];

$_SESSION["story"] = htmlspecialchars($_POST["story"]);

if(strlen($_SESSION["story"]) >= 63000) {
	$_SESSION["error"] = "This story contains to many characters to save to the database. To solve this, you can accept/reject any changes that are pending.";
	header("Location: ../addStory.php?isComplete=false&count=1");
}

// Start off with fresh error variables for resubmit
$_SESSION["filenameError"] = 0;
$_SESSION["headlineError"] = 0;
$_SESSION["tweetError"] = 0;
$_SESSION["writerError"] = 0;
$_SESSION["sourceError"] = 0;
$_SESSION["departmentError"] = 0;
$_SESSION["collegeError"] = 0;
$_SESSION["areaError"] = 0;
$_SESSION["fundError"] = 0;
$_SESSION["topicError"] = 0;
$_SESSION["issueError"] = 0;
$_SESSION["storyError"] = 0;
$_SESSION["affiliationError"] = 0;

// #############################################################
// Cleans for db input
// #############################################################

// isScience?
if(!empty($_POST["isScience"])) {
	$_SESSION["isScience"] = mysql_real_escape_string($_POST["isScience"]);
}
else {
	$_SESSION["isScience"] = 0;
}

// isColumn?
if(!empty($_POST["isColumn"])) {
	$_SESSION["isColumn"] = mysql_real_escape_string($_POST["isColumn"]);
}
else {
	$_SESSION["isColumn"] = 0;
}

// isTopStory?
if(!empty($_POST["isTopStory"])) {
	$_SESSION["isTopStory"] = (int) mysql_real_escape_string($_POST["isTopStory"]);
}
else {
	$_SESSION["isTopStory"] = 0;
}

// isExtTopStory?
if(!empty($_POST["isExtTopStory"])) {
	$_SESSION["isExtTopStory"] = (int) mysql_real_escape_string($_POST["isExtTopStory"]);
}
else {
	$_SESSION["isExtTopStory"] = 0;
}

// isConnections?
if(!empty($_POST["isConnections"])) {
	$_SESSION["isConnections"] = mysql_real_escape_string($_POST["isConnections"]);
}
else {
	$_SESSION["isConnections"] = 0;
}

// isAgricultures?
if(!empty($_POST["isAgricultures"])) {
	$_SESSION["isAgricultures"] = mysql_real_escape_string($_POST["isAgricultures"]);
}
else {
	$_SESSION["isAgricultures"] = 0;
}

// isAnswers?
if(!empty($_POST["isAnswers"])) {
	$_SESSION["isAnswers"] = mysql_real_escape_string($_POST["isAnswers"]);
}
else {
	$_SESSION["isAnswers"] = 0;
}

// isPhoto?
if(!empty($_POST["isPhoto"])) {
	$_SESSION["isPhoto"] = mysql_real_escape_string($_POST["isPhoto"]);
}
else {
	$_SESSION["isPhoto"] = 0;
}

// isVideo?
if(!empty($_POST["isVideo"])) {
	$_SESSION["isVideo"] = mysql_real_escape_string($_POST["isVideo"]);
}
else {
	$_SESSION["isVideo"] = 0;
}

// isAudio?
if(!empty($_POST["isAudio"])) {
	$_SESSION["isAudio"] = mysql_real_escape_string($_POST["isAudio"]);
}
else {
	$_SESSION["isAudio"] = 0;
}

// isGraphic?
if(!empty($_POST["isGraphic"])) {
	$_SESSION["isGraphic"] = mysql_real_escape_string($_POST["isGraphic"]);
}
else {
	$_SESSION["isGraphic"] = 0;
}


// reach select
if($_SESSION["reach"] == "Select Reach") {
	$_SESSION["reach"] = "";
}


/// working in the SOURCE modal, adding a source ///

if(isset($_POST["source"])) {
	// grab varibles from other page
    // **07-27: This escapes the apostrophe with a \. The \ does not go in the database but must be removed in the "success" message. http://nyphp.org/PHundamentals/5_Storing-Data-Submitted-Form-Displaying-Database
	$_SESSION["fname01"] = mysql_real_escape_string($_POST["fname01"]);
	$_SESSION["lname01"] = mysql_real_escape_string($_POST["lname01"]);
	$_SESSION["email01"] = mysql_escape_string($_POST["email01"]);
	$_SESSION["phone01"] = mysql_escape_string($_POST["phone01"]);
	$_SESSION["dept01"]  = mysql_escape_string($_POST["dept01"]);

	$_SESSION["fname01Error"] = 0;
	$_SESSION["lname01Error"] = 0;
	$_SESSION["email01Error"] = 0;
	$_SESSION["phone01Error"] = 0;
	$_SESSION["dept01Error"] = 0;
	$_SESSION["errorCounter"] = 0;
	$_SESSION["errorSameSource"] = 0;

	//VALIDATE form
	//if error send back with error message

	if(empty($_SESSION["fname01"])) {
		// if empty
		$_SESSION["fname01Error"] = 1;
		$_SESSION["errorCounter"]++;
	}

	if(empty($_SESSION["lname01"])) {
		$_SESSION["lname01Error"] = 1;
		$_SESSION["errorCounter"]++;
	}

	if(empty($_SESSION["email01"])) {
		$_SESSION["email01Error"] = 1;
		$_SESSION["errorCounter"]++;
	}

	//email validation is done
    if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]/", $_SESSION["email01"])) {

    // display success or failure message
	$_SESSION["email01Error"] = 1;
	$_SESSION["errorCounter"]++;
    }

	if(empty($_SESSION["dept01"])) {
		$_SESSION["dept01Error"] = 1;
		$_SESSION["errorCounter"]++;
	}

// check for duplicate sources
$query = mysql_query("SELECT * FROM tblPeople WHERE strEmail = ('" . $_SESSION["email01"] . "') && isSource = 1");
$row = mysql_fetch_array($query);

	if(mysql_num_rows($query) != 0) {
		$_SESSION["errorSameSource"] = 1;
		$_SESSION["email01Error"] = 1;

		$_SESSION["error"] = "Our database shows <strong>". $row[strFirstName]. " ". $row[strLastName]. "</strong> is assigned the entered email address.<br> <a rel='tooltip' title='Create a new Source profile' data-toggle='modal' href='#myModal' role='button' class='btn btn-small btn-danger'><strong> " . $row[strEmail]. " </strong> is assigned as a source in our database. Please enter a different email address for this source.</a>";
	    header("Location: ../addStory.php?newsID=" . $newsID . "&isComplete=false&count=1");
	}

// check for duplicate users who are NOT assigned as a source, then update them as a source
$query = mysql_query("SELECT * FROM tblPeople WHERE strEmail = ('" . $_SESSION["email01"] . "') && isSource = 0");
$row = mysql_fetch_array($query);

	if (mysql_num_rows($query) != 0) {

		$sql = "UPDATE tblPeople SET isSource='1' WHERE strEmail=('" . $_SESSION["email01"] . "')";
     		   mysql_query($sql);

		// redirect with success message
    	// **07-27: we need the stripslashes to return without any \'s.
		$_SESSION["success"] = "You've successfully added <strong>" . htmlspecialchars(stripslashes($_SESSION["fname01"]), ENT_QUOTES) . " " . htmlspecialchars(stripslashes($_SESSION["lname01"]), ENT_QUOTES) . "</strong> as a source.";

		// clear session variables
		$_SESSION["fname01"] = "";
		$_SESSION["lname01"] = "";
		$_SESSION["email01"] = "";
		$_SESSION["phone01"] = "";
		$_SESSION["dept01"] = "";
		$_SESSION["errorSameSource"] = 1;

		header("Location: ../addStory.php");
	}

	// if there are no errors, enter the source in the database (using the email to see if the source is already in there)
	if($_SESSION["errorCounter"] == 0 && ($_SESSION["errorSameSource"] == 0)) {

		$sql = "INSERT INTO tblPeople (strFirstName, strLastName, strEmail, strPhone, isSource, strRole) VALUES ('" . $_SESSION["fname01"] . "', '" . $_SESSION["lname01"] . "', '" . $_SESSION["email01"] . "', '" . $_SESSION["phone01"] . "', 1, 'Source');";
		mysql_query($sql);

		$sql = "SELECT MAX(peopleID) as maxNum FROM tblPeople";
		$result = mysql_query($sql);
		$maxPeopleID = mysql_fetch_array($result);

		$sql = "SELECT deptID FROM tblDept WHERE strDeptName='" . $_SESSION["dept01"]  . "';";
		$result = mysql_query($sql);
		$deptID = mysql_fetch_array($result);

		$sql = "INSERT INTO tblPeopleDept (peopleID, deptID) VALUES (" . $maxPeopleID["maxNum"] . ", " . $deptID["deptID"] . ");";
		mysql_query($sql);

		// update activity feed
		$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Added " .  $_SESSION["fname01"]  . " " .  $_SESSION["lname01"]  . " as a source.');";
		mysql_query($sql);

		// redirect with success message
    	// **07-27: we need the stripslashes to return without any \'s.
		$_SESSION["success"] = "You've successfully added <strong>" . htmlspecialchars(stripslashes($_SESSION["fname01"]), ENT_QUOTES) . " " . htmlspecialchars(stripslashes($_SESSION["lname01"]), ENT_QUOTES) . "</strong> as a source.";

		// clear session variables
		$_SESSION["fname01"] = "";
		$_SESSION["lname01"] = "";
		$_SESSION["email01"] = "";
		$_SESSION["phone01"] = "";
		$_SESSION["dept01"] = "";

		header("Location: ../addStory.php");
	}  // end if no errors AND the source is not already in the database (validating the email address)

        // gathers the errors from source modal blank fields and provides the below error message
		else if ($_SESSION["errorCounter"] > 0)  {
			// return user to last page
			$_SESSION["error"] = "We did not receive all of the information needed to add a source. Be sure to complete all of the fields and provide a valid email address.<br> <a rel='tooltip' title='Create a new Source profile' data-toggle='modal' href='#myModal' role='button' class='btn btn-small btn-danger'>Try Adding A Source Again</a>";
			header("Location: ../addStory.php?isComplete=false&count=1#myModal");
		}

}  ///////// end SOURCE modal work  above is "noWriterShowing" code ///////////////

// Go here if the POST is NOT = source
else {

	// #############################################################
	//	VALIDATION
	// #############################################################
	// validate things that are required
	// if empty; set session to true
	// redirect back to last page, specifying fields that are required
	// #############################################################

	// set that the form is complete by default
	$_SESSION["validationCount"] = 0;

    //the only REQUIRED field is filename
	if(empty($_SESSION["filename"])) {
		$_SESSION["filenameError"] = 1;
		$_SESSION["validationCount"]++;
	}

	if(strlen($_SESSION["tweet"]) > 140) {
		$_SESSION['error'] = "Your tweet must be 140 characters or less.";
		$_SESSION['tweetError'] = 1;
		header("Location: ../addStory.php?isComplete=false&count=1");
	}

	if($_SESSION["validationCount"] > 0) {
		// at least one required field was not finished
		// redirect back to last page with errors
		$_SESSION["error"] = "A <strong> filename </strong> is required to save a news story. Please fill out the <strong>filename</strong> field highlighted in red.";
		header("Location: ../addStory.php?isComplete=false&count=" . $_SESSION["validationCount"]);
	}
	// if no validation errors, come here. Goes to 2nd to last bracket
	   	else {

			$sql = "SELECT strHeadline FROM tblNews WHERE strHeadline='". $_SESSION["headline"] ."'";
			$result = mysql_query($sql);
			$num_rows = mysql_num_rows($result);

		if ($num_rows > 0 && $_SESSION["headline"] != "") {
			$_SESSION['error'] = "A story with that headline already exists. Please change your headline and try again.";
			$_SESSION['headlineError'] = 1;
			header("Location: ../addStory.php?isComplete=false&count=1");
		    }
			else {  // Third to last bracket


				// ############################################################# start here
				//	tblNewsWriterPeople -  This SQL statement is to add the writers,
				//  referencing this story
				// #############################################################
				// First, we have to query the tblNews table in order to get the maximum newsID and then increment it by one for this story's ID
				$sql2 = "SELECT MAX(newsID) as maxnum FROM tblNews;";
				$result2 = mysql_query($sql2);
				$row2 = mysql_fetch_assoc($result2);
				$newsIDNew = $row2["maxnum"] + 1;

				// #############################################################
				//	VALIDATION FOR MULTIPLE INPUTS
				// #############################################################

				$errorStopWriter = 0;
				$errorStopSource = 0;
				$errorStopAffiliation = 0;
				$errorStopDepartment = 0;

	// addStory.php: only 5 each writers, sources, and departments can be entered per story. Loop a max of 5 times


			for($i=1; $i<6; $i++) {
				if(!empty($_SESSION["writerID" .  $i])) {

					// match form names to database names
					$sql3 = "SELECT peopleID FROM tblPeople WHERE CONCAT_WS(' ', strFirstName, strLastName) = '". $_SESSION["writerID" .  $i] . "' LIMIT 1";
		    		$result = mysql_query($sql3);

					// if it ever is 0, nothing is inputted and error is sent back
					if (mysql_num_rows($result) == 0) {
						$errorStopWriter = 1;
						$_SESSION["error"] = "The writer you provided was not found in our database. Please check your spelling and try again. A great tip is to use the hints provided and not type the entire name out yourself. If you need to select a writer that does not appear, <a href='addUser.php'>add a writer to the database</a>.";
					    header("Location: ../addStory.php?isComplete=false&count=1");
					}
				}

				if(!empty($_SESSION["sourceID" .  $i])) {

					// match form names to database names
					$sql3 = "SELECT peopleID FROM tblPeople WHERE CONCAT_WS(' ', strFirstName, strLastName) = '". $_SESSION["sourceID" .  $i] . "' LIMIT 1";
					$result = mysql_query($sql3);

					// if it ever is 0 nothing is inputted and error is sent back
					if(mysql_num_rows($result) == 0) {
						$errorStopSource = 1;
						$_SESSION["error"] = "The source you provided was not found in our database. Please check your spelling and try again. A great tip is to use the hints provided and not type the entire name out yourself. If you need to select a source that does not appear, <a href='#myModal' data-toggle='modal'>add a source to the database</a>.";
					    header("Location: ../addStory.php?isComplete=false&count=1");
					}
				}
				if(!empty($_SESSION["departmentID" .  $i])) {
					// find department by using department name
					$sql3 = "SELECT deptID FROM tblDept WHERE strDeptName='" . $_SESSION["departmentID" . $i] . "';";
					$result = mysql_query($sql3);

					// if it ever is 0 nothing is inputted and error is sent back
					if(mysql_num_rows($result) == 0) {
						$errorStopDepartment = 1;
						$_SESSION["error"] = "The department you provided was not found in our database. Please check your spelling and try again. A great tip is to use the hints provided and not type the entire name out yourself. If you need to select a department that does not appear, <a href='contactHelp.php'>tell us</a>.";
					    header("Location: ../addStory.php?isComplete=false&count=1");
					}
				}
				if(!empty($_SESSION["affiliationID" .  $i])) {
					// find affiliationID by using affiliation name
					$sql3 = "SELECT affiliationID FROM tblAffiliation WHERE strAffiliation='" . $_SESSION["affiliationID" . $i] . "';";
					$result = mysql_query($sql3);

					// if it ever is 0 nothing is inputted and error is sent back
					if(mysql_num_rows($result) == 0) {
						$errorStopAffiliation = 1;
						$_SESSION["error"] = "The affiliate you provided was not found in our database. Please check your spelling and try again. A great tip is to use the hints provided and not type the entire name out yourself. If you need to select a affiliate that does not appear, <a href='contactHelp.php'>tell us</a>.";
					    header("Location: ../addStory.php?isComplete=false&count=1");
					}
				}

			} //  end FOR LOOP, addStory.php: only 5 each writers, sources, and departments can be entered per story. Loop a max of 5 times

			if($errorStopWriter == 0 && $errorStopSource == 0 && $errorStopAffiliation == 0 && $errorStopDepartment == 0) {

				// Now, insert the required information into the database.
				// Only need five tries because that's the max amount of fields we give them
				for($i=1; $i<6; $i++) {

					if(!empty($_SESSION["writerID" .  $i])) {

					// match form names to database names
					$sql3 = "SELECT peopleID FROM tblPeople WHERE CONCAT_WS(' ', strFirstName, strLastName) = '". $_SESSION["writerID" .  $i] . "' LIMIT 1";
		    		$result = mysql_query($sql3);

						if(mysql_num_rows($result) != 0) {
							while ($row = mysql_fetch_array($result)) {
								$sql2 = "INSERT INTO tblNewsWriterPeople (newsID, peopleID) VALUES (" . $newsIDNew . ", " . $row["peopleID"] . ");";
								mysql_query($sql2);
							}
						}
					}
				}  // end writer FOR loop

				// #############################################################
				//	tblNewsSourcePeople -  This SQL statement is to add the sources,
				//  referencing this story
				// #############################################################
				// Now, insert the required information into the database.
				// Only need five tries because that's the max amount of fields we give them
				for($i=1; $i<6; $i++) {

					if(!empty($_SESSION["sourceID" .  $i])) {

					// match form names to database names
						$sql3 = "SELECT peopleID FROM tblPeople WHERE CONCAT_WS(' ', strFirstName, strLastName) = '". $_SESSION["sourceID" .  $i] . "' LIMIT 1";
						$result = mysql_query($sql3);

		            	// if we find a row in the database matching the person, enter the following into the database
						if(mysql_num_rows($result) != 0) {
							while ($row = mysql_fetch_array($result)) {
								$sql2 = "INSERT INTO tblNewsSourcePeople (newsID, peopleID) VALUES (" . $newsIDNew . ", " . $row["peopleID"] . ");";
								mysql_query($sql2);
							}
						}
					}
				}    // end Source FOR loop

				// #############################################################
				//	tblNewsAffiliation -  This SQL statement is to add the affiliations,
				//  referencing this story
				// #############################################################
				// Now, insert the required information into the database.
				// Only need five tries because that's the max amount of fields we give them
				for($i=1; $i<6; $i++) {

					if(!empty($_SESSION["affiliationID" .  $i])) {
						// find affiliationID by using affiliation name
						$sql3 = "SELECT affiliationID FROM tblAffiliation WHERE strAffiliation='" . $_SESSION["affiliationID" . $i] . "';";
						$result = mysql_query($sql3);

						// if we find a row in the database matching the affiliation, enter the following into the database
						if(mysql_num_rows($result) != 0) {
							while ($row = mysql_fetch_array($result)) {
								$sql2 = "INSERT INTO tblNewsAffiliation (newsID, affiliationID) VALUES (" . $newsIDNew . ", " . $row["affiliationID"] . ");";
								mysql_query($sql2);
							}
						}
					}
				}  // end Affiliation FOR loop

					// #############################################################
				//	tblNewsDept -  This SQL statement is to add departments,
				//  referencing this story
				// #############################################################
				// Now, insert the required information into the database.
				// Only need five tries because that's the max amount of fields we give them
				for($i=1; $i<6; $i++) {

					if(!empty($_SESSION["departmentID" .  $i])) {
						// find affiliationID by using affiliation name
						$sql3 = "SELECT deptID FROM tblDept WHERE strDeptName='" . $_SESSION["departmentID" . $i] . "';";
						$result = mysql_query($sql3);

						// if we find a row in the database matching the affiliation, enter the following into the database
						if(mysql_num_rows($result) != 0) {
							while ($row = mysql_fetch_array($result)) {
								$sql2 = "INSERT INTO tblNewsDept (newsID, deptID) VALUES (" . $newsIDNew . ", " . $row["deptID"] . ");";
								mysql_query($sql2);
							}
						}
					}
				}  // end department FOR loop

	} //if there are errors don't do this section
			else {

				if($errorStopSource == 1) {
					$_SESSION["sourceError"] = 1;
					$j++;
				}
				if($errorStopWriter == 1) {
					$_SESSION["writerError"] = 1;
					$j++;
				}
				if($errorStopDepartment == 1) {
					$_SESSION["departmentError"] = 1;
					$j++;
				}
				if($errorStopAffiliation == 1) {
					$_SESSION["affiliationError"] = 1;
					$j++;
				}
				if($j >1) {
					// there were multiple field errors, so don't just display the error for one of them.
					$_SESSION["error"] .= "<br/><i>There were multiple fields where we could not find the input in the database. This is the first error of " . $j . ".</i>";
				}
			header("Location: ../addStory.php?isComplete=false&count=" . $j);
			die();
	}

				// #############################################################
				//	tblNewsFund-  This SQL statement is to add funds,
				//  referencing this story
				// #############################################################
				// Now, insert the required information into the database.

				$sql3 = "SELECT COUNT(fundID) AS numberOfFunds FROM tblFund;";
				$result = mysql_query($sql3);
				$row = mysql_fetch_array($result);

				for($i=0; $i <= $row["numberOfFunds"]; $i++) {
					if(!empty($_SESSION["fund"][$i])) {
						$sql2 = "INSERT INTO tblNewsFund (newsID, fundID) VALUES (" . $newsIDNew . ", " . $_SESSION["fund"][$i] . ");";
						mysql_query($sql2);
					}
				}

				// #############################################################
				//	tblNewsTopic -  This SQL statement is to add topics,
				//  referencing this story
				// #############################################################
				// Now, insert the required information into the database.

				$sql3 = "SELECT COUNT(topicID) AS numberOfTopics FROM tblTopic;";
				$result = mysql_query($sql3);
				$row = mysql_fetch_array($result);

				for($i=0; $i <= $row["numberOfTopics"]; $i++) {
					if(!empty($_SESSION["topic"][$i])) {

						$sql2 = "INSERT INTO tblNewsTopic (newsID, topicID) VALUES (" . $newsIDNew . ", " . $_SESSION["topic"][$i] . ");";
						mysql_query($sql2);
					}
				}

				// #############################################################
				//	tblNewsArea -  This SQL statement is to add areas,
				//  referencing this story
				// #############################################################
				// Now, insert the required information into the database.

				$sql3 = "SELECT COUNT(areaID) AS numberOfAreas FROM tblArea;";
				$result = mysql_query($sql3);
				$row = mysql_fetch_array($result);

				for($i=0; $i <= $row["numberOfAreas"]; $i++) {
					if(!empty($_SESSION["area"][$i])) {
						$sql2 = "INSERT INTO tblNewsArea (newsID, areaID) VALUES (" . $newsIDNew . ", " . $_SESSION["area"][$i] . ");";
						mysql_query($sql2);
					}
				}



				// #############################################################
				//	tblNewsTopic -  This SQL statement is to add topics,
				//  referencing this story
				// #############################################################
				// Now, insert the required information into the database.
				$sql3 = "SELECT COUNT(issuesID) AS numberofIssues FROM tblIssues;";
				$result = mysql_query($sql3);
				$row = mysql_fetch_array($result);

				for($i=0; $i < $row["numberofIssues"]; $i++) {
					if(!empty($_SESSION["issues"][$i])) {
						$sql2 = "INSERT INTO tblNewsIssues (newsID, issuesID) VALUES (" . $newsIDNew . ", " . $_SESSION["issues"][$i] . ");";
						mysql_query($sql2);
					}
				}

				// #############################################################
				//	tblNews - Saving news story information
				// #############################################################

					if($_SESSION["validationCount"] <= 0) {
					 $sql = "INSERT INTO tblNews (strHeadline, strURL, strImage, isAnswers, isScience, isColumn, isTopStory, datePublished, strCreatedBy, isAgricultures, isConnections, txtBody, txtIntent, strFilename, strReach, stageID, statusID, isExtTopStory, strWebsiteTitle1, strWebsiteTitle2, strWebsiteTitle3, strWebsiteTitle4, strWebsiteTitle5, strWebsite1, strWebsite2, strWebsite3, strWebsite4, strWebsite5, strTweet, isPhoto, isGraphic, isVideo, isAudio) VALUES ('". $_SESSION["headline"] ."', '". $_SESSION["youtube"] ."', '". $_SESSION["image"]."', ". $_SESSION["isAnswers"] .", ". $_SESSION["isScience"] .", ". $_SESSION["isColumn"] .", ". $_SESSION["isTopStory"] .", '" . $_SESSION["datePublished"] . "', '" . $_SESSION["user"] ."', " . $_SESSION["isAgricultures"] . ", " . $_SESSION["isConnections"] . ", '" . htmlspecialchars(mysql_real_escape_string($_SESSION["story"])) . "', '" . $_SESSION["intent"] . "', '" . $_SESSION["filename"] . "', '" . $_SESSION["reach"] . "', 1, 1, " . $_SESSION["isExtTopStory"] . ", '" . $_SESSION["websiteName1"] . "',   '" . $_SESSION["websiteName2"] . "',   '" . $_SESSION["websiteName3"] . "',  '" . $_SESSION["websiteName4"] . "', '" . $_SESSION["websiteName5"] . "', '" . $_SESSION["websiteURL1"] . "', '" . $_SESSION["websiteURL2"] . "', '" . $_SESSION["websiteURL3"] . "', '" . $_SESSION["websiteURL4"] . "', '" . $_SESSION["websiteURL5"] . "', '" . $_SESSION["tweet"] . "', " . $_SESSION["isPhoto"] . ", " . $_SESSION["isGraphic"] . ", " . $_SESSION["isVideo"] . ", " . $_SESSION["isAudio"] . ")";
					 mysql_query($sql) or die(mysql_error());

					$sql2 = "SELECT strStage FROM tblStage WHERE stageID=1;";
					$result2 = mysql_query($sql2);
					$stage = mysql_fetch_array($result2);

					// update activity feed
					$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (" . $newsIDNew . ", " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Created story.');";
					mysql_query($sql) or die(mysql_error());

					// reset variables of data since story has been processed
					$_SESSION["filename"]	 = "";
					$_SESSION["intent"]		 = "";
					$_SESSION["reach"]		 = "";
					$_SESSION["headline"]	 = "";
					$_SESSION["writerID1"]		 = "";
					$_SESSION["writerID2"]		 = "";
					$_SESSION["writerID3"]		 = "";
					$_SESSION["writerID4"]		 = "";
					$_SESSION["writerID5"]		 = "";
					$_SESSION["sourceID1"]		 = "";
					$_SESSION["sourceID2"]		 = "";
					$_SESSION["sourceID3"]		 = "";
					$_SESSION["sourceID4"]		 = "";
					$_SESSION["sourceID5"]		 = "";
					$_SESSION["departmentID1"]	 = "";
					$_SESSION["departmentID2"]	 = "";
					$_SESSION["departmentID3"]	 = "";
					$_SESSION["departmentID4"]	 = "";
					$_SESSION["departmentID5"]	 = "";
					$_SESSION["affiliationID1"] = "";
					$_SESSION["affiliationID2"] = "";
					$_SESSION["affiliationID3"] = "";
					$_SESSION["affiliationID4"] = "";
					$_SESSION["affiliationID5"] = "";
					$_SESSION["college"]	 = "";
					$_SESSION["affiliation"] = "";
					$_SESSION["area"]		 = "";
					$_SESSION["topic"]		 = "";
					$_SESSION["issues"]		 = "";
					$_SESSION["image"]		 = "";
					$_SESSION["youtube"]	 = "";
					$_SESSION["story"]		 = "";
					$_SESSION["isScience"]	 = "";
					$_SESSION["isColumn"]	 = "";
					$_SESSION["isAnswers"]	 = "";
					$_SESSION["isTopStory"]	 = "";
					$_SESSION["isExtTopStory"] = "";
					$_SESSION["datePublished"] = "";
					$_SESSION["websiteName1"] = "";
					$_SESSION["websiteName2"] = "";
					$_SESSION["websiteName3"] = "";
					$_SESSION["websiteName4"] = "";
					$_SESSION["websiteName5"] = "";
					$_SESSION["websiteURL1"] = "";
					$_SESSION["websiteURL2"] = "";
					$_SESSION["websiteURL3"] = "";
					$_SESSION["websiteURL4"] = "";
					$_SESSION["websiteURL5"] = "";
					$_SESSION["isPhoto"] = "";
					$_SESSION["isGraphic"] = "";
					$_SESSION["isVideo"] = "";
					$_SESSION["isAudio"] = "";


				header("Location: ../beholdStory.php?newsID=" . $newsIDNew);
					} else {
						$_SESSION["error"] = "You have done something I haven't coded for. Please <a href='contactHelp.php'>tell us what happened</a>.";
						header("Location: ../addStory.php?isComplete=false&count=1");
					}

		}   // end ELSE, adding writers referenced to the story
	}

}  // end ELSE. End here for the work when the POST is NOT = source
//2/7/14
?>