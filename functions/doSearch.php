	<?php
session_start();
include_once('../includes/db.php'); //includes db connection



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



	$term_list = search_pretty_terms(search_html_escape_terms(search_split_terms($_GET["q"])));
//	echo $term_list;

	$terms = search_split_terms($_GET["q"]);

	$parts = array();
	foreach($terms as $term){
		if($term != "and") {
			$parts[] = "strHeadline RLIKE '$term'";
		}
	}
	
	$parts = implode(' AND ', $parts);
	$sql = "SELECT * FROM tblNews WHERE $parts";
	$result = mysql_query($sql) or die(mysql_error());
		
	while($rows = mysql_fetch_array($result))
	{
		echo $rows["strHeadline"] . "<--";

	}





/*

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

	function search_transform_term($term){
		$term = preg_replace("/(\s)/e", "'{WHITESPACE-'.ord('\$1').'}'", $term);
		$term = preg_replace("/,/", "{COMMA}", $term);
		return $term;
	}

	function search_escape_rlike($string){
		return preg_replace("/([.\[\]*^\$])/", '\\\$1', $string);
	}

	function search_db_escape_terms($terms){
		$out = array();
		foreach($terms as $term){
			$out[] = '[[:<:]]'.AddSlashes(search_escape_rlike($term)).'[[:>:]]';
		}
		return $out;
	}

	function search_perform($terms){

		$terms = search_split_terms($terms);
		$terms_db = search_db_escape_terms($terms);
		$terms_rx = search_rx_escape_terms($terms);

		$parts = array();
		foreach($terms as $term){
			if($term != "and") {
				$parts[] = "strHeadline RLIKE '$term'";
			}
		}
		$parts = implode(' AND ', $parts);
		
		$sql = "SELECT * FROM tblNews WHERE $parts";
	
		$result = mysql_query($sql);
		$rows = mysql_fetch_array($result);


	/*	while($row = mysql_fetch_array($result, MYSQL_ASSOC)){

			$row[score] = 0;

			foreach($terms_rx as $term_rx){
				$row[score] += preg_match_all("/$term_rx/i", $row[strHeadline], $null);
			}

		}

		uasort($rows, 'search_sort_results');
		echo $rows["strHeadline"];

		return $rows;

	}

	function search_rx_escape_terms($terms){
		$out = array();
		foreach($terms as $term){
			$out[] = '\b'.preg_quote($term, '/').'\b';
		}
		return $out;
	}

	function search_sort_results($a, $b){

		$ax = $a[score];
		$bx = $b[score];

		if ($ax == $bx){ return 0; }
		return ($ax > $bx) ? -1 : 1;
	}



	function search_pretty_terms($terms_html){

		if (count($terms_html) == 1){
			return array_pop($terms_html);
		}

		$last = array_pop($terms_html);

		return implode(', ', $terms_html)." and $last";
	}


	$term_list = search_pretty_terms(search_html_escape_terms(search_split_terms($_GET["q"])));

	$results = search_perform($term_list);
	echo $results["strHeadline"] . "<--";

*/
?>