var userID = 0;
var payments = [];
var selectedPaymentIndex = 0;

$(document).ready(function() {
	userID = parseInt($("#user-id").val());
	getPayments();
});

function getPayments() {
	payments = [];
	$("#payments").find("*").remove();
	let fd = new FormData();
	fd.append("user_id", userID);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/payment/get_by_user_id",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			payments = JSON.parse(response);
			for (let i=0; i<payments.length; i++) {
				let payment = payments[i];
				let user = payment['user'];
				var name = user['first_name']+" "+user['last_name'];
				var type = "";
				if (payment['type'] == 'premium_purchase') {
					type = "Upgrade Premium Bulanan";
				}
				var status = "";
				if (payment['status'] == 'paid') {
					status = "TERBAYAR";
				} else if (payment['status'] == 'unpaid') {
					status = "BELUM DIBAYAR";
				}
				$("#payments").append("<tr>" +
					"                                        <th scope=\"row\">"+(i+1)+"</th>" +
					"                                        <td>"+name+"</td>" +
					"                                        <td>"+payment['amount']+"</td>" +
					"                                        <td>"+type+"</td>" +
					"                                        <td>"+payment['date']+"</td>" +
					"                                        <td>"+status+"</td>" +
					"                                        <td><button onclick='confirmDeletePayment("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example' data-toggle='modal' data-target='#confirm'>Hapus</button></td>" +
					"                                    </tr>");
			}
		}
	});
}

function confirmDeletePayment(index) {
	selectedPaymentIndex = index;
	$("#confirmLabel").html("Hapus Pembayaran");
	$("#confirmBody").html("Apakah Anda yakin ingin menghapus pembayaran ini?");
	$("#confirm").modal('show');
}

function deletePayment() {
	let fd = new FormData();
	fd.append("id", parseInt(payments[selectedPaymentIndex]['id']));
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/payment/delete_pending_payments",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			getPayments();
		}
	});
}
