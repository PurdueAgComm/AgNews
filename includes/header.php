
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
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->
  </head>
  <body>
  <div class="container">
    <!-- Static navbar -->
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/agnewsdb/index.php">AgNews DB</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <?php if(!empty($_SESSION["waitingOnWriter"])) : ?>
              <li><a href="/agnewsdb/index.php"><span data-container="body" data-placement="bottom" rel='tooltip' title='You have <?php echo  $_SESSION["waitingOnWriter"];?> action(s) waiting' class='badge badge-info'><?php if($_SESSION["waitingOnWriter"] != 0) { echo $_SESSION["waitingOnWriter"]; } ?></span></a></li>
            <?php endif; ?>
              <li><a href="viewAllStories.php"><i class="fa fa-newspaper-o"></i> News Stories</a></li>
              <li><a href="addStory.php"><i class="fa fa-plus-circle"></i> Add Story</a></li>
              <li><a href="help.php"><i class="fa fa-question-circle"></i> Help</a></li>
              <li><a href="getNotified.php"><i class="fa fa-bell-o"></i> Get Notified</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php if($_SESSION["isAdmin"]) : ?>
              <li><a href="controlPanel.php"><i class="fa fa-cogs"></i> Control Panel</a></li>
            <?php endif; ?>
            <li><a href="?logout=1"><i class="fa fa-sign-out"></i> Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div><!--/.container-fluid -->
    </nav>
