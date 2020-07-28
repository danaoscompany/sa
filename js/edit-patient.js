var userID = 0;
var uuid = "";

$(document).ready(function() {
	userID = parseInt($("#user-id").val().trim());
	uuid = $("#uuid").val().trim();
	let fd = new FormData();
	fd.append("uuid", uuid);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/patient/get_by_uuid"
	});
});

function save() {
	var name = $("#name").val().trim();
	var address = $("#address").val().trim();
	var city = $("#city").val().trim();
	var province = $("#province").val().trim();
	var birthday = $("#birthday").val().trim();
	if (name == "" || address == "" || city == "" || province == "" || birthday == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("uuid", uuid);
	fd.append("name", name);
	fd.append("address", address);
	fd.append("city", city);
	fd.append("province", province);
	fd.append("birthday", birthday);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/patients/edit_patient",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			window.location.href = "http://localhost/sa/patients?id="+userID;
		}
	});
}
