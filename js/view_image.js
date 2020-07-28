var uuid = "";

$(document).ready(function() {
	uuid = $("#uuid").val();
	let fd = new FormData();
	fd.append("uuid", uuid);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/image/get_by_uuid",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			var image = JSON.parse(response);
			$("#img-preview").attr("src", "http://localhost/sa/userdata/"+image['path']);
			var c = document.getElementById("cvs");
			var ctx = c.getContext("2d");
			var points = JSON.parse(image['points']);
			for (var i=0; i<points.length; i++) {
				var point = points[i];
				var x = parseInt(point['x']);
				var y = parseInt(point['y']);
				ctx.beginPath();
				ctx.arc(x/4, y/4, 5, 0, 2 * Math.PI, false);
				ctx.fillStyle = 'red';
				ctx.fill();
			}
		}
	});
});
