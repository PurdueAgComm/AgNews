<?php
session_start();
include_once('../includes/db.php');
$notableID = (int) stripslashes($_GET["n"]);
$sql = "SELECT * FROM tblNews LEFT JOIN tblNewsArea ON tblNews.newsID=tblNewsArea.newsID WHERE tblNews.stageID=6 AND tblNewsArea.areaID=5 AND tblNews.isHidden=0 AND tblNews.newsID =" . $notableID . " ORDER BY tblNews.datePublished DESC LIMIT 5";
$result = mysql_query($sql);
$notableTitle = mysql_fetch_array($result);
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
(!empty($notableTitle["strHeadline"])) ? $title = $notableTitle["strHeadline"] . " - Purdue Agriculture Notables" : $title = "Purdue Agriculture Notables";
(!empty($notableTitle["txtBody"])) ? $body = strip_tags(html_entity_decode(htmlspecialchars_decode($notableTitle["txtBody"]))) : $body = "Appointments, Honors, and Notables from the College of Agriculture.";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="no-js" lang="en">
  <head>
    <meta content="Purdue University's College of Agriculture, or Purdue Agriculture, is one of the world's leading colleges of agriculture, food, life, and natural resource sciences. As a land-grant institution, we are committed to preparing our students to make a difference, wherever their careers take them; stretching the frontiers of science to find solutions to some of our most pressing global challenges; and, through Purdue Extension and engagement programs, helping the people of Indiana, the nation and the world improve their lives and livelihoods." name="description"/>
    <meta content="Purdue Agriculture, College of Agriculture, Purdue Extension, Tier 1 Research Institution, Agricultural and Biological Engineering, Agricultural Economics, Agronomy, Animal Sciences, Biochemistry, Botany and Plant Pathology, Entomology, Food Science, Forestry and Natural Resources, Horticulture and Landscape Architecture, Youth Development and Agricultural Education, Agricultural Research at Purdue, International Programs in Agriculture, Office of Academic Programs, Agricultural Communication, Agriculture Information Technology" name="keywords"/>
    <meta content="Purdue Agricultural Communication Service" name="author"/>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type"/>
    <meta charset="utf-8"/>
    <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
    <meta property="og:url" content="<?php echo $actual_link; ?>" />
    <meta property="og:title" content="<?= $title ?>" />
    <meta property="og:description" content="<?php echo $body; ?>" />
    <meta property="og:image" content="https://ag.purdue.edu/PublishingImages/PurdueAgFB.png" />
    <meta content="width=device-width, user-scalable=no" name="viewport"/>
    <title><?php echo $title ?>- Purdue University</title>
    <link href="images/favicon.ico" rel="shortcut icon"/>
    <script async="true" src="js/modernizr-1.5.min.js" type="text/javascript">
    </script>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"/>
    <!-- Main CSS -->
    <link href="css/styles.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  </head>
  <body style="">
    <div class="navbar navbar-inverse goldbar" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button class="navbar-toggle" data-target=".gold" data-toggle="collapse" type="button"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
          <p>Quick Links</p>
          <button class="navbar-toggle search" data-target="#search" data-toggle="collapse" style="float:right;" type="button">
          <i class="fa fa-search fa-lg"></i>
          </button>
        </div>
        <div class="collapse navbar-collapse right search" id="search">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-search fa-lg"></i></a>
            <ul class="dropdown-menu">
              <li>
                <form role="search">
                  <div class="form-group">
                    <div id="cse-search-form">Loading</div>
                    <script src="https://www.google.com/jsapi" type="text/javascript"></script>
                    <script type="text/javascript">// <![CDATA[
                    google.load('search', '1', {language: 'en', style: google.loader.themes.MINIMALIST});
                    google.setOnLoadCallback(function() {
                    var customSearchOptions = {};
                    var orderByOptions = {};
                    orderByOptions['keys'] = [{label: 'Relevance', key: ''} , {label: 'Date', key: 'date'}];
                    customSearchOptions['enableOrderBy'] = true;
                    customSearchOptions['orderByOptions'] = orderByOptions;
                    var customSearchControl =   new google.search.CustomSearchControl('017690826183710227054:mjxnqnpskjk', customSearchOptions);
                    customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
                    var options = new google.search.DrawOptions();
                    options.enableSearchboxOnly('//www.purdue.edu/purdue/search.html', 'q');
                    customSearchControl.draw('cse-search-form', options);
                    }, true);
                    // ]]></script>
                  </div>
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="collapse navbar-collapse gold">
        <ul class="nav navbar-nav information">
          <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Find Info For <b class="caret"></b></a>
          <ul class="dropdown-menu"><p class="hide">Find Info For</p>
          <li><a href="http://www.purdue.edu/purdue/current_students/index.html">Current Students</a></li>
          <li><a href="http://www.purdue.edu/purdue/prospective_students/index.html">Prospective Students</a></li>
          <li><a href="http://www.purdue.edu/purdue/alumni/index.html">Alumni and Friends</a></li>
          <li><a href="http://www.purdue.edu/purdue/engage/index.html">Engage with Purdue</a></li>
          <li><a href="http://www.purdue.edu/purdue/careers/index.html">Careers</a></li>
          <li><a href="http://www.purdue.edu/purdue/commercialization/index.html">Entrepreneurship and Commercialization</a></li>
          <li><a href="http://www.purdue.edu/purdue/research/index.html">Research and Innovation</a></li>
        </ul>
      </li>
    </ul>
    <ul class="nav navbar-nav right quicklinks"><p class="hide">Quick Links</p>
    <li><a href="http://www.purdue.edu/purdue/admissions/index.html">Apply</a></li>
    <li><a href="http://www.purdue.edu/newsroom/">News</a></li>
    <li><a href="http://www.purdue.edu/president/">President</a></li>
    <li><a href="http://www.purdueofficialstore.com/">Shop</a></li>
    <li><a href="http://www.purdue.edu/visit/">Visit</a></li>
    <li><a href="https://securelb.imodules.com/s/1461/research/hybrid/index.aspx?sid=1461&amp;gid=1010&amp;pgid=1754&amp;cid=4045">Give</a></li>
    <li><a href="http://www.purdue.edu/ea">Emergency</a></li>
  </ul>
