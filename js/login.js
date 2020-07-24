$(document).ready(function() {
});

function login() {
	let fd = new FormData();
	let email = $("#email").val().trim();
	let password = $("#password").val();
	if (email == "" || password == "") {
		alert("Please enter email and password");
		return;
	}
	fd.append("email", email);
	fd.append("password", password);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/admin/login",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			alert(response);
			let obj = JSON.parse(response);
			var responseCode = parseInt(obj['response_code']);
			if (responseCode == 1) {
				window.location.href = "user";
			} else if (responseCode == -1) {
				alert("The email or password you entered is incorrect.");
			}
		}
	});
}
