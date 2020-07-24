$(document).ready(function() {
});

function addAdmin() {
	let email = $("#email").val().trim();
	let password = $("#password").val().trim();
	if (email == "" || password == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let fd = new FormData();
	fd.append("email", email);
	fd.append("password", password);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/admin/add_admin",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			var obj = JSON.parse(response);
			var responseCode = parseInt(obj['response_code']);
			if (responseCode == -1) {
				alert("Admin sudah ditambahkan");
			} else {
				window.location.href = ".";
			}
		}
	});
}
