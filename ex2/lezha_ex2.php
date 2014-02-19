<?php

	echo "<p>Course<p>";
	$h = "pearl.ils.unc.edu";
	$u = "webdb_17";
	$p = "wr3W48hs*M";
	$db = mysql_connect($h, $u, $p) or die ("Could not connect");
	mysql_select_db('webdb_17') or die ("Could not connect to db");
	$foo = "select * from courses order by instructor";
	$result = mysql_query($foo);
	echo "<table border='1px solid black'>";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){

		echo "<tr>";
		echo "<td>" . $row['semester'] . "</td><td>" . 
		$row['coursenum'] . "</td><td>" . 
		$row['sectionnum'] . "</td><td>" . 
		$row['title'] . "</td><td>" . 
		$row['instructor'] . "</td></tr>";

}

	echo "</table>";

?>
