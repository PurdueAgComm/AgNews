<?php

// Now, first to create our RSS feed, start with the appropriate header:
header('Content-type: text/xml'); 




//Echo out the opening of the RSS document.  These are parts that just
//  describe your website, and what the RSS feed is about:-->
echo '<?xml version="1.0" encoding="utf-8"?>'; 


include_once('includes/db.php'); // authenticate users, includes db connection create feeds folder
//  Begin Function
function createRSSFile($title,$link,$description,$pubDate)
{
	$returnITEM = "<item>\n";
	# this will return the Title of the Article.
	$returnITEM .= "<title>".$title."</title>\n";
	# this will return the Description of the Article.
	$returnITEM .= "<description>".$link."</description>\n";
	# this will return the URL to the post.
	$returnITEM .= "<link>".$description."</link>\n";
	$returnITEM .= "<pubDate>" . $pubDate . "</pubDate>";
	$returnITEM .= "</item>\n";
	return $returnITEM;
}


// Lets build the page: this stuff will go under #6 in the doUpdate/doStatus file
$filename = "https://dev.www.purdue.edu/agnewsdb/feeds/rss.xml";
//$rootURL = "https://ag.purdue.edu/agcomm/Pages/News/feeds/"; -->
$latestBuild = date("r");
// Lets define the the type of doc we're creating.
$createXML = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$createXML .= "<rss version=\"0.92\">\n";
$createXML .= "<channel>
	<title>Purdue Agriculture News</title>
	<link>link goes here</link>
	<description>Research News and Events from Purdue University's College of Agriculture</description>

	<language>en</language>
";

// Lets Get the News Articles
$content_search = "SELECT strHeadline, txtBody, datePublished FROM tblNews ORDER BY datePublished DESC";
$content_results = mysql_query($content_search);
// Lets get the results
while ($articleInfo = mysql_fetch_object($content_results))
{
	//$page = $rootURL."$articleInfo->articleSEOTitle.html";
	//$description = "$articleInfo->articleDescription";
	//$title = "$articleInfo->articleTitle";
	
?>	
<!--/need to feed the xml document-->
<item>
<title><? echo $articleInfo['strHeadline'] ?></title>
<link><? $articleInfo['strURL'] ?></link>
<description><? echo html_entity_decode($articleInfo['txtBody']) ?></description>
<pubDate><? echo $articleInfo['datePublished'] ?></pubDate>
</item>

	
<?php	
	$createXML .= createRSSFile($title, $link, $description, $pubDate);
}


$createXML .= "</channel>\n </rss>";

// Finish it up
//$filehandle = fopen($filename,"w") or die("Can't open the file");
//fwrite($filehandle,$createXML);
//fclose($filehandle);
//echo "XML Sitemap updated!";
?>