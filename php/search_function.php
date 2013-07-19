<?php
	require_once('connection.php');

	if(isset($_GET['q'])){
		$query = mysqli_real_escape_string($bd_mysqli, $_GET['q']);
		$query_length = strlen($query);

		if(empty($query) || ctype_space($query) || ctype_punct($query) || $query_length < 2){
			print "<h2>Invalid search query:</h2>";

		if(empty($query) || ctype_space($query)){
				print "<p>Search query is empty.";
			}
			else if(ctype_punct($query)){
				print "<p>Search query contains no alphanumeric characters.";
			}
			else if($query_length < 2){
				print "<p>Search query needs to be longer than 1 character.";
			}
			else{
				print "<p>Unknown error.";
			}
			print " Please try again.</p>";
		}

		else{
			$query_split = explode(' ', $query);

			$db_search_query_01 = "
				SELECT * FROM cal_events WHERE event_name LIKE '%$query%'
			";

			foreach($query_split as $query_item){
				$search_term = $query_item;
				$search_query = "OR event_name LIKE '%$search_term%'";
				$db_search_query = $db_search_query_01." ".$search_query;
			}

			//echo $db_search_query;

			if ($bd_mysqli->connect_error) {
	    		die('Connect Error (' . $bd_mysqli->connect_errno . ') '. $bd_mysqli->connect_error);
			}

			if ($bd_result = $bd_mysqli->query($db_search_query)) {

				$row_count = $bd_result->num_rows;
				if($row_count < 1){
	    			print "
	    				<h2>Search results for '$query' under events:</h2>
	    				<p>No results. Please try again.</p>
	    			";
				}

				else{
					print "
						<h2>Search results for '$query' under events:</h2>
						<table>
					";
		    		while ($bd_event = $bd_result->fetch_object()) {
		    			$event_id = $bd_event->id;
		    			$event_name = $bd_event->event_name;
		    			$event_month = $bd_event->event_month;
		    			$event_day = $bd_event->event_day;

		    			print "
		    				<tr>
		    					<td>
		    			";

		    			if($event_month < 10){
		    				print "0";
		    			}

		    			print "$event_month/";
		    			
		    			if($event_day < 10){
		    				print "0";
		    			}

		    			print "$event_day</td>
		    					<td>$event_name</td></td>
		    				</tr>
		    			";
		    		}
		    		print "</table>";
		    	}
	    	}

			$db_search_query_02 = "
				SELECT * FROM cal_birthdays WHERE villager_name LIKE '%$query%'
			";

			foreach($query_split as $query_item){
				$search_term = $query_item;
				$search_query = "OR villager_name LIKE '%$search_term%'";
				$db_search_query = $db_search_query_02." ".$search_query;
			}

			if ($bd_mysqli->connect_error) {
	    		die('Connect Error (' . $bd_mysqli->connect_errno . ') '. $bd_mysqli->connect_error);
			}

			if ($bd_result = $bd_mysqli->query($db_search_query)) {

				$row_count = $bd_result->num_rows;
				if($row_count < 1){
	    			print "
	    				<h2>Search results for '$query' under birthdays:</h2>
	    				<p>No results. Please try again.</p>
	    			";
				}

				else{
					print "
						<h2>Search results for '$query' under birthdays:</h2>
						<table>
					";
		    		while ($bd_villager = $bd_result->fetch_object()) {
		    			$villager_id = $bd_villager->id;
		    			$villager_name = $bd_villager->villager_name;
		    			$villager_month = $bd_villager->villager_month;
		    			$villager_day = $bd_villager->villager_day;

		    			print "
		    				<tr>
		    					<td>
		    			";

		    			if($villager_month < 10){
		    				print "0";
		    			}
		    			
		    			print "$villager_month/";

		    			if($villager_day < 10){
		    				print "0";
		    			}

		    			print "$villager_day</td>
		    					<td>$villager_name's Birthday</td></td>
		    				</tr>
		    			";
		    		}
		    		print "</table>";
		    	}
	    	}
	    }
	}
	else{
		header( 'Location: /' );
	}

	$bd_mysqli->close();
?>