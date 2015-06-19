
<!DOCTYPE html>

<?php
// global includes
include_once('includes/auth.php'); // authenticate users, includes db connection

// how many stories are waiting on them?
$redSQL = "SELECT * FROM tblNews INNER JOIN tblNewsWriterPeople ON tblNews.newsID = tblNewsWriterPeople.newsID WHERE tblNews.isHidden=0 AND tblNews.statusID=1 AND tblNewsWriterPeople.peopleID ='" . $_SESSION["userID"] . "';";
$redResult = mysql_query($redSQL);
$_SESSION["waitingOnWriter"] = mysql_num_rows($redResult);
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>AgComm News Administration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"/>

    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet"/>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="ico/favicon.png">
  </head>

  <body>
    <div class="container">

      <div class="masthead">
        <a href="/agnewsdb"><h2 class="muted">Agricultural Communication News Center</h2></a>

<nav class="navbar navbar-default ">

     <ul class="nav navbar-nav">
                <li><a href="index.php">Home <span rel='tooltip' title='You have <?php echo  $_SESSION["waitingOnWriter"];?> stories that are waiting on you.' class='badge badge-info'><?php if($_SESSION["waitingOnWriter"] != 0) { echo $_SESSION["waitingOnWriter"]; } ?></span></a> </li>
                <li><a href="viewAllStories.php">News Stories</a></li>
                <li><a href="addStory.php">Add Story</a></li>
                <li><a href="help.php">Help</a></li>
                <?php if($_SESSION["isAdmin"]) : ?>
                <li><a href="controlPanel.php">Control Panel</a></li>
                <?php endif; ?>
                <li><a href="?logout=1">Logout</a></li>
       </ul>

</nav> <!-- /.navbar -->

      </div>



