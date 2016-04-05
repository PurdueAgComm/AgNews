<?php
session_start();


// global includes
include_once("../includes/db.php");

// Function page for funds.php
// creates, edits, hides, activates funds/validates
// #############################################################
// Grab information from last page and save
// #############################################################


// grab variables from other page and assign to the session variable

  $_SESSION["fundAdd"] = mysql_real_escape_string($_POST["fundAdd"]);
  $_SESSION["fundEdDel"] = mysql_real_escape_string($_POST["fundEdDel"]);
  $_SESSION["fundActivate"] = mysql_real_escape_string($_POST["fundActivate"]);
  $_SESSION["fundID"] = mysql_real_escape_string($_POST["fundID"]);


// if a new fund is requested
if(isset($_POST['submit']))
{

//Validate for an existing fund
$query = mysql_query("SELECT * FROM tblFund WHERE strFund=('" . $_SESSION["fundAdd"] . "')");

if(mysql_num_rows($query) != 0)
 {
//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
$_SESSION["error"] = "The fund, <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["fundAdd"]), ENT_QUOTES) . " " . "</strong>, already exists. Instead of creating a new one with the same name, activiate it below.";
  header("Location: ../funds.php");
 }
 else

//Check for a blank field for those without Javascript turned on
  if(empty($_SESSION["fundAdd"])) {
    // if empty
    $_SESSION["fundAddError"] = 1;
    $_SESSION["errorCounter"]++;
    // return user to last page
    $_SESSION["error"] = "We didn't receive a name for your new fund. Try submitting again.";
    header("Location: ../funds.php");
  }
  else
 {

  //success, enter the fund
  $sql = "INSERT INTO tblFund (strFund) VALUE ('" . $_SESSION["fundAdd"] . "');";
  mysql_query($sql);

// show a success
$_SESSION["success"] = "You've successfully added <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["fundAdd"]), ENT_QUOTES) . " " . "</strong> as an fund.";

//activity log for the adding a fund
$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Added the new fund option <em>" . $_SESSION["fundAdd"] . "</em>.');";
mysql_query($sql);
}
} // submit

// if an edit is asked
else if(isset($_POST['edit']))
{
//Validate for an existing fund
$query = mysql_query("SELECT * FROM tblfund WHERE strfund=('" . $_SESSION["fundAdd"] . "')");

if(mysql_num_rows($query) != 0)
 {
  $_SESSION["error"] = "The fund, <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["fundAdd"]), ENT_QUOTES) . " " . "</strong>, already exists. Instead of creating a new one with the same name, activiate it below.";
  header("Location: ../funds.php");
 }
else

//Check for a blank field for those without Javascript turned on
  if(empty($_SESSION["fundEdDel"])) {
    // if empty
    $_SESSION["fundEdDelError"] = 1;
    $_SESSION["errorCounter"]++;

// return user to last page
    $_SESSION["error"] = "We didn't receive a name for your edited fund. Try submitting again.";
    header("Location: ../funds.php");
  }
  else

{

//success, enter the fund
  $sql = "UPDATE tblFund SET strFund = ('" . $_SESSION["fundEdDel"] . "') WHERE tblFund.fundID = ('" . $_SESSION["fundID"] ."')";
    mysql_query($sql);

// show a success
//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
$_SESSION["success"] = "You've successfully edited the fund to <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["fundEdDel"]), ENT_QUOTES) . "</strong>.";

//activity log for the editing a fund
$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Edited the fund option <em>" . $_SESSION["fundEdDel"] . "</em>.');";
mysql_query($sql);
}
}
// if a deletion is requested
else if(isset($_POST['delete']))
{
  $sql = "UPDATE tblFund SET isHidden = 1 WHERE tblFund.fundID = ('" . $_SESSION["fundID"] ."')";
  mysql_query($sql);

  //Change the Hidden value to activate
  $sql = "UPDATE tblNewsFund SET isHidden = 1 WHERE tblNewsFund.fundID = ('" . $_SESSION["fundID"] ."')";
  mysql_query($sql);

  // show a success
  $_SESSION["success"] = "You've successfully deactivated <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["fundEdDel"]), ENT_QUOTES) . " " . "</strong>.";


  //activity log for the deleting a fund
  $sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Archived the fund option <em>" . $_SESSION["fundEdDel"] . "</em>.');";
  mysql_query($sql);
}

// if an activation is requested
else if(isset($_POST['reSubmit']))
{
  $sql = "UPDATE tblFund SET isHidden = 0 WHERE tblFund.fundID = ('" . $_SESSION["fundID"] ."')";
  mysql_query($sql);

  //Change the Hidden value to activate
  $sql = "UPDATE tblNewsFund SET isHidden = 0 WHERE tblNewsFund.fundID = ('" . $_SESSION["fundID"] ."')";
  mysql_query($sql);

  // show a success
  $_SESSION["success"] = "You've successfully activated <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["fundActivate"]), ENT_QUOTES) . " " . "</strong>.";


  //activity log for the activating a fund
  $sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Activated the fund <em>" . $_SESSION["fundActivate"] . "</em>.');";
  mysql_query($sql);
}


$_SESSION["fundAddError"] = 0;
$_SESSION["fundEdDelError"] = 0;
$_SESSION["fundActivateError"] = 0;
$_SESSION["errorCounter"] = 0;

// if there are no errors
if ($_SESSION["errorCounter"] == 0)
{
  // clear session variables
  $_SESSION["fundAdd"] = "";
  $_SESSION["fundEdDel"] = "";
  $_SESSION["fundActivate"] = "";
  $_SESSION["fundID"] = "";

  header("Location: ../funds.php");
}

?>