<?php
session_start();
include_once("../includes/db.php");

$deptID = $_GET["deptID"];

// grab varibles from other page

// **07-27: This escapes the apostrophe with a \. The \ does not go in the database but must be removed in the "success" message. http://nyphp.org/PHundamentals/5_Storing-Data-Submitted-Form-Displaying-Database

$_SESSION["deptID"] = mysql_real_escape_string($_POST["deptID"]); 
$_SESSION["isHidden"] = (int) mysql_real_escape_string($_POST["isHidden"]);
$_SESSION["deptName"] = mysql_real_escape_string(str_replace('"', "''", $_POST["deptName"]));
$_SESSION["college"] = mysql_real_escape_string(str_replace('"', "''", $_POST["college"]));

$_SESSION['isHiddenError'] = 0;
$_SESSION['collegeError'] = 0;
$_SESSION["deptNameError"] = 0;
$_SESSION["Error"] = 0;
$_SESSION["errorCounter"] - 0;

// if a deletion is requested
if(isset($_POST['edit']))
{ 
//VALIDATE
	if(empty($_SESSION["deptName"])) 
	{
	  // if empty
	  $_SESSION["deptNameError"] = 1;
	  $_SESSION["collegeError"] = 0;
	  $_SESSION["errorCounter"]++;
	  $_SESSION["error"] = "Please enter the department in the <em>Department Name</em> field.";
	  	header("Location: ../editDept.php?deptID=" . $deptID);
	}

		else if(empty($_SESSION["college"])) 
		{
		  $_SESSION['deptNameError'] = 0;
		  $_SESSION["collegeError"] = 1;
		  $_SESSION["errorCounter"]++;
		  $_SESSION["error"] = "We didn't get a college/entity name. Could you help us out? Please complete the <em>College/Entity</em> field.";
		  	header("Location: ../editDept.php?deptID=" . $deptID);
		}

	if(!empty($_SESSION["college"]) && !empty($_SESSION["deptName"]))
	{
        // check for duplicate departments. The reason for only checking the first name is this is all that shows in the dropdown. 
        //Two of the same department names in the dropdown would be impossible to differentiate.		
		$query = mysql_query("SELECT * FROM tblDept WHERE strDeptName = ('" . $_SESSION["deptName"] . "') ");
        $row = mysql_fetch_array($query);

		  if(mysql_num_rows($query)!=0) 
		{
			if(($row["strDeptName"] = $_SESSION["deptName"]) && ($row["deptID"] != $_SESSION["deptID"]))

		  { 
		  	//comes down here because the number of rows from the query is NOT 0 and is okay to update because the name is different
			$_SESSION["deptNameError"] = 1;
			$_SESSION["collegeError"] = 0;
			$_SESSION["errorCounter"]++;
			
			$_SESSION["error"] = "Our database shows <strong>". htmlspecialchars_decode(stripslashes($row[strDeptName]), ENT_QUOTES) . "</strong> is in our database. Type in a different department name or check the archived list of departments for possible activation.<br> <a rel='tooltip' title='Edit Department profile' href='/agnewsdb/editDept.php#archDept' role='button' class='btn btn-small btn-danger'>Please go to Edit Department if you want to make the department active.</a>";
		  	header("Location: ../editDept.php?deptID=" . $deptID);
		  
		  } // end checking if the department name AND the department ID matches
		} // end if more than 0 results are found where the database department name matches the user entered department name
			if($_SESSION["errorCounter"] <= 0) 
			  { 
				  $sql = "SELECT * FROM tblDept WHERE deptID= ('" . $deptID ."')";
				  $result = mysql_query($sql);
				  $dept = mysql_fetch_array($result);

				  //success, enter the department
				  $sql = "UPDATE tblDept SET strDeptName='" . $_SESSION["deptName"] . "', strCollege='" . $_SESSION["college"] . "' WHERE deptID=" . $deptID;
				  mysql_query($sql);
				  						  
				  //activity log for the deleted
				  $sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Edited the department <em>" . $_SESSION["deptName"] . "</em>.');";
				  mysql_query($sql);	
			
				  //SUCCESS!! take me back to the list view
				  $_SESSION["success"] = "You've successfully edited <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["deptName"]), ENT_QUOTES) . ", " . htmlspecialchars_decode(stripslashes($_SESSION["college"]), ENT_QUOTES) . "</strong>.";	
				  header("Location: ../editDept.php");
				  
			  } // end if college and dept name fields are empty check		
	} // end if College and Dept fields are empty
} // end EDIT

		// if a deletion is requested
		else if(isset($_POST['delete']))
		{ 

		    $sql = "UPDATE tblDept SET isHidden = 1 WHERE tblDept.deptID = ('" . $_SESSION["deptID"] ."')";
			mysql_query($sql);

			// show a success
			//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
			$_SESSION["success"] = "You've successfully archived <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["deptName"]), ENT_QUOTES) . " " . "</strong>.";	
			header("Location: ../editDept.php");
			

			//activity log for the deleted
			$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Archived the department <em>" . $_SESSION["deptName"] . "</em>.');";
			mysql_query($sql);	
		}

			// if an activation is requested
			else if(isset($_POST['activate']))
			{ 

				$sql = "UPDATE tblDept SET isHidden = 0 WHERE tblDept.deptID = ('" . $_SESSION["deptID"] ."')";
			 	mysql_query($sql);
					
				// show a success
				//-- **07-27: htmlspecialchars(stripslashes) shows the text without the backslash. Keeps the text together so it doesn't break once the apostrophe is reached  -->
				$_SESSION["success"] = "You've successfully activated <strong>" . htmlspecialchars_decode(stripslashes($_SESSION["deptName"]), ENT_QUOTES) . " " . "</strong>.";	
				header("Location: ../editDept.php");
				
				//activity log for the department activation
				$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Activated the department <em>" . $_SESSION["deptName"] . "</em>.');";
				mysql_query($sql);
			}

		else 
		{
		// return user to last page
		header("Location: ../editDept.php");			
		}	
	
// clear variables	
$_SESSION["deptID"] = "";
$_SESSION["isHidden"] = "";
$_SESSION["deptName"] = "";
$_SESSION["college"] = "";


?>