var userID = 0;
var devices = [];
var selectedDeviceIndex = 0;

$(document).ready(function() {
	userID = parseInt($("#user-id").val().trim());
	getDevices();
});

function getDevices() {
	devices = [];
	$("#devices").find("*").remove();
	let fd = new FormData();
	fd.append("cmd", "SELECT * FROM `devices` WHERE `user_id`="+userID);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/main/query",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			devices = JSON.parse(response);
			for (var i=0; i<devices.length; i++) {
				var device = devices[i];
				$("#devices").append("<tr>" +
					"                                        <th scope=\"row\">"+(i+1)+"</th>" +
					"                                        <td>"+device['device']+"</td>" +
					"                                        <td>"+device['model']+"</td>" +
					"                                        <td>"+device['type']+"</td>" +
					"                                        <td><button onclick='editDevice("+i+")' class='btn-shadow p-1 btn btn-primary btn-sm show-toastr-example'>Ubah</button></td>" +
					"                                        <td><button onclick='confirmDeleteDevice("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example' data-toggle='modal' data-target='#confirm'>Hapus</button></td>" +
					"                                    </tr>");
			}
		}
	});
}

function editDevice(index) {
	window.location.href = "http://localhost/sa/devices/edit?uuid="+devices[index]['uuid']+"&id="+devices[index]['user_id'];
}

function confirmDeleteDevice(index) {
	selectedDeviceIndex = index;
	$("#confirmLabel").html("Hapus Perangkat");
	$("#confirmBody").html("Apakah Anda yakin ingin menghapus perangkat ini?");
	$("#confirm").modal('show');
}

function deleteDevice() {
	var uuid = devices[selectedDeviceIndex]['uuid'];
	let fd = new FormData();
	fd.append("cmd", "DELETE FROM `devices` WHERE `uuid`='"+uuid+"'");
	$.ajax({
		type: 'POST',
		url: PHP_URL+'/main/execute',
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			getDevices();
		}
	});
}
