    <?php

    $SQL = "SELECT alias FROM authUsers WHERE alias='" . phpCAS::getUser() . "'";
    $result = mysql_query($SQL) or die(mysql_error());
    $row = mysql_fetch_array($result);
    
    if(empty($row["alias"]))
    {
    	header("Location: error.php?reason=agcomm");
    }

    ?>