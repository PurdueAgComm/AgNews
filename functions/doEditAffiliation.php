<?php
session_start();
include_once("../includes/db.php");

$affiliationID = $_GET["affiliationID"];

// grab varibles from other page

// **07-27: This escapes the apostrophe with a \. The \ does not go in the database but must be removed in the "success" message. http://nyphp.org/PHundamentals/5_Storing-Data-Submitted-Form-Displaying-Database

$_SESSION["affiliationID"] = mysql_real_escape_string($_POST["affiliationID"]); 
$_SESSION["isHidden"] = (int) mysql_real_escape_string($_POST["isHidden"]);
$_SESSION["affiliation"] = mysql_real_escape_string(str_replace('"', "''", $_POST["affiliation"]));

$_SESSION['isHiddenError'] = 0;
$_SESSION['affiliationError'] = 0;
$_SESSION["Error"] = 0;
$_SESSION["errorCounter"] - 0;

// if a deletion is requested
if(isset($_POST['edit']))
{ 
//VALIDATE
	if(empty($_SESSION["affiliation"])) 
	{
	  // if empty
	  $_SESSION["affiliationError"] = 1;
	  $_SESSION["errorCounter"]++;
	  $_SESSION["error"] = "Please enter the affiliation in the <em>Affiliation</em> field.";
      header("Location: ../editAffiliation.php?affiliationID=" . $affiliationID);
	}

	    // check for duplicate affiliations.		
		$query = mysql_query("SELECT * FROM tblAffiliation WHERE strAffiliation = ('" . $_SESSION["affiliation"] . "') ");
        $row = mysql_fetch_array($query);

		  if(mysql_num_rows($query)!=0) 
		{
			if(($row["strAffiliation"] = $_SESSION["affiliation"]) && ($row["affiliationID"] != $_SESSION["affiliationID"]))

		  { 
		  	//comes down here because the number of rows from the query is NOT 0 and is okay to update because the name is different
			$_SESSION["affiliationError"] = 1;
			$_SESSION["errorCounter"]++;
			
			$_SESSION["error"] = "Our database shows <strong>". htmlspecialchars_decode(stripslashes($row[strAffiliation]), ENT_QUOTES) . "</strong> is in our database. Type in a different affiliation or check the archived list of affiliations for possible activation.<br> <a rel='tooltip' title='Edit Affiliation profile' href='/agnewsdb/editAffiliation.php#archAffiliation' role='button' class='btn btn-small btn-danger'>Please go to Edit Affiliation if you want to make the affiliation active.</a>";
		  	header("Location: ../editAffiliation.php?affiliationID=" . $affiliationID);
		  
		  } // end checking if the affiliation AND the affiliation ID matches
		 } // end if more than 0 results are found where the database department name matches the user entered affiliation
			if($_SESSION["errorCounter"] <= 0) 
			  { 

				  $sql = "SELECT * FROM tblAffiliation WHERE affiliationID= ('" . $affiliationID ."')";
				  $result = mysql_query($sql);
				  $dept = mysql_fetch_array($result);
			
				  //success, enter the affiliation
				  $sql = "UPDATE tblAffiliation SET strAffiliation='" . $_SESSION["affiliation"] . "' WHERE affiliationID=" . $affiliationID;
				  mysql_query($sql);
				  
			
				  //SUCCESS!! take me back to the list view
				  $_SESSION["success"] = "You've successfully edited <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["affiliation"]), ENT_QUOTES) . "</strong>.";	
				  header("Location: ../editAffiliation.php");
				  
												
				  //activity log for the edit
				  $sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Edited the affiliation <em>" . $_SESSION["affiliation"] . "</em>.');";
				  mysql_query($sql);	
			
			  } // end if affiliation field is already in the database is empty check	
			  
} // end EDIT

		// if a deletion is requested
		else if(isset($_POST['delete']))
		{ 

		    $sql = "UPDATE tblAffiliation SET isHidden = 1 WHERE tblAffiliation.affiliationID = ('" . $_SESSION["affiliationID"] ."')";
			mysql_query($sql);

			// show a success
			//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
			$_SESSION["success"] = "You've successfully archived <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["affiliation"]), ENT_QUOTES) . " " . "</strong>.";	
			header("Location: ../editAffiliation.php");
			
			//activity log for the deleted
			$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Archived the affiliation <em>" . $_SESSION["affiliation"] . "</em>.');";
			mysql_query($sql);	
		
		}
			// if an activation is requested
			else if(isset($_POST['activate']))
			{

				$sql = "UPDATE tblAffiliation SET isHidden = 0 WHERE tblAffiliation.affiliationID = ('" . $_SESSION["affiliationID"] ."')";
			 	mysql_query($sql);
					
				// show a success
				//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
				$_SESSION["success"] = "You've successfully activated <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["affiliation"]), ENT_QUOTES) . " " . "</strong>.";	
				header("Location: ../editAffiliation.php");

				//activity log for the affiliation activation
				$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Activated the affiliation <em>" . $_SESSION["affiliation"] . "</em>.');";
				mysql_query($sql);
				
			}
		
		else 
		{
		// return user to last page
		header("Location: ../editAffiliation.php");			
		}	
	
// clear variables	
$_SESSION["affiliationID"] = "";
$_SESSION["isHidden"] = "";
$_SESSION["affiliation"] = "";

?>