<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Shaga | Dashboard</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url() . 'assets/plugins/fontawesome-free/css/all.min.css' ?>">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet" href="<?= base_url() . 'assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' ?>">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?= base_url() . 'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css' ?>">
	<!-- JQVMap -->
	<link rel="stylesheet" href="<?= base_url() . 'assets/plugins/jqvmap/jqvmap.min.css' ?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url() . 'assets/dist/css/adminlte.min.css' ?>">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="<?= base_url() . 'assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css' ?>">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?= base_url() . 'assets/plugins/daterangepicker/daterangepicker.css' ?>">
	<!-- summernote -->
	<link rel="stylesheet" href="<?= base_url() . 'assets/plugins/summernote/summernote-bs4.min.css' ?>">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">

		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-indigo navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="index3.html" class="nav-link">Home</a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="#" class="nav-link">Contact</a>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-indigo elevation-4">
			<!-- Brand Logo -->
			<a href="#" class="brand-link">
				<span class="brand-text font-weight-light">Shaga</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user panel (optional) -->
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<img src="<?= base_url() . 'assets/images/user.jpg' ?>" class="img-circle elevation-2" alt="User Image">
					</div>
					<div class="info">
						<a href="#" class="d-block">Ade Rahmat N</a>
					</div>
				</div>



				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<li class="nav-item">~
							<a href="<?= base_url('dashboard') ?>" class="nav-link active">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p>
									Dashboad
									<span class="right badge badge-danger">New</span>
								</p>
							</a>
						</li>
						<li class="nav-header">TICKET MANAGEMENT</li>
						<li class="nav-item">
							<a href="pages/calendar.html" class="nav-link">
								<i class="nav-icon fas fa-clipboard-list"></i>
								<p>
									Browse Ticket
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="pages/calendar.html" class="nav-link">
								<i class="nav-icon fas fa-notes-medical"></i>
								<p>
									Create Ticket
									<span class="badge badge-info right">2</span>
								</p>
							</a>
						</li>
						<li class="nav-header">CUSTOMERS</li>
						<li class="nav-item">
							<a href="pages/calendar.html" class="nav-link">
								<i class="nav-icon fas fa-user-friends"></i>
								<p>
									Browse Customers
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="pages/calendar.html" class="nav-link">
								<i class="nav-icon fas fa-user-plus"></i>
								<p>
									New Customers
									<span class="badge badge-info right">2</span>
								</p>
							</a>
						<li class="nav-header">SERVICES MANAGEMENT</li>
						<li class="nav-item">
							<a href="pages/calendar.html" class="nav-link">
								<i class="nav-icon fas fa-cubes"></i>
								<p>
									Browse Services
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="pages/calendar.html" class="nav-link">
								<i class="nav-icon fas fa-cube"></i>
								<p>
									Create Services
									<span class="badge badge-info right">2</span>
								</p>
							</a>
						</li>
						<li class="nav-header">USER MANAGEMENT</li>
						<li class="nav-item">
							<a href="pages/calendar.html" class="nav-link">
								<i class="nav-icon fas fa-user-lock"></i>
								<p>
									Users
									<span class="badge badge-info right">2</span>
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="pages/gallery.html" class="nav-link">
								<i class="nav-icon fas fa-users-cog"></i>
								<p>
									Group Users
								</p>
							</a>
						</li>
						<li class="nav-header">UTILITY</li>
						<li class="nav-item">
									<a href="pages/calendar.html" class="nav-link">
								<i class="nav-icon fas fa-cogs"></i>
								<p>
									Settings
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="pages/gallery.html" class="nav-link">
								<i class="nav-icon fas fa-sign-out-alt"></i>
								<p>
									Logout
								</p>
							</a>
						</li>
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Dashboard</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Dashboard v1</li>
							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<p>welcome</p>
				</div><!-- /.container-fluid -->
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">

			<strong>Copyright &copy; 2023 </strong> -
			All rights reserved.
			<div class="float-right d-none d-sm-inline-block">
				Made with <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="red" class="bi bi-heart-fill mx-1" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
				</svg>
				for <a href="https://gisaka.net/" class="text-muted">Gisaka Media</a>
			</div>
		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->

	<!-- jQuery -->
	<script src="<?= base_url() . 'assets/plugins/jquery/jquery.min.js' ?>"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="<?= base_url() . 'assets/plugins/jquery-ui/jquery-ui.min.js' ?>"></script>

	<!-- Bootstrap 4 -->
	<script src="<?= base_url() . 'assets/plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
	<!-- ChartJS -->
	<script src="<?= base_url() . 'assets/plugins/chart.js/Chart.min.js' ?>"></script>
	<!-- Sparkline -->
	<script src="<?= base_url() . 'assets/plugins/sparklines/sparkline.js' ?>"></script>
	<!-- JQVMap -->
	<script src="<?= base_url() . 'assets/plugins/jqvmap/jquery.vmap.min.js' ?>"></script>
	<script src="<?= base_url() . 'assets/plugins/jqvmap/maps/jquery.vmap.usa.js' ?>"></script>
	<!-- jQuery Knob Chart -->
	<script src="<?= base_url() . 'assets/plugins/jquery-knob/jquery.knob.min.js' ?>"></script>
	<!-- daterangepicker -->
	<script src="<?= base_url() . 'assets/plugins/moment/moment.min.js' ?>"></script>
	<script src="<?= base_url() . 'assets/plugins/daterangepicker/daterangepicker.js' ?>"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="<?= base_url() . 'assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js' ?>"></script>
	<!-- Summernotassets/e -->
	<script src="<?= base_url() . 'assets/plugins/summernote/summernote-bs4.min.js' ?>"></script>
	<!-- overlayScrollbars -->
	<script src="<?= base_url() . 'assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js' ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url() . 'assets/dist/js/adminlte.js' ?>"></script>
</body>

</html>