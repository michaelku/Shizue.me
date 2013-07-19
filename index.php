<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<link rel="shortcut icon" href="favicon.ico">
		<title>Shizue.me - Animal Crossing: New Leaf Event and Villager Birthday Calendar</title>
		<meta name="description" content="Animal Crossing: New Leaf Event and Villager Birthday Calendar">
		<meta name="keywords" content="animal crossing, animal crossing new leaf, new leaf, shizue, isabelle, birthday, calendar, home, index">
		<meta http-equiv="content-type" content="text/html,charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 
		<?php require_once('php/load_css.php'); ?>
	</head>
	<body>
		<?php include_once("php/analyticstracking.php") ?>
		<div id = "shizue_head">
			<img class = "bell_1" src = "img/bell_01.png" alt = "Shizue Bell"><img class = "bell_2" src = "img/bell_02.png" alt = "Shizue Bell"><h1><a href = "/">Shizue.me</a></h1>
			<div id = "shizue_bell">
				<form action = "search" method = "GET">
					<input type = "text" name = "q" placeholder = "Search">
					<button type = "submit"><img src = "img/search.png" alt="Search" /></button>
				</form>
			</div>
		</div>
		<div id = "shizue_body">
			<div id = "shizue_shirt">
				<?php
					require_once('php/calendar.php');
				?>
			</div>
			<div id = "shizue_skirt">
				<ul id = "shizue_pantsu">
					<li class = "first"><a href = "?m=01">January</a></li>
					<li><a href = "/?m=02">February</a></li>
					<li><a href = "/?m=03">March</a></li>
					<li><a href = "/?m=04">April</a></li>
					<li><a href = "/?m=05">May</a></li>
					<li><a href = "/?m=06">June</a></li>
					<li><a href = "/?m=07">July</a></li>
					<li><a href = "/?m=08">August</a></li>
					<li><a href = "/?m=09">September</a></li>
					<li><a href = "/?m=10">October</a></li>
					<li><a href = "/?m=11">November</a></li>
					<li><a href = "/?m=12">December</a></li>
				</ul>
			</div>
			<?php require_once('php/footer_links.php'); ?>
		</div>
		<?php require_once('php/load_js.php'); ?>
	</body>
</html>