$(document).ready(function(){
	var curr_date = new Date();
	var curr_day = curr_date.getDate();
	
	var curr_month = $('#calendar').attr('class');
	var prev_month = curr_month-1;
	var next_month = prev_month+2;

	$('.now #'+curr_day).addClass('today');

	$(document).on('click', 'a#prev', function(e){
		e.preventDefault();

		$.ajax({
			type: "GET",
			url: "php/calendar.php",
			data: {m: leadingZero(prev_month)}
		})
		.done(function(results){
			$('#calendar').html(results);
			prev_month--;
			curr_month--;
			next_month--;
			window.history.pushState("object or string", "Waifu", "/?m="+leadingZero(curr_month));
			$('.now #'+curr_day).addClass('today');
		})
	});

	$(document).on('click', 'a#next', function(e){
		e.preventDefault();

		$.ajax({
			type: "GET",
			url: "php/calendar.php",
			data: {m: leadingZero(next_month)}
		})
		.done(function(results){
			$('#calendar').html(results);
			prev_month++;
			curr_month++;
			next_month++;
			window.history.pushState("object or string", "Waifu", "/?m="+leadingZero(curr_month));
			$('.now #'+curr_day).addClass('today');
		})
	});
});

function leadingZero(month){
	if(month < 10){
		month = '0' + month;
	}
	return month;
}