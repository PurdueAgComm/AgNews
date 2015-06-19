
<?php include_once("includes/header.php"); ?>
  <h1>Archives</h1>
  <p> Cras sed orci pellentesque, porttitor odio nec, convallis odio. Maecenas id tellus enim. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
  <?php
    $year = date("Y");
    // no stories beyond 2010
    while($year >= 2010) {
      $sql = "SELECT tblNews.strHeadline, tblNews.newsID FROM tblNews LEFT JOIN tblNewsArea ON tblNews.newsID=tblNewsArea.newsID WHERE tblNews.stageID=6 AND tblNewsArea.areaID=5 AND tblNews.isHidden=0 AND YEAR(tblNews.datePublished)=" . $year . " ORDER BY datePublished DESC";
      $result = mysql_query($sql);
      $numResult = mysql_num_rows($result);
      if($numResult > 0) {
        echo "<h2>" . $year . "</h2>";
        echo "<ul>";
        while($notable = mysql_fetch_array($result)) {
          echo "<li>";
          echo "<a href='notable.php?n=" . $notable["newsID"] . "'>" . $notable["strHeadline"] . "</a>";
          echo "</li>";
        }
        echo "</ul>";
      } // end if
      $year--;
    } //end year while
    ?>
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
  </ul>
</div>
<div class="sidecontent col-lg-3 col-md-3 col-sm-3">

</div>
<?php include_once("includes/footer.php"); ?>