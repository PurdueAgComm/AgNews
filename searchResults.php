<?php
include_once('includes/header.php');

	function search_split_terms($terms){

		$terms = preg_replace("/\"(.*?)\"/e", "search_transform_term('\$1')", $terms);
		$terms = preg_split("/\s+|,/", $terms);

		$out = array();

		foreach($terms as $term){

			$term = preg_replace("/\{WHITESPACE-([0-9]+)\}/e", "chr(\$1)", $term);
			$term = preg_replace("/\{COMMA\}/", ",", $term);

			$out[] = $term;
		}

		return $out;
	}

	function search_html_escape_terms($terms){
		$out = array();

		foreach($terms as $term){
			if (preg_match("/\s|,/", $term)){
				$out[] = '"'.HtmlSpecialChars($term).'"';
			}else{
				$out[] = HtmlSpecialChars($term);
			}
		}

		return $out;
	}

	function search_pretty_terms($terms_html){

		if (count($terms_html) == 1){
			return array_pop($terms_html);
		}

		$last = array_pop($terms_html);

		return implode(', ', $terms_html)." and $last";
	}


if(!empty($_GET["q"])) {

	$term_list = search_pretty_terms(search_html_escape_terms(search_split_terms($_GET["q"])));
	$terms = search_split_terms($_GET["q"]);

	$parts = array();
	foreach($terms as $term){
		if($term != "and") {
			$parts[] = "strFilename RLIKE '$term' OR strHeadline RLIKE '$term'";
		}
	}

	$parts = implode(' AND ', $parts);
	$sql = "SELECT * FROM tblNews WHERE isHidden=0 AND $parts";
	$result = mysql_query($sql);
	$numResult = mysql_num_rows($result);


	if(empty($numResult))
	{
		$numResult = "no";
	}

	if(!empty($_GET["h"])) {

		if($_GET["h"] == "yes") {
			$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Searched for <em>" . $term_list . "</em> and found it <span class=\'text text-success\'>helpful</span>.');";
			mysql_query($sql) or die(mysql_error());

		}

		if($_GET["h"] == "no") {
			$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Searched for <em>" . $term_list . "</em> and found it <span class=\'text text-error\'>not helpful</span>.');";
			mysql_query($sql);

		}

	}
	else {
		// update activity feed
		$sql = "INSERT INTO tblActivity (newsID, peopleID, strFirstName, strLastName, strActivity) VALUES (NULL, " . $_SESSION["userID"] . ", '" . $_SESSION["firstName"] .  "', '" . $_SESSION["lastName"] . "', 'Searched for <em>" . $term_list . "</em> and received " . $numResult . " results.');";
		mysql_query($sql);
	}



} // end if


?>
 <div class="row-fluid">

 	<?php if(empty($_GET["h"])) { ?>
 		<div class="pull-right">
		  	<small>Were your results useful? </small>
		  	<a href="searchResults.php?q=<?php echo $_GET['q'] ?>&h=yes" class="btn btn-mini" style="margin-right: 0px;">Yes</a>
		  	<a href="searchResults.php?q=<?php echo $_GET['q'] ?>&h=no" class="btn btn-mini"  style="margin-left: 0px; position: relative; left: -6px;">No</a>
	    </div>
	 <?php } else { ?>
	 	<div class="pull-right"><span class="text text-success"><small><span class='label label-success'><i class='fa fa-check-circle-o icon-white'></i></span> Thanks for your feedback!</small></span></div>
	 <?php } ?>

 	<?php
 	if($numResult > 0) { ?>
		<h3>Search Results (<?php echo $numResult ?>)</h3>
        <form class="form-inline pull-right" action="searchResults.php" method="get" style="margin-bottom: 10px;">
        <div class="form-group">
		    <label for="search" class="sr-only">Password</label>
		    <input class="form-control" id="search" type="text" name="q" placeholder="Search Stories">
		</div>
		<button class="btn btn-default" type="submit" onClick="setConfirmUnload(false);" type="submit"><i class='fa fa-search'></i></button>
        </form>



		  <table class="table table-striped table-hover table-bordered">
	      <tr>
	        <td width="55%">Headline</td>
	        <td width="20%">Date Released</td>
	      </tr>


		<?php
			if(!empty($_GET["q"]) AND $numResult > 0) {
				while($row = mysql_fetch_array($result)) {
						echo "<tr>";
						echo "<td><a href='beholdStory.php?newsID=" . $row["newsID"] . "'>" . $row["strFilename"] . "</a></td>";

						if($row["datePublished"] != "0000-00-00") {
							echo "<td>" . $row["datePublished"] . "</td>";
						}
						else {
							echo "<td>No date provided</td>";
						}

						echo "</tr>";
					}
			}
		?>

		</table>
	<?php } else {  // in this else I can make this page a landing page just gotta have two if statements one for missing results and no query given ?>

		<h3>No Results Found</h3>
		<p>Unfortunately, there were no results found for <span class='text text-error'><?php echo $term_list ?></span>. Please try again using the form below.</p>

		<form class="form-inline" action="searchResults.php" method="get" style="margin-bottom: 10px;">
        <div class="form-group">
		    <label for="search" class="sr-only">Password</label>
		    <input class="form-control" id="search" type="text" name="q" placeholder="Search Stories">
		</div>
		<button class="btn btn-default" type="submit" onClick="setConfirmUnload(false);" type="submit"><i class='fa fa-search'></i></button>
        </form>


		<p class="span5 muted"><span class="label label-info">Frustrated?</span> This only searches <strong>Filenames</strong>. If you have ways you would like to search that are not provided here, please contact the developer in charge of this database and let him or her know.</p>

	<?php } ?>

</div>
<?php

include_once("includes/footer.php");
?>
