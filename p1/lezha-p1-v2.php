<?php	
	date_default_timezone_set('UTC');
	$stardate = '12-Jun-04';
	echo strtotime($stardate), "\n";	

	$lines = file("data-p1.txt");
	$output = array();

	foreach ($lines as $line) {
		$line = trim($line);
		$fields = explode(",", $line);
		
		$rating = $fields[5];
		$lname = $fields[1];
		//echo "lname: " . $lname[0] . "\n";
		//preg_match('/[a-mA-M]/',$lname[0],$matches);
		//echo "matches: " . $matches[0] . "\n";
		

		if ($rating == "good" || $rating == "excellent") {
			if (preg_match('/[a-mA-M]/',$lname[0]) === 1) {
				$new_date = date("F j, Y", strtotime($fields[2]));
				$output[$fields[1]] = $new_date;
			} 		
		}		
				
	}
	
	ksort($output);
	foreach ($output as $name => $date_and_time) {
		echo "$name\t$date_and_time\n";
	}


?>
