$(document).ready(function() {
});

function addUser() {
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
        url: PHP_URL+"/admin/add_user",
        data: fd,
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
            var obj = JSON.parse(response);
            var responseCode = parseInt(obj['response_code']);
            if (responseCode == -1) {
                alert("Pengguna sudah ditambahkan");
            } else {
                window.location.href = "user.html";
            }
        }
    });
}