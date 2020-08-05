<?php
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Language" content="en">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Perangkat</title>
	<meta name="viewport"
		  content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
	<meta name="description" content="Tables are the backbone of almost all web applications.">
	<meta name="msapplication-tap-highlight" content="no">
	<script src="http://skinmed.id/sa/js/jquery.js"></script>
	<script src="http://skinmed.id/sa/js/global.js"></script>
	<script src="http://skinmed.id/sa/js/jquery.redirect.js"></script>
	<script src="http://skinmed.id/sa/js/image.js"></script>
	<!--
	=========================================================
	* ArchitectUI HTML Theme Dashboard - v1.0.0
	=========================================================
	* Product Page: https://dashboardpack.com
	* Copyright 2019 DashboardPack (https://dashboardpack.com)
	* Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
	=========================================================
	* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
	-->
	<link href="http://skinmed.id/sa/main.css" rel="stylesheet">
</head>
<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
	<div class="app-header header-shadow">
		<div class="app-header__logo">
			<img src="http://skinmed.id/sa/assets/images/icon.png" width="50px" height="50px">
			<div class="header__pane ml-auto">
				<div>
					<button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
							data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
					</button>
				</div>
			</div>
		</div>
		<div class="app-header__mobile-menu">
			<div>
				<button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
				</button>
			</div>
		</div>
		<div class="app-header__menu">
                <span>
                    <button type="button"
							class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
		</div>
		<div class="app-header__content">
			<div class="app-header-right">
				<div class="header-btn-lg pr-0">
					<div class="widget-content p-0">
						<div class="widget-content-wrapper">
							<div class="widget-content-left">
								<div class="btn-group">
									<a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
									   class="p-0 btn">
										<img width="42" height="42" class="rounded-circle" src="http://skinmed.id/images/profile_picture.png" alt="" style="border-radius: 21;">
										<i class="fa fa-angle-down ml-2 opacity-8"></i>
									</a>
									<div tabindex="-1" role="menu" aria-hidden="true"
										 class="dropdown-menu dropdown-menu-right">
										<button onclick="logout()" type="button" tabindex="0" class="dropdown-item">Logout</button>
									</div>
								</div>
							</div>
							<div class="widget-content-left  ml-3 header-user-info">
								<div id="admin-name" class="widget-heading">
								</div>
								<div id="admin-email" class="widget-subheading">
								</div>
							</div>
							<div class="widget-content-right header-user-info ml-3">
								<button onclick="logout()" type="button" class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
									<i class="fa text-white fa-sign-out pr-1 pl-1"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="app-main">
		<div class="app-sidebar sidebar-shadow">
			<div class="app-header__logo">
				<img src="http://skinmed.id/sa/assets/images/icon.png" width="50px" height="50px">
				<div class="header__pane ml-auto">
					<div>
						<button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
								data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
						</button>
					</div>
				</div>
			</div>
			<div class="app-header__mobile-menu">
				<div>
					<button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
					</button>
				</div>
			</div>
			<div class="app-header__menu">
                        <span>
                            <button type="button"
									class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
			</div>
			<div class="scrollbar-sidebar">
				<div class="app-sidebar__inner">
					<ul class="vertical-nav-menu">
						<li>
						<li>
							<a href="http://skinmed.id/sa/common">
								<i class="metismenu-icon pe-7s-settings"></i>
								Umum
							</a>
						</li>
						<li>
							<a href="http://skinmed.id/sa/admin">
								<i class="metismenu-icon pe-7s-users"></i>
								Admin
							</a>
						</li>
						<li>
							<a href="http://skinmed.id/sa/user">
								<i class="metismenu-icon pe-7s-users"></i>
								Pengguna
							</a>
						</li>
						<li>
							<a href="http://skinmed.id/sa/sessions">
								<i class="metismenu-icon pe-7s-unlock"></i>
								Session
							</a>
						</li>
						<li class="mm-active">
							<a href="#">
								<i class="metismenu-icon pe-7s-piggy"></i>
								Pembayaran
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul class="mm-show">
								<li>
									<a href="http://skinmed.id/sa/payment/unpaid">
										<i class="metismenu-icon">
										</i>Belum Dibayar
									</a>
								</li>
								<li>
									<a href="http://skinmed.id/sa/payment/paid">
										<i class="metismenu-icon">
										</i>Sudah Dibayar
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="http://skinmed.id/sa/admin/logout">
								<i class="metismenu-icon pe-7s-power"></i>
								Logout
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="app-main__outer">
			<div class="app-main__inner">
				<div class="app-page-title">
					<div class="page-title-wrapper">
						<div class="page-title-heading">
							<div class="page-title-icon">
								<i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
								</i>
							</div>
							<div>Daftar Perangkat
							</div>
						</div>
						<div class="page-title-actions">
							<div class="d-inline-block dropdown">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="main-card mb-3 card" style="width: 1000px;">
							<div class="card-body"><h5 class="card-title">DAFTAR GAMBAR</h5>
								<div style="font-size: 15px; margin-top: 20px;">Pengguna</div>
								<select id="users" class="form-control-sm form-control" style="margin-top: 5px;">
									<option>Pilih User</option>
								</select>
								<div style="font-size: 15px; margin-top: 15px;">Session</div>
								<select id="sessions" class="form-control-sm form-control" style="margin-top: 5px;">
									<option>Pilih Session</option>
								</select>
								<div style="font-size: 15px; margin-top: 15px;">Gambar</div>
								<div id="images" class="row" style="margin-top: 20px;">
									<!--<div class="col-md-6 col-lg-3">
										<div class="card-shadow-danger mb-3 widget-chart widget-chart2 text-left card">
											<div class="widget-content">
												<div class="widget-content-outer">
													<img src="http://skinmed.id/sa/userdata/sample_img.jpg" width="100%" height="150px">
													<div style="width: 100%; display: flex; flex-direction: column; align-items: center;">
														<button class="mb-2 mr-2 btn btn-info" style="margin-top: 10px;">Lihat</button>
														<button class="mb-2 mr-2 btn btn-danger" style="margin-top: -5px;">Hapus</button>
													</div>
												</div>
											</div>
										</div>
									</div>-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="confirmLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="confirmLabel">Hapus Perangkat</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p id="confirm-message" class="mb-0">Apakah Anda yakin ingin menghapus perangkat ini?</p>
			</div>
			<div class="modal-footer">
				<button id="confirm-no" type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
				<button id="confirm-yes" type="button" class="btn btn-primary" data-dismiss="modal" onclick="deleteDevice()">Ya</button>
			</div>
		</div>
	</div>
</div>
<form id="view-image" style="display: none;" method="POST" action="http://skinmed.id/sa/image/view_image">
	<input id="uuid" type="hidden" value="">
</form>
<script type="text/javascript" src="http://skinmed.id/sa/assets/scripts/main.js"></script>
</body>
</html>

