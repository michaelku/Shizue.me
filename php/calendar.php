<?php	
	require_once('connection.php');

/***********************************/
/* STEP #1: INITIAL CALENDAR PRINT */
/***********************************/

	//If a specific month is searched
	if(isset($_GET['m'])){
		$temp_month = mysqli_real_escape_string($bd_mysqli, $_GET['m']);

		//Checks that month is digit-only
		if(ctype_digit($temp_month)){
			if($temp_month > 12 || $temp_month < 01){
				$curr_month = date("m");
			}
			else{
				$curr_month = $temp_month;
			}
		}
		//If not, default to current month
		else{
			$curr_month = date("m");
		}
	}
	//If no month is given, default to current month
	else{
		$curr_month = date("m");
	}

	$realtime_month = date("m");

	//Calculate date information based on month given above
	$curr_month_written = date("F", mktime(0, 0, 0, $curr_month, 1, 2013));
	$curr_year = date("Y");
	$max_days = cal_days_in_month(CAL_GREGORIAN, $curr_month, $curr_year);
	$start_day = date("N", mktime(0, 0, 0, $curr_month, 1, $curr_year));
	$end_day = date("N", mktime(0, 0, 0, $curr_month, $max_days, $curr_year));

	/* STEP #1a: DATABASE CONNECTION */
	/*********************************/
	/*********************************/
	$db_event_query = "SELECT * FROM cal_events WHERE event_month = $curr_month";
	
	if ($bd_mysqli->connect_error) {
    	die('Connect Error (' . $bd_mysqli->connect_errno . ') '. $bd_mysqli->connect_error);
	}

	if ($bd_result = $bd_mysqli->query($db_event_query)) {
    	while ($bd_event = $bd_result->fetch_object()) {
    		$event_id = $bd_event->id;
    		$event_name = $bd_event->event_name;
    		$event_date = $bd_event->event_day;

    		$event_array = array(
    			"id" => "$event_id",
    			"name" => "$event_name",
    			"date" => "$event_date",
    			"type" => "event"
    		);

    		if(isset($$event_date)){
    			array_push($$event_date, $event_array);
    		}
    		else{
    			$$event_date = array();
    			array_push($$event_date, $event_array);
    		}
    	}

	    $bd_result->close();
	}

	$db_birthday_query = "SELECT * FROM cal_birthdays WHERE villager_month = $curr_month";
	
	if ($bd_mysqli->connect_error) {
    	die('Connect Error (' . $bd_mysqli->connect_errno . ') '. $bd_mysqli->connect_error);
	}

	if ($bd_result = $bd_mysqli->query($db_birthday_query)) {
    	while ($bd_character = $bd_result->fetch_object()) {
    		$villager_id = $bd_character->id;
    		$villager_name = $bd_character->villager_name;
    		$villager_date = $bd_character->villager_day;

    		$villager_array = array(
    			"id" => "$villager_id",
    			"name" => "$villager_name",
    			"date" => "$villager_date",
    			"type" => "birthday"
    		);

    		if(isset($$villager_date)){
    			array_push($$villager_date, $villager_array);
    		}
    		else{
    			$$villager_date = array();
    			array_push($$villager_date, $villager_array);
    		}
    	}

	    $bd_result->close();
	}

	$bd_mysqli->close();

	/***************************/
	/* STEP #1: PRINT CALENDAR */
	/***************************/
	$prev_month = sprintf('%02d', $curr_month-1);
	$next_month = sprintf('%02d', $curr_month+1);
	print "
		<table id = 'calendar' class = '$curr_month'>
			<tr id = 'month_nav'>
				<td id = 'month' colspan = '7'>
					<ul>
						<li class = 'left'>
	";

	if($curr_month != 1){
		print "<a id = 'prev' href = '/?m=$prev_month'>&laquo;</a>";
	}

	print "
		</li>
		<li class = 'mid'>$curr_month_written</li>
		<li class = 'right'>
	";
	
	if($curr_month != 12){
		print "<a id = 'next' href = '/?m=$next_month'>&raquo;</a>";
	}

	print "
						</li>
					</ul>
				</td>
			</tr>
			<tr id = 'days'>
				<td class = 'day'>Sunday</td>
				<td class = 'day'>Monday</td>
				<td class = 'day'>Tuesday</td>
				<td class = 'day'>Wednesday</td>
				<td class = 'day'>Thursday</td>
				<td class = 'day'>Friday</td>
				<td class = 'day'>Saturday</td>
			</tr>
	";

	if($curr_month == $realtime_month){
		print "<tr class = 'now'>";
	}
	else{
		print "<tr>";
	}


	$day_count = 0;
	$alt_count = 0;

	//Pre-date Spacing
	if($start_day != 7){
		for($i = 0; $i < $start_day; $i++){
			if($alt_count == 0){
				print "<td class = 'dark blank'></td>";
				$alt_count++;
			}

			else{
				print "<td class = 'light blank'></td>";
				$alt_count--;
			}
		}
		$day_count = $start_day;
	}

	//Dates
	for($date_count = 1; $date_count < $max_days+1; $date_count++){
		$day_count++;
		
		print "<td id = '$date_count' class = 'date ";

		if($alt_count == 0){
			print "dark ";
			$alt_count++;
		}

		else{
			print "light ";
			$alt_count--;
		}
		print "'>";

		print "<div class = 'num'>$date_count</div>";
		
		//Check for birthdays
		if(isset($$date_count)){
			print "<ul>";

			foreach ($$date_count as $villager) {
				$id = $villager['id'];
				$name = $villager['name'];
				$date = $villager['date'];
				$type = $villager['type'];

				if($type == "event"){
					print "<li><img src = 'img/event.png' alt = 'Event'> $name </li>";
				}

				else if($type == "birthday"){
					print "<li><img src = 'img/present.png' alt = 'Birthday'>".$name."'s Birthday</li>";
				}
			}

			print "</ul>";
		}

		print "</td>";



		if($day_count > 6 && $date_count != $max_days){
			$day_count = 0;
			print "</tr>";
			
			if($curr_month == $realtime_month){
				print "<tr class = 'now'>";
			}
			else{
				print "<tr>";
			}
		}
	}

	//Post-date Spacing
	if($end_day != 6){
		
		if($end_day == 7){
			$remaining_days = 6;
		}
		else{
			$remaining_days = 6 - $end_day;
		}

		for($i = 0; $i < $remaining_days; $i++){
			if($alt_count == 0){
				print "<td class = 'dark blank'></td>";
				$alt_count++;
			}

			else{
				print "<td class = 'light blank'></td>";
				$alt_count--;
			}
		}
		$day_count = $start_day;
	}

	print "</tr></table>";
?>