    <?php

    include_once('CAS.php');
    include_once('db.php');

     /*
    =========================================================
        Is the user part of Purdue?
        If not, then CAS does not authenticate.
    =========================================================
    */

    phpCAS::setDebug();
    phpCAS::client(CAS_VERSION_2_0, 'www.purdue.edu', 443, '/apps/account/cas');
    // phpCAS::client(CAS_VERSION_2_0, 'webservices-test.itns.purdue.edu', 443, '/apps/account/cas-server-uber-webapp-3.4.6');
    phpCAS::setNoCasServerValidation();
    phpCAS::forceAuthentication();

    // if they have the variable logout in the URL, they will be logged out from CAS
    if (isset($_REQUEST['logout']))
    {
        phpCAS::logout();
    }



    /*
    =========================================================
        Is the user part of AgComm as a writer, admin of the system, or support staff? 
        If not, then redirect them to a page saying they do
        not have access. Authentication should be on every
        page.
    =========================================================
    */

    $SQL = "SELECT * FROM tblPeople WHERE alias='" . phpCAS::getUser() . "' AND (isAdmin=1 OR isWriter=1 OR isSupport=1);";
    $result = mysql_query($SQL) or die(mysql_error());
    $row = mysql_fetch_array($result);
    if(empty($row["alias"]))
    {
        // They're not found in the database or they do not
        // have the appropriate status so they are not allowed to log in.
        header("Location: error.php?reason=agcomm");
    }
    else {
        // Let's store information about the person who is logged in
        // that will be used throughout the website.
        $_SESSION["user"] = $row["alias"];
        $_SESSION["userID"] = $row["peopleID"];
        $_SESSION["userName"] = $row["strFirstName"] . " " . $row["strLastName"];
        $_SESSION["firstName"] = $row["strFirstName"];
        $_SESSION["lastName"] = $row["strLastName"];
        $_SESSION["userPhone"] = $row["strPhone"];
        $_SESSION["userEmail"] = $row["strEmail"];
        $_SESSION["isAdmin"] = $row["isAdmin"];
        $_SESSION["isWriter"] = $row["isWriter"];
        $_SESSION["isSupport"] = $row["isSupport"];

        //update timestamp for last login
        $sql = "UPDATE tblPeople SET dateLastLogin='" . date("Y-m-d H:i:s") . "' WHERE peopleID=" . $row["peopleID"];
        mysql_query($sql) or die(mysql_error());

    }




 
?>