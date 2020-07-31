var userID = 0;

$(document).ready(function() {
	userID = parseInt($("#user-id").val().trim());
});

function addDevice() {
	var device = $("#device").val().trim();
	var model = $("#model").val().trim();
	var type = $("#type").val().trim();
	if (device == "" || model == "" || type == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("user_id", userID);
	fd.append("uuid", uuidv4());
	fd.append("device", device);
	fd.append("model", model);
	fd.append("type", type);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/devices/add_device",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			window.location.href = "http://skinmed.id/sa/devices?id="+userID;
		}
	});
}
