<?php
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Language" content="en">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Session</title>
	<meta name="viewport"
		  content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
	<meta name="description" content="Tables are the backbone of almost all web applications.">
	<meta name="msapplication-tap-highlight" content="no">
	<script src="http://localhost/sa/js/jquery.js"></script>
	<script src="http://localhost/sa/js/jquery.redirect.js"></script>
	<script src="http://localhost/sa/js/global.js"></script>
	<script src="http://localhost/sa/js/sessions.js"></script>
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
	<link href="http://localhost/sa/main.css" rel="stylesheet">
</head>
<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
	<div class="app-header header-shadow">
		<div class="app-header__logo">
			<img src="http://localhost/sa/assets/images/icon.png" width="50px" height="50px">
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
			<div class="app-header-left">
				<ul class="header-menu nav">
					<li class="nav-item">
						<a href="http://localhost/sa/common" class="nav-link">
							<i class="nav-link-icon fa fa-cogs"> </i>
							Umum
						</a>
					</li>
					<li class="nav-item">
						<a href="http://localhost/sa/admin" class="nav-link">
							<i class="nav-link-icon fa fa-users-cog"> </i>
							Admin
						</a>
					</li>
					<li class="btn-group nav-item">
						<a href="http://localhost/sa/user" class="nav-link">
							<i class="nav-link-icon fa fa-user"></i>
							Pengguna
						</a>
					</li>
					<li class="dropdown nav-item">
						<a href="http://localhost/sa/sessions" class="nav-link">
							<i class="nav-link-icon fa fa-unlock-alt"></i>
							Session
						</a>
					</li>
					<li class="dropdown nav-item">
						<a href="http://localhost/sa/payment/unpaid" class="nav-link">
							<i class="nav-link-icon fa fa-shopping-cart"></i>
							Pembayaran
						</a>
					</li>
					<li class="dropdown nav-item">
						<a href="http://localhost/sa/admin/logout" class="nav-link">
							<i class="nav-link-icon fa fa-sign-out-alt"></i>
							Keluar
						</a>
					</li>
				</ul>
			</div>
			<div class="app-header-right">
				<div class="header-btn-lg pr-0">
					<div class="widget-content p-0">
						<div class="widget-content-wrapper">
							<div class="widget-content-left">
								<div class="btn-group">
									<a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
									   class="p-0 btn">
										<img width="42" height="42" class="rounded-circle" src="images/profile_picture.png" alt="" style="border-radius: 21;">
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="app-main">
		<div class="app-sidebar sidebar-shadow">
			<div class="app-header__logo">
				<img src="http://localhost/sa/assets/images/icon.png" width="50px" height="50px">
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
							<a href="http://localhost/sa/common">
								<i class="metismenu-icon pe-7s-users"></i>
								Umum
							</a>
						</li>
						<li>
							<a href="http://localhost/sa/admin">
								<i class="metismenu-icon pe-7s-users"></i>
								Admin
							</a>
						</li>
						<li>
							<a href="http://localhost/sa/user">
								<i class="metismenu-icon pe-7s-users"></i>
								Pengguna
							</a>
						</li>
						<li class="mm-active">
							<a href="http://localhost/sa/sessions">
								<i class="metismenu-icon pe-7s-users"></i>
								Session
							</a>
						</li>
						<li>
							<a href="#">
								<i class="metismenu-icon pe-7s-car"></i>
								Pembayaran
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul class="mm-show">
								<li>
									<a href="http://localhost/sa/payment/unpaid">
										<i class="metismenu-icon">
										</i>Belum Dibayar
									</a>
								</li>
								<li>
									<a href="http://localhost/sa/payment/paid">
										<i class="metismenu-icon">
										</i>Sudah Dibayar
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="http://localhost/sa/admin/logout">
								<i class="metismenu-icon pe-7s-users"></i>
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
							<div>Daftar Session
							</div>
						</div>
						<div class="page-title-actions">
							<div class="d-inline-block dropdown">
								<button onclick="window.location.href='http://localhost/sa/sessions/add'" type="button" class="btn-shadow btn btn-info">
									Tambah Session
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="main-card mb-3 card" style="width: 1000px;">
							<div class="card-body"><h5 class="card-title">DAFTAR SESSION</h5>
								<select id="users" class="form-control-sm form-control" style="margin-top: 15px;">
									<option>Pilih User</option>
								</select>
								<table class="mb-0 table" style="margin-top: 15px;">
									<thead>
									<tr>
										<th>#</th>
										<th>Nama</th>
										<th>Session</th>
										<th>Tanggal</th>
										<th>Ubah</th>
										<th>Hapus</th>
									</tr>
									</thead>
									<tbody id="sessions">
									<!--<tr>
										<th scope="row">1</th>
										<td>Mark</td>
										<td>Otto</td>
										<td>@mdo</td>
									</tr>
									<tr>
										<th scope="row">2</th>
										<td>Jacob</td>
										<td>Thornton</td>
										<td>@fat</td>
									</tr>
									<tr>
										<th scope="row">3</th>
										<td>Larry</td>
										<td>the Bird</td>
										<td>@twitter</td>
									</tr>-->
									</tbody>
								</table>
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
				<h5 class="modal-title" id="confirmLabel">Hapus Pengguna</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p id="confirm-message" class="mb-0">Apakah Anda yakin ingin menghapus session ini?</p>
			</div>
			<div class="modal-footer">
				<button id="confirm-no" type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
				<button id="confirm-yes" type="button" class="btn btn-primary" data-dismiss="modal" onclick="deleteSession()">Ya</button>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="admin-id" value="<?php echo $adminID; ?>">
<script type="text/javascript" src="http://localhost/sa/assets/scripts/main.js"></script>
</body>
</html>

