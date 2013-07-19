$(document).ready(function(){
	var curr_date = new Date();
	var curr_day = curr_date.getDate();

	$('.now #'+curr_day).addClass('today');
});