</div>
<!--/.nav-collapse --></div>
</div>
<div class="top">
<div class="container">
  <div class="row">
    <div class="logo col-lg-2 col-md-3 col-sm-3 col-xs-12"><a href="//www.ag.purdue.edu"><img alt="Purdue Agriculture" src="images/logo.png"/></a></div>
    <div class="department col-lg-9 col-md-9 col-sm-9 col-xs-8"><a href="index.php">
      Notables
    </a><span class="tagline"><a href="https://www.ag.purdue.edu/agcomm">Agricultural Communication</a></span></div>
    </div>
  </div>
</div>
<div class="navbar navbar-inverse blackbar" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" data-target=".black" data-toggle="collapse" type="button"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button><p>Menu</p>
    </div>
    <div class="collapse navbar-collapse black">
      <ul class="nav navbar-nav">
        <li class="first"><a href="index.php">Home</a></li>
        <li><a href="https://ag.purdue.edu/Pages/aboutus.aspx">About Us</a></li>
        <li><a href="https://ag.purdue.edu/oap/">Academics</a></li>
        <li><a href="https://ag.purdue.edu/arp/">Research</a></li>
        <li><a href="http://www.extension.purdue.edu">Extension</a></li>
        <li><a href="https://www.ag.purdue.edu/omp/">Diversty</a></li>
        <li><a href="http://www.ag.purdue.edu/ipia">International Programs</a></li>
        <li><a href="https://ag.purdue.edu/Pages/departments.aspx">Departments</a></li>
        <li><a href="http://www.admissions.purdue.edu/apply/apply.php">Apply Online</a></li>
      </ul>
    </div>
    <!--/.nav-collapse -->
  </div>
</div>
<div class="breadcrumb">
  <div class="container">
    <div class="row">
      <div id="breadcrumbs"><ol class="col-lg-12 col-md-12 col-sm-12"><li><a href="index.php">Purdue Agriculture Notables</a></li></ol></div>
    </div>
  </div>
</div>
<div class="content">
  <div class="container">
    <div class="row">
      <div class="maincontent col-lg-9 col-md-9 col-sm-9 left">