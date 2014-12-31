<?php
//session_start();
//include_once("../includes/db.php");

// grab varibles from other page
//$_SESSION["fname01"] = mysql_escape_string($_POST["fname01"]);
//$_SESSION["lname01"] = mysql_escape_string($_POST["lname01"]);
//$_SESSION["email01"] = mysql_escape_string($_POST["email01"]);
//$_SESSION["phone01"] = mysql_escape_string($_POST["phone01"]);
//$_SESSION["dept01"]  = mysql_escape_string($_POST["dept01"]);
//$source = $_POST["source"];

//$_SESSION["fname01Error"] = 0;
//$_SESSION["lname01Error"] = 0;
//$_SESSION["email01Error"] = 0;
//$_SESSION["phone01Error"] = 0;
//$_SESSION["dept01Error"] = 0;
//$_SESSION["errorCounter"] = 0;

//echo $source;
//die("s");

//VALIDATE

//if error send back
// if success write to database
// send success message

//if(empty($_SESSION["fname01"])) {
	// if empty
//	$_SESSION["fname01Error"] = 1;
//	$_SESSION["errorCounter"]++;
//}

//if(empty($_SESSION["lname01"])) {
//	$_SESSION["lname01Error"] = 1;
//	$_SESSION["errorCounter"]++;

//}

//if(empty($_SESSION["email01"])) {
//	$_SESSION["email01Error"] = 1;
//	$_SESSION["errorCounter"]++;
//}
//if(empty($_SESSION["dept01"])) {
//	$_SESSION["dept01Error"] = 1;
//	$_SESSION["errorCounter"]++;
//}


// if there are no errors
//if($_SESSION["errorCounter"] == 0) 
//{
	// do your SQL statement
//	$sql = "INSERT INTO tblPeople (strFirstName, strLastName, strEmail, strPhone, isSource, strRole) VALUES ('" . $_SESSION["fname01"] . "', '" . $_SESSION["lname01"] . "', '" . $_SESSION["email01"] . "', '" . $_SESSION["phone01"] . "', 1, 'Source');";
//	mysql_query($sql);


//	$sql = "SELECT MAX(peopleID) as maxNum FROM tblPeople";
//	$result = mysql_query($sql);
//	$maxPeopleID = mysql_fetch_array($result);

//	$sql = "SELECT deptID FROM tblDept WHERE strDeptName='" . $_SESSION["dept01"]  . "';";
//	$result = mysql_query($sql);
//	$deptID = mysql_fetch_array($result);

//	$sql = "INSERT INTO tblPeopleDept (peopleID, deptID) VALUES (" . $maxPeopleID["maxNum"] . ", " . $deptID["deptID"] . ");";
//	mysql_query($sql);



	// redirect with success message
//	$_SESSION["success"] = "You've successfully added <strong>" . $_SESSION["fname01"] . " " . $_SESSION["lname01"] . "</strong> as a source.";

	// clear session variables
//	$_SESSION["fname01"] = "";
//	$_SESSION["lname01"] = "";
//	$_SESSION["email01"] = "";
//	$_SESSION["phone01"] = "";
//	$_SESSION["dept01"] = "";


	//header("Location: ../addStory.php");

//}
//else {
	// return user to last page
//	$_SESSION["error"] = "You did not complete the fields correctly when adding a source.<br> <a rel='tooltip' title='Create a new Source profile' data-toggle='modal' href='#myModal' role='button' class='btn btn-small btn-danger'>Try Adding A Source Again</a>";
//	header("Location: ../addStory.php?isComplete=false&count=1#myModal");

//}



?>