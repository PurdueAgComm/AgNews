<?php include_once("includes/header.php"); ?>
<?php
  $notableID = (int) stripslashes($_GET["n"]);
  $sql = "SELECT * FROM tblNews LEFT JOIN tblNewsArea ON tblNews.newsID=tblNewsArea.newsID WHERE tblNews.stageID=6 AND tblNewsArea.areaID=5 AND tblNews.isHidden=0 AND tblNews.newsID =" . $notableID . " ORDER BY tblNews.datePublished DESC LIMIT 5";
  $result = mysql_query($sql);
  while($notable = mysql_fetch_array($result)) :
    $title = $notable["strHeadline"]; ?>
    <h1><?php echo $notable["strHeadline"]; ?></h1>
    <div class="noteDate pull-left"><i class="fa fa-calendar"></i> <?php echo date("F d, Y", strtotime($notable["datePublished"])); ?></div>
    <div class="addthis_sharing_toolbox noteDate pull-right"></div>
    <br class="clearfix" />
    <p><?php echo html_entity_decode(htmlspecialchars_decode($notable["txtBody"])); ?></p>
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
<li><a href="archives.php"><strong>View All Notables</strong></a>
</ul>
</div>
<div class="sidecontent col-lg-3 col-md-3 col-sm-3">

</div>
<?php include_once("includes/footer.php"); ?>