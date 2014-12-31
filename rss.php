<?php
// Now, first to create our RSS feed, start with the appropriate header:
header('Content-type: text/xml'); 
//Echo out the opening of the RSS document.  These are parts that just
//  describe your website, and what the RSS feed is about:-->
echo '<?xml version="1.0" encoding="utf-8"?>'; 
include_once('includes/db.php'); // authenticate users, includes db connection create feeds folder

$query = "SELECT * FROM tblNews WHERE isHidden=0 AND stageID=6 ORDER BY datePublished DESC";
$result = mysql_query($query);
?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title>Purdue Agriculture News</title>
    <link>http://www.agriculture.purdue.edu/news</link>
    <atom:link href="https://www.purdue.edu/agnewsdb/rss.php" rel="self" type="application/rss+xml" />
    <description>Research News and Events from Purdue University's College of Agriculture</description>
    <language>en-us</language>
    
	<?php while ($r = mysql_fetch_array($result))
	{
		// clear out the text editor crap, iterates through
		$story = html_entity_decode($r["txtBody"]);
		$story = strip_tags(html_entity_decode($story));
	?>
		<item>
		<title><? echo $r['strHeadline'] ?></title>
		<guid><? echo $r['strURL'] ?></guid>
		<link><? echo $r['strURL'] ?></link>
		<description><? echo preg_replace("/&#?[a-z0-9]{2,8};/i","", $story); ?></description>
		<pubDate><? echo gmdate(DATE_RSS, strtotime($r['datePublished'])); ?></pubDate>
		</item>

	<?php
	}
	?>
  </channel>
</rss>


