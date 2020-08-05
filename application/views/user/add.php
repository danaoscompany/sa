<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Language" content="en">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Tambah Pengguna</title>
	<meta name="viewport"
		  content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
	<meta name="description" content="Build whatever layout you need with our Architect framework.">
	<meta name="msapplication-tap-highlight" content="no">
	<script src="http://skinmed.id/sa/js/jquery.js"></script>
	<script src="http://skinmed.id/sa/js/global.js"></script>
	<script src="http://skinmed.id/sa/js/add-user.js"></script>
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
			<div class="app-header-left">
				<ul class="header-menu nav">
					<li class="nav-item">
						<a href="http://skinmed.id/sa/common" class="nav-link">
							<i class="nav-link-icon fa fa-cogs"> </i>
							Umum
						</a>
					</li>
					<li class="nav-item">
						<a href="http://skinmed.id/sa/admin" class="nav-link">
							<i class="nav-link-icon fa fa-users-cog"> </i>
							Admin
						</a>
					</li>
					<li class="btn-group nav-item">
						<a href="http://skinmed.id/sa/user" class="nav-link">
							<i class="nav-link-icon fa fa-user"></i>
							Pengguna
						</a>
					</li>
					<li class="dropdown nav-item">
						<a href="http://skinmed.id/sa/sessions" class="nav-link">
							<i class="nav-link-icon fa fa-unlock-alt"></i>
							Session
						</a>
					</li>
					<li class="dropdown nav-item">
						<a href="http://skinmed.id/sa/payment/unpaid" class="nav-link">
							<i class="nav-link-icon fa fa-shopping-cart"></i>
							Pembayaran
						</a>
					</li>
					<li class="dropdown nav-item">
						<a href="http://skinmed.id/sa/admin/logout" class="nav-link">
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
										<img width="42" height="42" class="rounded-circle" src="http://skinmed.id/sa/images/profile_picture.png" alt="" style="border-radius: 21;">
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
								<i class="pe-7s-graph text-success">
								</i>
							</div>
							<div>Tambah Pengguna
							</div>
						</div>
					</div>
				</div>
				<div class="tab-content">
					<div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
						<div class="main-card mb-3 card">
							<div class="card-body"><h5 class="card-title">TAMBAH PENGGUNA</h5>
								<div class="position-relative form-group"><label for="first-name" class="">Posisi</label>
									<select id="role" class="form-control">
										<option>--- Pilih Role ---</option>
										<option>Dokter</option>
										<option>Admin</option>
									</select>
								</div>
								<div class="position-relative form-group"><label for="first-name" class="">Premium</label>
									<select id="premium" class="form-control">
										<option>--- Apakah Pengguna Termasuk Member Premium ---</option>
										<option>Ya</option>
										<option>Tidak</option>
									</select>
								</div>
								<div id="premium-start-container" style="display: none;"
									 class="position-relative form-group"><label for="premium-start" class="">Tanggal Mulai Premium</label>
									<input name="premium-start" id="premium-start" placeholder="Masukkan tanggal awal premium"
										   type="date" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="email" class="">Email</label>
									<input name="email" id="email" placeholder="Masukkan tanggal awal premium"
										   type="email" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="password" class="">Kata Sandi</label>
									<input name="password" id="password" placeholder="Masukkan password"
										   type="password" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="first-name" class="">Nama Depan</label>
									<input name="first-name" id="first-name" placeholder="Masukkan nama depan"
										   type="text" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="last-name" class="">Nama Belakang</label>
									<input name="last-name" id="last-name" placeholder="Masukkan nama depan"
										   type="text" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="phone" class="">Nomor HP</label>
									<input name="phone" id="phone" placeholder="Masukkan nomor HP"
										   type="text" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="address" class="">Alamat</label>
									<input name="address" id="address" placeholder="Masukkan alamat"
										   type="text" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="city" class="">Kota</label>
									<input name="city" id="city" placeholder="Masukkan kota"
										   type="text" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="province" class="">Provinsi</label>
									<input name="province" id="province" placeholder="Masukkan provinsi"
										   type="text" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="company-name" class="">Nama Perusahaan</label>
									<input name="company-name" id="company-name" placeholder="Masukkan nama perusahaan"
										   type="text" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="company-city" class="">Kota Perusahaan</label>
									<input name="company-city" id="company-city" placeholder="Masukkan kota perusahaan"
										   type="text" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="company-country" class="">Negara Perusahaan</label>
									<input name="company-country" id="company-country" placeholder="Masukkan negara perusahaan"
										   type="text" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="company-street" class="">Jalan Perusahaan</label>
									<input name="company-street" id="company-street" placeholder="Masukkan jalan perusahaan"
										   type="text" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="company-zip" class="">Kode ZIP Perusahaan</label>
									<input name="company-zip" id="company-zip" placeholder="Masukkan kode zip perusahaan"
										   type="text" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="company-state" class="">State Perusahaan</label>
									<input name="company-state" id="company-state" placeholder="Masukkan state perusahaan"
										   type="text" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="company-phone" class="">Nomor HP Perusahaan</label>
									<input name="company-phone" id="company-phone" placeholder="Masukkan nomor HP perusahaan"
										   type="text" class="form-control">
								</div>
								<button class="mt-2 btn btn-primary" style="width: 100%;" onclick="addUser()">Simpan
								</button>
								<button class="mt-2 btn btn-danger" style="width: 100%;" onclick="cancelEditing()">Batal
								</button>
							</div>
						</div>
					</div>
					<div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
						<div class="main-card mb-3 card">
							<div class="card-body"><h5 class="card-title">Grid</h5>
								<form class="">
									<div class="position-relative row form-group"><label for="exampleEmail"
																						 class="col-sm-2 col-form-label">Email</label>
										<div class="col-sm-10"><input name="email" id="exampleEmail"
																	  placeholder="with a placeholder" type="email"
																	  class="form-control"></div>
									</div>
									<div class="position-relative row form-group"><label for="examplePassword"
																						 class="col-sm-2 col-form-label">Password</label>
										<div class="col-sm-10"><input name="password" id="examplePassword"
																	  placeholder="password placeholder" type="password"
																	  class="form-control"></div>
									</div>
									<div class="position-relative row form-group"><label for="exampleSelect"
																						 class="col-sm-2 col-form-label">Select</label>
										<div class="col-sm-10"><select name="select" id="exampleSelect"
																	   class="form-control"></select></div>
									</div>
									<div class="position-relative row form-group"><label for="exampleSelectMulti"
																						 class="col-sm-2 col-form-label">Select
											Multiple</label>
										<div class="col-sm-10"><select multiple="" name="selectMulti"
																	   id="exampleSelectMulti"
																	   class="form-control"></select></div>
									</div>
									<div class="position-relative row form-group"><label for="exampleText"
																						 class="col-sm-2 col-form-label">Text
											Area</label>
										<div class="col-sm-10"><textarea name="text" id="exampleText"
																		 class="form-control"></textarea></div>
									</div>
									<div class="position-relative row form-group"><label for="exampleFile"
																						 class="col-sm-2 col-form-label">File</label>
										<div class="col-sm-10"><input name="file" id="exampleFile" type="file"
																	  class="form-control-file">
											<small class="form-text text-muted">This is some placeholder block-level
												help text for the above input. It's a bit lighter and easily wraps to a
												new line.</small>
										</div>
									</div>
									<fieldset class="position-relative row form-group">
										<legend class="col-form-label col-sm-2">Radio Buttons</legend>
										<div class="col-sm-10">
											<div class="position-relative form-check"><label
													class="form-check-label"><input name="radio2" type="radio"
																					class="form-check-input"> Option one
													is this and that—be sure to include why it's great</label></div>
											<div class="position-relative form-check"><label
													class="form-check-label"><input name="radio2" type="radio"
																					class="form-check-input"> Option two
													can be something else and selecting it will deselect option
													one</label></div>
											<div class="position-relative form-check disabled"><label
													class="form-check-label"><input name="radio2" disabled=""
																					type="radio"
																					class="form-check-input"> Option
													three is disabled</label></div>
										</div>
									</fieldset>
									<div class="position-relative row form-group"><label for="checkbox2"
																						 class="col-sm-2 col-form-label">Checkbox</label>
										<div class="col-sm-10">
											<div class="position-relative form-check"><label
													class="form-check-label"><input id="checkbox2" type="checkbox"
																					class="form-check-input"> Check me
													out</label></div>
										</div>
									</div>
									<div class="position-relative row form-check">
										<div class="col-sm-10 offset-sm-2">
											<button class="btn btn-secondary">Submit</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input id="admin-id" type="hidden" value="<?php echo $adminID; ?>">
<script type="text/javascript" src="http://skinmed.id/sa/assets/scripts/main.js"></script>
</body>
</html>
