var uuid = "";
var userID = 0;

$(document).ready(function() {
	userID = parseInt($("#user-id").val().trim());
	uuid = $("#uuid").val().trim();
	let fd = new FormData();
	fd.append("cmd", "SELECT * FROM `devices` WHERE `uuid`='"+uuid+"'");
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/main/query",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			var deviceInfo = JSON.parse(response)[0];
			$("#device").val(deviceInfo['device']);
			$("#model").val(deviceInfo['model']);
			$("#type").val(deviceInfo['type']);
		}
	});
});

function save() {
	var device = $("#device").val().trim();
	var model = $("#model").val().trim();
	var type = $("#type").val().trim();
	if (device == "" || model == "" || type == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("uuid", uuid);
	fd.append("device", device);
	fd.append("model", model);
	fd.append("type", type);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/devices/edit_device",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			$.redirect("http://localhost/sa/devices", {
				id: userID
			});
		}
	});
}
