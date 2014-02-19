<html>
	<head><title>Result table for ex1</title>
	</head>
	<body>
		<h1>Result table for ex1</h1>
<?php
	echo "Hi, " . 
		htmlspecialchars(strip_tags($_POST['name']));
	echo "<br>";
	$max_num = $_POST["maxnum"];

?>
	<table>
<?php

	for ($i=1; $i<=$max_num;$i++){
		echo "<tr>";
		for ($j=1; $j<=$max_num; $j++){	
			echo "<td>";
			echo $j*$i;
			echo "</td>";
			
		 }

		echo "</tr>";
	}
	
	
?>
	</table>
	</body>
</html>
