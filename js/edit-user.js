var userID = 0;

$(document).ready(function() {
    var params = window.location.search;
    if (params.startsWith("?")) {
        params = params.substr(1, params.length);
    }
    userID = params.split("&")[0].split("=")[1];
    let fd = new FormData();
    fd.append("cmd", "SELECT * FROM `users` WHERE `id`="+userID);
    $.ajax({
        type: 'POST',
        url: PHP_URL+"/main/query",
        data: fd,
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
            var userInfo = JSON.parse(response)[0];
            $("#first-name").val(userInfo['first_name']);
            $("#last-name").val(userInfo['last_name']);
            $("#email").val(userInfo['email']);
            $("#phone").val(userInfo['phone']);
            $("#password").val(userInfo['password']);
            $("#address").val(userInfo['address']);
            $("#city").val(userInfo['city']);
            $("#province").val(userInfo['province']);
        }
    });
});

function save() {
    let firstName = $("#first-name").val().trim();
    let lastName = $("#last-name").val().trim();
    let email = $("#email").val().trim();
    let phone = $("#phone").val().trim();
    let password = $("#password").val().trim();
    let address = $("#address").val().trim();
    let city = $("#city").val().trim();
    let province = $("#province").val().trim();
    if (firstName == "" || lastName == "" || email == "" || phone == "" || password == "" || address == "" || city == "" || province == "") {
        alert("Mohon lengkapi data");
        return;
    }
    phone = phone.replace(/\D/g,'');
    if (phone.startsWith("0")) {
        phone = phone.substr(1, phone.length);
    }
    if (!phone.startsWith("62")) {
        phone = "62"+phone;
    }
    phone = "+"+phone;
    let fd = new FormData();
    fd.append("id", userID);
    fd.append("first_name", firstName);
    fd.append("last_name", lastName);
    fd.append("email", email);
    fd.append("phone", phone);
    fd.append("password", password);
    fd.append("address", address);
    fd.append("city", city);
    fd.append("province", province);
    $.ajax({
        type: 'POST',
        data: fd,
        url: PHP_URL+"/admin/edit_user",
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
            var obj = JSON.parse(response);
            var responseCode = parseInt(obj['response_code']);
            window.location.href = "user.html";
        }
    });
}