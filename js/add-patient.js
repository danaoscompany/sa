var userID = 0;

$(document).ready(function() {
	userID = parseInt($("#user-id").val().trim());
});

function addPatient() {
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
	fd.append("user_id", userID);
	fd.append("uuid", uuidv4());
	fd.append("name", name);
	fd.append("address", address);
	fd.append("city", city);
	fd.append("province", province);
	fd.append("birthday", birthday);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/patients/add_patient",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			alert(response);
			window.location.href = "http://skinmed.id/sa/patients?id="+userID;
		}
	});
}
