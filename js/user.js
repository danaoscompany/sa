var users = [];
var selectedUserIndex = 0;
var currentRow = 0;
var sortNameUp = false;
var sortRegistrationDateUp = false;
const ITEMS_PER_PAGE = 50;
var currentPage = 0;

$(document).ready(function() {
    getUsers();
    let userID = parseInt($("#admin-id").val());
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

function getUsers() {
    $("#users").find("*").remove();
    let fd = new FormData();
    fd.append("cmd", "SELECT * FROM `users` ORDER BY `first_name`");
    $.ajax({
        type: 'POST',
        url: PHP_URL+'/main/query',
        data: fd,
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
            users = JSON.parse(response);
            for (let i=0; i<users.length/ITEMS_PER_PAGE; i++) {
            	$("#pages").append("<li class=\"page-item\"><a href=\"javascript:goToPage("+i+")\" class=\"page-link\">"+(i+1)+"</a></li>");
			}
			displayUsers(1);
        }
    });
}

function compareName(user1, user2) {
	var user1Name = user1['first_name']+' '+user1['last_name'];
	var user2Name = user2['first_name']+' '+user2['last_name'];
	if (sortNameUp) {
		return user2Name.localeCompare(user1Name);
	} else {
		return user1Name.localeCompare(user2Name);
	}
}

function compareRegistrationDate(user1, user2) {
	var user1RegistrationDate = user1['registration_date'];
	var user2RegistrationDate = user2['registration_date'];
	if (sortRegistrationDateUp) {
		return user2RegistrationDate.localeCompare(user1RegistrationDate);
	} else {
		return user1RegistrationDate.localeCompare(user2RegistrationDate);
	}
}

function displayUsers(sortBy) {
	if (sortBy == 1) {
		users.sort(compareName);
	}
	if (sortBy == 2) {
		users.sort(compareRegistrationDate);
	}
	$("#users").find("*").remove();
	for (let i=currentRow; i<currentRow+ITEMS_PER_PAGE; i++) {
		let user = users[i];
		let name = user['first_name'] + " " + user['last_name'];
		var premium = parseInt(user['premium']);
		var registrationDate = moment(user['registration_date']).format("D MMMM YYYY");
		if (premium == 0) {
			premium = "No";
		} else if (premium == 1) {
			var premiumStart = user['premium_start'];
			premiumStart = moment(premiumStart, "yyyy-MM-dd HH:mm:ss").valueOf();
			premiumStart += 30*24*60*60*1000;
			premium = "Until "+moment(premiumStart).format("d MMMM yyyy");
		}
		$("#users").append("<tr>" +
			"                                        <th scope=\"row\">"+(i+1)+"</th>" +
			"                                        <td>"+name+"</td>" +
			"                                        <td>"+user['email']+"</td>" +
			"                                        <td>"+user['password']+"</td>" +
			"                                        <td>"+premium+"</td>" +
			"                                        <td>"+registrationDate+"</td>" +
			"                                        <td><button onclick='viewDevices("+i+")' class='btn-shadow p-1 btn btn-primary btn-sm show-toastr-example'>View</button></td>" +
			"                                        <td><button onclick='viewPatients("+i+")' class='btn-shadow p-1 btn btn-primary btn-sm show-toastr-example'>View</button></td>" +
			"                                        <td><button onclick='editUser("+i+")' class='btn-shadow p-1 btn btn-primary btn-sm show-toastr-example'>Edit</button></td>" +
			"                                        <td><button onclick='confirmDeleteUser("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example' data-toggle='modal' data-target='#confirm'>Delete</button></td>" +
			"                                    </tr>");
	}
}

function viewDevices(index) {
	var user = users[index];
	$.redirect("https://admin.skinmed.id/devices", {
		id: parseInt(user['id'])
	});
}

function viewPatients(index) {
	var user = users[index];
	$.redirect("https://admin.skinmed.id/patients", {
		id: parseInt(user['id'])
	});
}

function editUser(index) {
	var user = users[index];
	$.redirect("https://admin.skinmed.id/user/edit", {
		'user_id': parseInt(user['id'])
	});
}

function confirmDeleteUser(index) {
    selectedUserIndex = index;
    $("#confirmLabel").html("Delete User");
    $("#confirmBody").html("Are you sure you want to delete this user?");
    $("#confirm").modal('show');
}

function deleteUser() {
    var userID = users[selectedUserIndex]['id'];
    let fd = new FormData();
    fd.append("cmd", "DELETE FROM `users` WHERE `id`="+userID);
    $.ajax({
        type: 'POST',
        url: PHP_URL+'/main/execute',
        data: fd,
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
            getUsers();
        }
    });
}

function logout() {
	$("#confirmLabel").html("Konfirmasi Log Out");
	$("#confirm-message").html("Are you sure you want to logout?");
	$("#confirm-yes").on("click", function() {
		window.location.href = PHP_URL+"/admin/logout";
	});
}

function goToPage(page) {
	currentPage = page;
	currentRow = page*ITEMS_PER_PAGE;
	displayUsers(0);
}

function sortByName() {
	sortNameUp = !sortNameUp;
	if (sortNameUp) {
		$("#name-sort-icon").attr("src", "https://admin.skinmed.id/userdata/system/images/sort_up.png");
	} else {
		$("#name-sort-icon").attr("src", "https://admin.skinmed.id/userdata/system/images/sort_down.png");
	}
	displayUsers(1);
}

function sortByRegistrationDate() {
	sortRegistrationDateUp = !sortRegistrationDateUp;
	if (sortRegistrationDateUp) {
		$("#registration-date-sort-icon").attr("src", "https://admin.skinmed.id/userdata/system/images/sort_up.png");
	} else {
		$("#registration-date-sort-icon").attr("src", "https://admin.skinmed.id/userdata/system/images/sort_down.png");
	}
	displayUsers(2);
}

function goToPrevPage() {
	if (currentPage > 0) {
		currentPage--;
		goToPage(currentPage);
	}
}

function goToNextPage() {
	var totalPages = Math.floor(users.length/ITEMS_PER_PAGE);
	if ((users.length%ITEMS_PER_PAGE) > 0) {
		totalPages++;
	}
	if (currentPage < totalPages-1) {
		currentPage++;
		goToPage(currentPage);
	}
}
