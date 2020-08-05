$(document).ready(function() {
	$("#premium").on("change", function() {
		var premiumIndex = $("#premium").prop('selectedIndex');
		if (premiumIndex == 1) {
			$("#premium-start-container").css("display", "block");
		} else {
			$("#premium-start-container").css("display", "none");
		}
	});
	/*$("#role").prop('selectedIndex', 1);
	$("#email").val("pengguna100@gmail.com");
	$("#password").val("HaloDunia123");
	$("#first-name").val("User");
	$("#last-name").val("Seratus");
	$("#phone").val("08198192892");
	$("#address").val("Address 100");
	$("#city").val("City 100");
	$("#province").val("Province 100");
	$("#company-name").val("Company Name 100");
	$("#company-city").val("Company City 100");
	$("#company-country").val("Company Country 100");
	$("#company-street").val("Company Street 100");
	$("#company-zip").val("Company ZIP 100");
	$("#company-state").val("Company State 100");
	$("#company-phone").val("Company Phone 100");*/
	var adminID = parseInt($("#admin-id").val().trim());
	let fd = new FormData();
	fd.append("id", adminID);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/admin/get_by_id",
		data: fd,
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
    fd.append("uuid", uuidv4());
    fd.append("is_admin", isAdmin);
    fd.append("premium", premium);
	fd.append("premium_start", premiumStart);
    fd.append("first_name", firstName);
    fd.append("last_name", lastName);
    fd.append("email", email);
    fd.append("phone", phone);
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
        url: PHP_URL+"/admin/add_user",
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
