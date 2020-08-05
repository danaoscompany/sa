var editedAdminID = 0;
var emailChanged = 0;
var prevEmail = "";

$(document).ready(function() {
	editedAdminID = parseInt($("#edited-admin-id").val());
	let fd = new FormData();
	fd.append("id", editedAdminID);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/admin/get_by_id",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			var obj = JSON.parse(response);
			prevEmail = obj['email'];
			$("#name").val(obj['name']);
			$("#email").val(obj['email']);
			$("#password").val(obj['password']);
		}
	});
	let adminID = parseInt($("#admin-id").val());
	let fd2 = new FormData();
	fd2.append("id", adminID);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/admin/get_by_id",
		data: fd2,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			var obj = JSON.parse(response);
			$("#admin-name").html(obj['name']);
			$("#admin-email").html(obj['email']);
		}
	});
});

function save() {
	let name = $("#name").val().trim();
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
	fd.append("id", editedAdminID);
	fd.append("name", name);
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

function cancelEditing() {
	window.history.back();
}
