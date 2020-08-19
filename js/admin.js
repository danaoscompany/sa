var admins = [];
var selectedAdminIndex = 0;
var currentRow = 0;
const ITEMS_PER_PAGE = 50;
var sortNameUp = false;
var sortRegistrationDateUp = false;
var currentPage = 0;

$(document).ready(function() {
	getAdmins();
	let userID = parseInt($("#admin-id").val());
	let fd = new FormData();
	fd.append("id", userID);
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

function getAdmins() {
	$("#admins").find("*").remove();
	$.ajax({
		type: 'GET',
		url: PHP_URL+'/admin/get',
		dataType: 'text',
		cache: false,
		success: function(response) {
			admins = JSON.parse(response);
			for (let i=0; i<admins.length/ITEMS_PER_PAGE; i++) {
				$("#pages").append("<li class=\"page-item\"><a href=\"javascript:goToPage("+i+")\" class=\"page-link\">"+(i+1)+"</a></li>");
			}
			displayAdmins(1);
		}
	});
}

function compareName(admin1, admin2) {
	var admin1Name = admin1['name'];
	var admin2Name = admin2['name'];
	if (sortNameUp) {
		return admin2Name.localeCompare(admin1Name);
	} else {
		return admin1Name.localeCompare(admin2Name);
	}
}

function compareRegistrationDate(admin1, admin2) {
	var admin1RegistrationDate = admin1['registration_date'];
	var admin2RegistrationDate = admin2['registration_date'];
	if (sortRegistrationDateUp) {
		return admin2RegistrationDate.localeCompare(admin1RegistrationDate);
	} else {
		return admin1RegistrationDate.localeCompare(admin2RegistrationDate);
	}
}

function displayAdmins(sortBy) {
	if (sortBy == 1) {
		admins.sort(compareName);
	}
	if (sortBy == 2) {
		admins.sort(compareRegistrationDate);
	}
	$("#admins").find("*").remove();
	for (let i=currentRow; i<currentRow+ITEMS_PER_PAGE; i++) {
		let admin = admins[i];
		let registrationDate = moment(admin['registration_date']).format('D MMMM YYYY hh:mm:ss');
		$("#admins").append("<tr>" +
			"                                        <th scope=\"row\">"+(i+1)+"</th>" +
			"                                        <td>"+admin['name']+"</td>" +
			"                                        <td>"+admin['email']+"</td>" +
			"                                        <td>"+admin['password']+"</td>" +
			"                                        <td>"+registrationDate+"</td>" +
			"                                        <td><button onclick='editAdmin("+i+")' class='btn-shadow p-1 btn btn-primary btn-sm show-toastr-example'>Edit</button></td>" +
			"                                        <td><button onclick='confirmDeleteAdmin("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example' data-toggle='modal' data-target='#confirm'>Delete</button></td>" +
			"                                    </tr>");
	}
}

function goToPage(page) {
	currentRow = page*ITEMS_PER_PAGE;
	displayAdmins(0);
}

function sortByName() {
	sortNameUp = !sortNameUp;
	if (sortNameUp) {
		$("#name-sort-icon").attr("src", "https://admin.skinmed.id/userdata/system/images/sort_up.png");
	} else {
		$("#name-sort-icon").attr("src", "https://admin.skinmed.id/userdata/system/images/sort_down.png");
	}
	displayAdmins(1);
}

function sortByRegistrationDate() {
	sortRegistrationDateUp = !sortRegistrationDateUp;
	if (sortRegistrationDateUp) {
		$("#registration-date-sort-icon").attr("src", "https://admin.skinmed.id/userdata/system/images/sort_up.png");
	} else {
		$("#registration-date-sort-icon").attr("src", "https://admin.skinmed.id/userdata/system/images/sort_down.png");
	}
	displayAdmins(2);
}

function editAdmin(index) {
	$.redirect("https://admin.skinmed.id/admin/edit", {
		'id': admins[index]['id']
	});
}

function confirmDeleteAdmin(index) {
	selectedAdminIndex = index;
	$("#confirmLabel").html("Delete Admin");
	$("#confirmBody").html("Are you sure you want to delete this admin?");
	$("#confirm").modal('show');
}

function deleteAdmin() {
	var adminID = admins[selectedAdminIndex]['id'];
	let fd = new FormData();
	fd.append("admin_id", adminID);
	$.ajax({
		type: 'POST',
		url: PHP_URL+'/admin/delete_by_id',
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			getAdmins();
		}
	});
}

function goToPrevPage() {
	if (currentPage > 0) {
		currentPage--;
		goToPage(currentPage);
	}
}

function goToNextPage() {
	var totalPages = Math.floor(admins.length/ITEMS_PER_PAGE);
	if ((admins.length%ITEMS_PER_PAGE) > 0) {
		totalPages++;
	}
	if (currentPage < totalPages-1) {
		currentPage++;
		goToPage(currentPage);
	}
}
