var userID = 0;
var prevEmail = "";
var prevPhone = "";

$(document).ready(function() {
	$("#premium").on("change", function() {
		var premiumIndex = $("#premium").prop('selectedIndex');
		if (premiumIndex == 1) {
			$("#premium-start-container").css("display", "block");
		} else {
			$("#premium-start-container").css("display", "none");
		}
	});
	userID = parseInt($("#user-id").val().trim());
	let fd = new FormData();
	fd.append("id", userID);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/user/get_by_id",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			var user = JSON.parse(response);
			var isAdmin = parseInt(user['is_admin']);
			if (isAdmin == 0) {
				$("#role").prop('selectedIndex', 1);
			} else if (isAdmin == 1) {
				$("#role").prop('selectedIndex', 0);
			}
			var premium = parseInt(user['premium']);
			if (premium == 0) {
				$("#premium").prop('selectedIndex', 2);
				$("#premium-start-container").css("display", "none");
			} else if (premium == 1) {
				$("#premium").prop('selectedIndex', 1);
				$("#premium-start").val(user['premium_start']);
				$("#premium-start-container").css("display", "block");
			}
			prevEmail = user['email'];
			prevPhone = user['phone'];
			$("#email").val(prevEmail);
			$("#password").val(user['password']);
			$("#first-name").val(user['first_name']);
			$("#last-name").val(user['last_name']);
			$("#phone").val(prevPhone);
			$("#address").val(user['address']);
			$("#city").val(user['city']);
			$("#province").val(user['province']);
			$("#company-name").val(user['company_name']);
			$("#company-city").val(user['company_city']);
			$("#company-country").val(user['company_country']);
			$("#company-street").val(user['company_street']);
			$("#company-zip").val(user['company_zip_code']);
			$("#company-state").val(user['company_state']);
			$("#company-phone").val(user['company_phone']);
		}
	});
	var adminID = parseInt($("#admin-id").val().trim());
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

function addUser() {
	let roleIndex = $("#role").prop('selectedIndex');
	let premiumIndex = $("#premium").prop('selectedIndex');
	var premiumStart = $("#premium-start").val().trim();
	let email = $("#email").val().trim();
	let password = $("#password").val().trim();
	let firstName = $("#first-name").val().trim();
	let lastName = $("#last-name").val().trim();
	let phone = $("#phone").val().trim();
	let address = $("#address").val().trim();
	let city = $("#city").val().trim();
	let province = $("#province").val().trim();
	let companyName = $("#company-name").val().trim();
	let companyCity = $("#company-city").val().trim();
	let companyCountry = $("#company-country").val().trim();
	let companyStreet = $("#company-street").val().trim();
	let companyZIP = $("#company-zip").val().trim();
	let companyState = $("#company-state").val().trim();
	let companyPhone = $("#company-phone").val().trim();
	if (roleIndex == 0 || premiumIndex == 0 || firstName == "" || lastName == "" || email == "" || phone == ""
		|| password == "" || address == "" || city == "" || province == "" || companyName == "" || companyCity == ""
		|| companyCountry == "" || companyStreet == "" || companyZIP == "" || companyState == "" || companyPhone == "") {
		alert("Mohon lengkapi data");
		return;
	}
	var isAdmin = 0;
	if (roleIndex == 2) {
		isAdmin = 1;
	}
	phone = phone.replace(/\D/g,'');
	if (phone.startsWith("0")) {
		phone = phone.substr(1, phone.length);
	}
	if (!phone.startsWith("62")) {
		phone = "62"+phone;
	}
	phone = "+"+phone;
	var premium = 0;
	if (premiumIndex == 1) {
		premium = 1;
	}
	let fd = new FormData();
	fd.append("id", userID);
	fd.append("uuid", uuidv4());
	fd.append("is_admin", isAdmin);
	fd.append("premium", premium);
	fd.append("premium_start", premiumStart);
	fd.append("first_name", firstName);
	fd.append("last_name", lastName);
	fd.append("email", email);
	fd.append("phone", phone);
	if (prevEmail != email) {
		fd.append("email_changed", 1);
	} else {
		fd.append("email_changed", 0);
	}
	if (prevPhone != phone) {
		fd.append("phone_changed", 1);
	} else {
		fd.append("phone_changed", 0);
	}
	fd.append("password", password);
	fd.append("address", address);
	fd.append("city", city);
	fd.append("province", province);
	fd.append("company_name", companyName);
	fd.append("company_city", companyCity);
	fd.append("company_country", companyCountry);
	fd.append("company_street", companyStreet);
	fd.append("company_zip", companyZIP);
	fd.append("company_state", companyState);
	fd.append("company_phone", companyPhone);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/admin/update_user",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			var obj = JSON.parse(response);
			var responseCode = parseInt(obj['response_code']);
			if (responseCode == -1) {
				alert("Email sudah ditambahkan");
			} else if (responseCode == -2) {
				alert("Nomor HP sudah ditambahkan");
			} else {
				window.history.back();
			}
		}
	});
}

function cancelEditing() {
	window.history.back();
}
