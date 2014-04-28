<?php

// connect to db
$h = "pearl.ils.unc.edu";
$u = "webdb_17";
$p = "zl08212377";
$db = mysql_connect($h, $u, $p) or die('Could not connect to database');
mysql_select_db("webdb_17") or die('Could not select database');

// initialize variables
$prefix;
$query;

// get prefix from user input
if (isset($_GET['prefix'])) {
	$prefix = htmlentities(strip_tags($_GET['prefix']));
}

// form query ane execute query
$query = "SELECT * FROM p4keywords WHERE keyword LIKE '%$prefix%'";
$result = mysql_query($query) or die ("Query to DB failed.\n");

// show results in table format
echo '<h2>Suggested keywords</h2>';
echo '<table id="suggestion-table" border="1px solid black" cellpadding=2>';

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	echo '<tr><td>' . $row['keyword'] . '</td></tr>';
}

echo '</table>';

mysql_close($db);
?>