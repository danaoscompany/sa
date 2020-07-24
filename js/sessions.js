var sessions = [];

$(document).ready(function() {
	getSessions();
});

function getSessions() {
	$.ajax({
		type: 'GET',
		url: PHP_URL+"/admin/get_sessions",
		dataType: 'text',
		cache: false,
		success: function(response) {
			sessions = JSON.parse(response);
			for (let i=0; i<sizeof(sessions); i++) {
				let session = sessions[i];
				$("#sessions").append("<tr>" +
					"                                        <th scope=\"row\">"+(i+1)+"</th>" +
					"                                        <td>"+session['user_name']+"</td>" +
					"                                        <td>"+session['session']+"</td>" +
					"                                        <td>"+session['date']+"</td>" +
					"                                        <td><button onclick='editUser("+i+")' class='btn-shadow p-1 btn btn-primary btn-sm show-toastr-example'>Ubah</button></td>" +
					"                                        <td><button onclick='confirmDeleteUser("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example' data-toggle='modal' data-target='#confirm'>Hapus</button></td>" +
					"                                    </tr>");
			}
		}
	});
}
