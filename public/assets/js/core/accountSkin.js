$(document).ready(function () {
	$.get('/skin', function (data) {
		$('#skinFilter').typeahead({source: data,});
	}, "json");
	$.get('/champion', function (data) {
		$('#champFilter').typeahead({source: data})
	}, "json");
});
