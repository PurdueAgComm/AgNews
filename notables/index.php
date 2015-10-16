<?php include_once("includes/header.php");
ini_set('display_errors',1);
error_reporting(E_ALL);



function getFirstPara($string){
    $string = substr($string,0, strpos($string, "</p>")+4);
        $string = str_replace("<p>", "", str_replace("</p>", "", $string));
        return $string;
}

 ?>
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
          <img alt="Page Banner" class="banner" height="235" src="images/page-banner.jpg" width="840"/>
          <h1>Notables</h1>
          <p>Appointments, honors, and other accomplishments in the College of Agriculture.</p>
          <?php
          $sql = "SELECT * FROM tblNews LEFT JOIN tblNewsArea ON tblNews.newsID=tblNewsArea.newsID WHERE tblNews.stageID=6 AND tblNewsArea.areaID=5 AND tblNews.isHidden=0 ORDER BY tblNews.datePublished DESC LIMIT 5";
          $result = mysql_query($sql);
          while($notable = mysql_fetch_array($result)) : ?>
          <h2><a href="notable.php?n=<?php echo $notable["newsID"]?>"><?php echo $notable["strHeadline"]; ?></a></h2>
          <p class="noteDate"><i class="fa fa-calendar"></i> <?php echo date("F d, Y", strtotime($notable["datePublished"])); ?></p>
          <p>
          <?php
            $body = html_entity_decode(htmlspecialchars_decode($notable["txtBody"]));
            $body = preg_replace("/&#?[a-z0-9]+;/i"," ",$body);
            echo getFirstPara($body);
            echo " ";
            echo "<a href='notable.php?n=" . $notable["newsID"] . "'>Read More &#187;</a>";

          ?>
          </p>
          <?php endwhile; ?>
        </div>
        <div class="sidenav col-lg-3 col-md-3 col-sm-3">
          <h3 class="header">Recent Notables</h3>
          <ul>
            <?php
            $sql = "SELECT * FROM tblNews LEFT JOIN tblNewsArea ON tblNews.newsID=tblNewsArea.newsID WHERE tblNews.stageID=6 AND tblNewsArea.areaID=5 AND tblNews.isHidden=0 ORDER BY tblNews.datePublished DESC LIMIT 10";
            $result = mysql_query($sql);
            while($notable = mysql_fetch_array($result)) : ?>
            <li><a href="notable.php?n=<?php echo $notable["newsID"]?>"><?php echo $notable["strHeadline"]; ?></a></li>
            <?php endwhile; ?>
            <li><a href="archives.php"><strong>View All Notables</strong></a></li>
          </ul>
        </div>
        <div class="sidecontent col-lg-3 col-md-3 col-sm-3">
        </div>
        <?php include_once("includes/footer.php"); ?>





