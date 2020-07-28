var patients = [];
var selectedPatientIndex = 0;
var userID = 0;

$(document).ready(function() {
	userID = parseInt($("#user-id").val());
	getPatients();
	let fd = new FormData();
	fd.append("cmd", "SELECT * FROM `admins` WHERE `id`="+userID);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/main/query",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			var obj = JSON.parse(response)[0];
			$("#admin-name").html(obj['name']);
			$("#admin-email").html(obj['email']);
		}
	});
});

function getPatients() {
	$("#patients").find("*").remove();
	let fd = new FormData();
	fd.append("cmd", "SELECT * FROM `patients` WHERE `user_id`="+userID+" ORDER BY `name`");
	$.ajax({
		type: 'POST',
		url: PHP_URL+'/main/query',
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			patients = JSON.parse(response);
			for (let i=0; i<patients.length; i++) {
				let patient = patients[i];
				$("#patients").append("<tr>" +
					"                                        <th scope=\"row\">"+(i+1)+"</th>" +
					"                                        <td>"+patient['name']+"</td>" +
					"                                        <td>"+patient['address']+"</td>" +
					"                                        <td>"+patient['city']+"</td>" +
					"                                        <td>"+patient['province']+"</td>" +
					"                                        <td>"+patient['birthday']+"</td>" +
					"                                        <td><button onclick='viewImages("+i+")' class='btn-shadow p-1 btn btn-primary btn-sm show-toastr-example'>Lihat</button></td>" +
					"                                        <td><button onclick='editPatient("+i+")' class='btn-shadow p-1 btn btn-primary btn-sm show-toastr-example'>Ubah</button></td>" +
					"                                        <td><button onclick='confirmDeletePatient("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example' data-toggle='modal' data-target='#confirm'>Hapus</button></td>" +
					"                                    </tr>");
			}
		}
	});
}

function viewImages(index) {
	window.location.href = "http://localhost/sa/image";
}

function viewDevices(index) {
	window.location.href = "http://localhost/sa/devices?id="+patients[index]['id'];
}

function viewPatients(index) {
	window.location.href = "http://localhost/sa/patients?id="+patients[index]['id'];
}

function editPatient(index) {
	window.location.href = "http://localhost/sa/patients/edit?id="+patients[index]['id']+"&uuid="+patients[index]['uuid'];
}

function confirmDeletePatient(index) {
	selectedPatientIndex = index;
	$("#confirmLabel").html("Hapus Pengguna");
	$("#confirmBody").html("Apakah Anda yakin ingin menghapus pengguna ini?");
	$("#confirm").modal('show');
}

function deletePatient() {
	var id = patients[selectedPatientIndex]['id'];
	let fd = new FormData();
	fd.append("cmd", "DELETE FROM `patients` WHERE `id`="+id);
	$.ajax({
		type: 'POST',
		url: PHP_URL+'/main/execute',
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			getPatients();
		}
	});
}

function logout() {
	$("#confirmLabel").html("Konfirmasi Log Out");
	$("#confirm-message").html("Apakah Anda yakin ingin log out?");
	$("#confirm-yes").on("click", function() {
		window.location.href = PHP_URL+"/admin/logout";
	});
}
