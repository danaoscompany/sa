var id = 0;
var emailChanged = 0;
var prevEmail = "";

$(document).ready(function() {
	id = parseInt($("#admin-id").val());
	let fd = new FormData();
	fd.append("cmd", "SELECT * FROM `admins` WHERE `id`="+id);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/main/query",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			var obj = JSON.parse(response)[0];
			prevEmail = obj['email'];
			$("#email").val(obj['email']);
			$("#password").val(obj['password']);
		}
	});
});

function save() {
	let email = $("#email").val().trim();
	let password = $("#password").val().trim();
	if (email == "" || password == "") {
		alert("Mohon lengkapi data");
		return;
	}
	if (email != prevEmail) {
		emailChanged = 1;
	}
	let fd = new FormData();
	fd.append("id", id);
	fd.append("email", email);
	fd.append("password", password);
	fd.append("email_changed", emailChanged);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/admin/edit_admin",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			var responseCode = parseInt(response);
			if (responseCode == 1) {
				window.location.href = "index";
			}
		}
	});
}
