const HOST = "skinmed.id";
const PHP_URL = "https://"+HOST+"/sa/index.php";

function uuidv4() {
	return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
		var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
		return v.toString(16);
	});
}

function logout() {
	if (confirm("Are you sure you want to logout?")) {
		$.ajax({
			type: 'GET',
			url: PHP_URL+"/admin/logout",
			dataType: 'text',
			cache: false,
			success: function(response) {
				window.location.href = "https://skinmed.id/sa/login";
			}
		});
	}
}
