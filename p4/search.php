<?php

// connect to db
$h = "pearl.ils.unc.edu";
$u = "webdb_17";
$p = "zl08212377";
$db = mysql_connect($h, $u, $p) or die('Could not connect to database');
mysql_select_db("webdb_17") or die('Could not select database');

// initialize variables
$where_sql = "WHERE ";
$print_sql_array = array();
$sql;
$sortby = "videoid";
$url;

// get user input
if (isset($_GET['sortby'])) {
	$sortby = $_GET['sortby'];
}

if (isset($_GET['title'])) {
	$print_sql_array['title'] = strsafe($_GET['title']);
	if ($_GET['title'] != "") {
		$where_sql = $where_sql . "title LIKE '%" . 
						strsafe($_GET['title']) . "%' and ";
	}
	$url = $url . "title=" . strsafe($_GET['title']) . "&";
}

if (isset($_GET['keywords'])) {
	$print_sql_array['keywords'] = strsafe($_GET['keywords']);
	if ($_GET['keywords'] != "") {
		$where_sql = $where_sql . "keywords LIKE '%" . 
						strsafe($_GET['keywords']) . "%' and ";
	}
	$url = $url . "keywords=" . strsafe($_GET['keywords']) . "&";
}

if (isset($_GET['tdk_fulltext'])) {
	$print_sql_array['tdk_fulltext'] = strsafe($_GET['tdk_fulltext']);
	if ($_GET['tdk_fulltext'] != "") {
	$where_sql = $where_sql . "MATCH (title, description, keywords) " . 
							"AGAINST ('" . strsafe($_GET['tdk_fulltext']) . "') and ";
	}
	$url = $url . "tdk_fulltext=" . strsafe($_GET['tdk_fulltext']) . "&";	
}

if (isset($_GET['start_year'])) {
	$print_sql_array['start_year'] = strsafe($_GET['start_year']);
	if ($_GET['start_year'] != "") {
		$where_sql = $where_sql . "creationyear >= '" . 
						strsafe($_GET['start_year']) . "' and ";
	}	
	$url = $url . "start_year=" . strsafe($_GET['start_year']) . "&";
}

if (isset($_GET['end_year'])) {
	$print_sql_array['end_year'] = strsafe($_GET['end_year']);
	if ($_GET['end_year'] != "") {
		$where_sql = $where_sql . "creationyear <= '" . 
						strsafe($_GET['start_year']) . "' and ";
	}
	$url = $url . "end_year" . strsafe($_GET['start_year']) . "&";
}

if (isset($_GET['min_sec'])) {
	$print_sql_array['min_sec'] = strsafe($_GET['min_sec']);
	if ($_GET['min_sec'] != "") {
		$where_sql = $where_sql . "durationsec >= '" . 
						strsafe($_GET['min_sec']) . "' and ";
	}
	$url = $url . "min_sec" . strsafe($_GET['min_sec']) . "&";
}

if (isset($_GET['max_sec'])) {
	$print_sql_array['max_sec'] = strsafe($_GET['max_sec']);
	if ($_GET['max_sec'] != "") {
		$where_sql = $where_sql . "durationsec <= '" . 
						strsafe($_GET['max_sec']) . "' and ";
	}
	$url = $url . "max_sec" . strsafe($_GET['max_sec']) . "&";
}

if (isset($_GET['sound'])) {
	$print_sql_array['sound'] = "yes";
	$where_sql = $where_sql . "sound = 'yes' and ";
	$url = $url . "sound=yes&";
} 

if (isset($_GET['color'])) {
	$print_sql_array['color'] = "yes";
	$where_sql = $where_sql . "color = 'yes' and ";
	$url = $url . "color=yes&";
} 


// display sql query and url
$where_sql = substr($where_sql, 0, -5);
//echo "where clause: $where_sql;\n";
$sql = "SELECT * FROM p4records " . $where_sql . " ORDER BY " . $sortby;
//echo "sql: $sql;\n";
//echo "url: $url" . "sortby=$sortby;\n";


// display user query
echo "<h2> Your search criteria: </h2><p>";	
echo "<table>";
foreach ($print_sql_array as $key => $val) {
	echo "<tr><td>$key:&nbsp;</td><td>$val</td></tr>";
}
echo "</table>";	
echo "<p>";	
echo "<a href='search.html'> Go Back</a>";	

// conduct search against data in MySQL and show the results
// table header
echo "<div id='result_table'><h2>Results</h2>";
echo "<table border=1 cellpadding=2 width='100%'><tbody>";
echo "<tr><td><a href='search.php?$url" . "sortby=videoid'>Videoid</a></td>
		<td><a href='search.php?$url" . "sortby=title'>Title</a></td>
		<td><a href='search.php?$url" . "sortby=creationyear'>Year</a></td>
		<td><a href='search.php?$url" . "sortby=sound'>Sound</a></td>
		<td><a href='search.php?$url" . "sortby=color'>Color</a></td>
		<td><a href='search.php?$url" . "sortby=duration'>Duration</a></td>
		<td><a href='search.php?$url" . "sortby=genre'>Genre</a></td></tr>";

// show results in table format
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	echo "<tr><td><a href='http://www.open-video.org/details.php?videoid=" 
			. $row['videoid'] . "'>" . $row['videoid'] . "</a></td><td>" 
			. $row['title'] . "</td><td>" . $row['creationyear'] . "</td><td>" 
			. $row['sound'] . "</td><td>" . $row['color'] . "</td><td>" 
			. $row['duration'] . "</td><td>" . $row['genre'] . "</td></tr>";

}
echo "</tbody></table></div>";

mysql_close($db);

function strsafe($str) {
	$retstr = htmlentities(strip_tags($str));
	if (!get_magic_quotes_gpc()) {
		$retstr = addslashes($retstr);
	}
	return $retstr;
}
?>