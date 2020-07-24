var admins = [];
var selectedAdminIndex = 0;

$(document).ready(function() {
	getAdmins();
});

function getAdmins() {
	$("#admins").find("*").remove();
	let fd = new FormData();
	fd.append("cmd", "SELECT * FROM `admins`");
	$.ajax({
		type: 'POST',
		url: PHP_URL+'/main/query',
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			admins = JSON.parse(response);
			for (let i=0; i<admins.length; i++) {
				let admin = admins[i];
				$("#admins").append("<tr>" +
					"                                        <th scope=\"row\">"+(i+1)+"</th>" +
					"                                        <td>"+admin['email']+"</td>" +
					"                                        <td>"+admin['password']+"</td>" +
					"                                        <td><button onclick='editAdmin("+i+")' class='btn-shadow p-1 btn btn-primary btn-sm show-toastr-example'>Ubah</button></td>" +
					"                                        <td><button onclick='confirmDeleteAdmin("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example' data-toggle='modal' data-target='#confirm'>Hapus</button></td>" +
					"                                    </tr>");
			}
		}
	});
}

function editAdmin(index) {
	window.location.href = "admin/edit?id="+admins[index]['id'];
}

function confirmDeleteAdmin(index) {
	selectedAdminIndex = index;
	$("#confirmLabel").html("Hapus Pengguna");
	$("#confirmBody").html("Apakah Anda yakin ingin menghapus pengguna ini?");
	$("#confirm").modal('show');
}

function deleteAdmin() {
	var adminID = admins[selectedAdminIndex]['id'];
	let fd = new FormData();
	fd.append("cmd", "DELETE FROM `admins` WHERE `id`="+adminID);
	$.ajax({
		type: 'POST',
		url: PHP_URL+'/main/execute',
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			getAdmins();
		}
	});
}
