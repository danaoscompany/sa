<?php
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Language" content="en">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Patients</title>
	<meta name="viewport"
		  content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
	<meta name="description" content="Tables are the backbone of almost all web applications.">
	<meta name="msapplication-tap-highlight" content="no">
	<script src="https://admin.skinmed.id/js/jquery.js"></script>
	<script src="https://admin.skinmed.id/js/jquery.redirect.js"></script>
	<script src="https://admin.skinmed.id/js/global.js"></script>
	<script src="https://admin.skinmed.id/js/patients.js"></script>
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
	<link href="https://admin.skinmed.id/main.css" rel="stylesheet">
</head>
<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
	<div class="app-header header-shadow">
		<div class="app-header__logo">
			<img src="https://admin.skinmed.id/assets/images/icon.png" width="50px" height="50px">
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
						<a href="https://admin.skinmed.id/common" class="nav-link">
							<i class="nav-link-icon fa fa-cogs"> </i>
							Common
						</a>
					</li>
					<li class="nav-item">
						<a href="https://admin.skinmed.id/admin" class="nav-link">
							<i class="nav-link-icon fa fa-users-cog"> </i>
							Admin
						</a>
					</li>
					<li class="btn-group nav-item">
						<a href="https://admin.skinmed.id/user" class="nav-link">
							<i class="nav-link-icon fa fa-user"></i>
							User
						</a>
					</li>
					<li class="dropdown nav-item">
						<a href="https://admin.skinmed.id/sessions" class="nav-link">
							<i class="nav-link-icon fa fa-unlock-alt"></i>
							Session
						</a>
					</li>
					<li class="dropdown nav-item">
						<a href="https://admin.skinmed.id/payment/unpaid" class="nav-link">
							<i class="nav-link-icon fa fa-shopping-cart"></i>
							Payment
						</a>
					</li>
					<li class="dropdown nav-item">
						<a href="https://admin.skinmed.id/admin/logout" class="nav-link">
							<i class="nav-link-icon fa fa-sign-out-alt"></i>
							Logout
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
										<img width="42" height="42" class="rounded-circle" src="https://admin.skinmed.id/images/profile_picture.png" alt="" style="border-radius: 21;">
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
				<img src="https://admin.skinmed.id/assets/images/icon.png" width="50px" height="50px">
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
							<a href="https://admin.skinmed.id/common">
								<i class="metismenu-icon pe-7s-settings"></i>
								Common
							</a>
						</li>
						<li>
							<a href="https://admin.skinmed.id/admin">
								<i class="metismenu-icon pe-7s-users"></i>
								Admin
							</a>
						</li>
						<li>
							<a href="https://admin.skinmed.id/user">
								<i class="metismenu-icon pe-7s-users"></i>
								User
							</a>
						</li>
						<li>
							<a href="https://admin.skinmed.id/sessions">
								<i class="metismenu-icon pe-7s-unlock"></i>
								Session
							</a>
						</li>
						<li class="mm-active">
							<a href="#">
								<i class="metismenu-icon pe-7s-piggy"></i>
								Payment
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul class="mm-show">
								<li>
									<a href="https://admin.skinmed.id/payment/unpaid">
										<i class="metismenu-icon">
										</i>Not Paid
									</a>
								</li>
								<li>
									<a href="https://admin.skinmed.id/payment/paid">
										<i class="metismenu-icon">
										</i>Paid
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="https://admin.skinmed.id/admin/logout">
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
							<div>Patient List
							</div>
						</div>
						<div class="page-title-actions">
							<div class="d-inline-block dropdown">
								<button onclick="window.location.href='https://admin.skinmed.id/patients/add?id='+<?php echo $userID; ?>" type="button" class="btn-shadow btn btn-info">
									Add Patient
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="main-card mb-3 card" style="width: 1000px;">
							<div class="card-body"><h5 class="card-title">PATIENT LIST</h5>
								<label style="margin-top: 10px;">User:</label>
								<select id="select-user" style="margin-top: 5px;" class="form-control-sm form-control">
									<option>--- Choose User ---</option>
								</select>
								<table class="mb-0 table" style="margin-top: 20px;">
									<thead>
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Address</th>
										<th>City</th>
										<th>Province</th>
										<th>Birthday</th>
										<th>Image</th>
										<th>Edit</th>
										<th>Delete</th>
									</tr>
									</thead>
									<tbody id="patients">
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
				<h5 class="modal-title" id="confirmLabel">Delete Pasien</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p id="confirm-message" class="mb-0">Are you sure you want to delete this patient?</p>
			</div>
			<div class="modal-footer">
				<button id="confirm-no" type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
				<button id="confirm-yes" type="button" class="btn btn-primary" data-dismiss="modal" onclick="deletePatient()">Yes</button>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="admin-id" value="<?php echo $adminID; ?>">
<input type="hidden" id="user-id" value="<?php echo $userID; ?>">
<script type="text/javascript" src="https://admin.skinmed.id/assets/scripts/main.js"></script>
</body>
</html>

