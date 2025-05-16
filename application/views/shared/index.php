<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= base_url() . 'assets/images/favicon1.png' ?>" type="image/jpeg">

    <title>GAS |
        <?= $this->uri->segment(1) ?>
    </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
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
    <link rel="stylesheet" href="<?= base_url() . 'assets/dist/css/custom.css' ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css' ?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/daterangepicker/daterangepicker.css' ?>">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/summernote/summernote-bs4.min.css' ?>">
    <!-- Sweetalert -->
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/sweetalert2/dark.css' ?>">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/toastr/toastr.min.css' ?>">
    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="<?= base_url() . 'assets/plugins/jquery/jquery.min.js' ?>"></script>

</head>

<style>
    #global-loading {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
    }

    .spinner-ring {
        width: 100%;
        height: 100%;
        border: 8px solid #3c8dbc;
        border-top: 8px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    .logo-center {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 60px;
        height: 60px;
        transform: translate(-50%, -50%);
        border-radius: 50%;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div id="global-loading">
    <div class="spinner-wrapper">
        <div class="spinner-ring"></div>
        <img src="https://gisaka.media/gi.png" alt="Logo Perusahaan" class="logo-center">
    </div>
</div>




<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-black navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <p class="m-0 text-muted text-md mr-4">Gisaka Automation System</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 ">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column text-left">
            <div class="image">
                <img src="https://gisaka.media/logoputih.png" class="elevation-2" alt="Company Logo" style="width: 120px; height: auto; display: block;">
            </div>
            <div class="info mt-2">
                <a href="<?= base_url('users/profile') ?>" class="d-block">
                    <?= strtoupper($this->session->userdata('nama_user')); ?>
                </a>
                <span class="badge badge-pill badge-primary">
                    <?= $this->session->userdata('nama_group') ?>
                </span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Core Navigation -->
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link <?= $this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>DASHBOARD</p>
                    </a>
                </li>

                <!-- Attendance & Schedule Section -->
                <?php if ($this->session->userdata('group') == 1) { ?>
                <li class="nav-item <?= $this->uri->segment(1) == 'recap' || $this->uri->segment(1) == 'jadwal' || $this->uri->segment(1) == 'setting' ? 'menu-is-opening menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= $this->uri->segment(1) == 'recap' || $this->uri->segment(1) == 'jadwal' || $this->uri->segment(1) == 'setting' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            KEHADIRAN & JADWAL
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('recap') ?>" class="nav-link <?= $this->uri->segment(1) == 'recap' ? 'active' : '' ?>">
                                <i class="far fa-clipboard nav-icon"></i>
                                <p>KEHADIRAN</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('jadwal') ?>" class="nav-link <?= $this->uri->segment(1) == 'jadwal' ? 'active' : '' ?>">
                                <i class="far fa-calendar-minus nav-icon"></i>
                                <p>JADWAL LIBUR</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('setting') ?>" class="nav-link <?= $this->uri->segment(1) == 'setting' ? 'active' : '' ?>">
                                <i class="far fa-clock nav-icon"></i>
                                <p>WAKTU PRESENSI</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <!-- Technician Survey Section -->
                <?php if (in_array($this->session->userdata('group'), [2, 13])) { ?>
                <li class="nav-item">
                    <a href="<?= base_url('survey_teknisi') ?>" class="nav-link <?= $this->uri->segment(1) == 'survey_teknisi' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>LIST SURVEY</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('instalasi_teknisi') ?>" class="nav-link <?= $this->uri->segment(1) == 'list_instalasi' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-clipboard"></i>
                        <p>LIST INSTALASI</p>
                    </a>
                </li>
                <?php } ?>

                <!-- Requests Section -->
                <li class="nav-item <?= $this->uri->segment(1) == 'kasbon' || $this->uri->segment(1) == 'pembelian' ? 'menu-is-opening menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= $this->uri->segment(1) == 'kasbon' || $this->uri->segment(1) == 'pembelian' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            PENGAJUAN
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('kasbon') ?>" class="nav-link <?= $this->uri->segment(1) == 'kasbon' ? 'active' : '' ?>">
                                <i class="far fa-money-bill-alt nav-icon"></i>
                                <p>KEUANGAN</p>
                            </a>
                        </li>
                    </ul>
                </li>

<!-- SPK Section -->
<li class="nav-item <?= in_array($this->uri->segment(1), ['spk', 'jenis_pekerjaan', 'survey', 'browse_survey', 'instalasi', 'instalasi_teknisi', 'browse_instalasi']) ? 'menu-is-opening menu-open' : '' ?>">
    <a href="#" class="nav-link <?= in_array($this->uri->segment(1), ['spk', 'survey', 'browse_survey', 'instalasi', 'instalasi_teknisi', 'browse_instalasi']) ? 'active' : '' ?>">
        <i class="nav-icon fas fa-tasks"></i>
        <p>
            SPK & SURVEY
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('spk/spk_pelanggan') ?>" class="nav-link <?= $this->uri->segment(2) == 'spk_pelanggan' ? 'active' : '' ?>">
                <i class="far fa-file-alt nav-icon"></i>
                <p>SPK PELANGGAN</p>
            </a>
        </li>

        <?php if ($this->session->userdata('group') == 1) { ?>
        <li class="nav-item">
            <a href="<?= base_url('survey') ?>" class="nav-link <?= $this->uri->segment(1) == 'survey' ? 'active' : '' ?>">
                <i class="far fa-map nav-icon"></i>
                <p>SURVEY</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('instalasi') ?>" class="nav-link <?= $this->uri->segment(1) == 'instalasi' ? 'active' : '' ?>">
                <i class="fas fa-bolt nav-icon"></i>
                <p>INSTALASI</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('browse_instalasi') ?>" class="nav-link <?= $this->uri->segment(1) == 'browse_instalasi' ? 'active' : '' ?>">
                <i class="fas fa-clipboard-check nav-icon"></i>
                <p>HASIL INSTALASI</p>
            </a>
        </li>
        <?php } ?>

        <?php if (in_array($this->session->userdata('group'), [2, 13])) { ?>
        <li class="nav-item">
            <a href="<?= base_url('instalasi_teknisi') ?>" class="nav-link <?= $this->uri->segment(1) == 'instalasi_teknisi' ? 'active' : '' ?>">
                <i class="fas fa-tools nav-icon"></i>
                <p>LIST INSTALASI</p>
            </a>
        </li>
        <?php } ?>
    </ul>
</li>


                <!-- Administrator Section -->
                <?php if ($this->session->userdata('group') == 1 || $this->session->userdata('group') == 11) { ?>
                <li class="nav-header">ADMINISTRATOR</li>

                <li class="nav-item <?= $this->uri->segment(1) == 'customer' || $this->uri->segment(1) == 'wilayah' || $this->uri->segment(1) == 'profile_layanan' ? 'menu-is-opening menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= $this->uri->segment(1) == 'customer' || $this->uri->segment(1) == 'wilayah' || $this->uri->segment(1) == 'profile_layanan' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            DATA PELANGGAN
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('customer/browse') ?>" class="nav-link <?= $this->uri->segment(1) == 'customer' && $this->uri->segment(2) == 'browse' ? 'active' : '' ?>">
                                <i class="far fa-user nav-icon"></i>
                                <p>PELANGGAN</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('customer/onbill') ?>" class="nav-link <?= $this->uri->segment(2) == 'onbill' || $this->uri->segment(1) == 'wilayah' || $this->uri->segment(1) == 'profile_layanan' ? 'active' : '' ?>">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>LAYANAN ON-BILL</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item <?= $this->uri->segment(1) == 'inventory' || $this->uri->segment(1) == 'mutasi' || $this->uri->segment(1) == 'odp' ? 'menu-is-opening menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= $this->uri->segment(1) == 'inventory' || $this->uri->segment(1) == 'mutasi' || $this->uri->segment(1) == 'odp' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>
                            INVENTORY
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('inventory') ?>" class="nav-link <?= $this->uri->segment(1) == 'inventory' ? 'active' : '' ?>">
                                <i class="far fa-list-alt nav-icon"></i>
                                <p>DATA INVENTORY</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('mutasi') ?>" class="nav-link <?= $this->uri->segment(1) == 'mutasi' ? 'active' : '' ?>">
                                <i class="fas fa-exchange-alt nav-icon"></i>
                                <p>MUTASI INVENTORY</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('odp') ?>" class="nav-link <?= $this->uri->segment(1) == 'odp' ? 'active' : '' ?>">
                                <i class="fas fa-network-wired nav-icon"></i>
                                <p>DATA ODP</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <?php if ($this->session->userdata('group') == 1) { ?>
                <li class="nav-item">
                    <a href="<?= base_url('project') ?>" class="nav-link <?= $this->uri->segment(1) == 'project' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-project-diagram"></i>
                        <p>DATA PROJECT</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('payroll') ?>" class="nav-link <?= $this->uri->segment(1) == 'payroll' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                        <p>PAYROLL</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('users/list') ?>" class="nav-link <?= $this->uri->segment(2) == 'create' && $this->uri->segment(1) == 'users' || $this->uri->segment(2) == 'list' && $this->uri->segment(1) == 'users' || $this->uri->segment(1) == 'group_users' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>PENGGUNA</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('log') ?>" class="nav-link <?= $this->uri->segment(1) == 'log' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-history"></i>
                        <p>LOG</p>
                    </a>
                </li>
                <?php } ?>

                <hr>

                <!-- User Options -->
                <li class="nav-header">AKUN & PENGATURAN</li>
                <li class="nav-item">
                    <a href="<?= base_url('users/profile') ?>" class="nav-link <?= $this->uri->segment(2) == 'profile' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>PROFILE</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('pengaturan/ganti_pass') ?>" class="nav-link <?= $this->uri->segment(1) == 'pengaturan' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-key"></i>
                        <p>PENGATURAN</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('auth/logout') ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>LOGOUT</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


<style>
/* Add custom CSS to indent submenu items properly */
.nav-sidebar .nav-treeview {
    padding-left: 15px !important;
}

.nav-sidebar .nav-treeview .nav-item {
    margin-left: 10px !important;
}

.nav-sidebar .nav-treeview .nav-link {
    padding-left: 20px !important;
}

/* Optional: add a subtle visual indicator for submenus */
.nav-sidebar .nav-treeview::before {
    content: '';
    position: absolute;
    left: 23px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: rgba(255, 255, 255, 0.1);
}

/* Keep submenu icons properly aligned */
.nav-treeview .nav-link i {
    margin-right: 5px;
}
</style>

        <!-- Content Wrapper. Contains page content-->
        <div class="content-wrapper">
            
 
            <?= $contents ?>
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="text-sm">
                <strong>Copyright &copy; 2025 </strong> -
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block text-sm text-muted">
                    Made with <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="grey" class="bi bi-heart-fill mx-0" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                    </svg>
                    for <a href="https://gisaka.net/" class="text-muted" target="_blank">Gisaka Media</a>
                </div>
            </div>

        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <!-- jQuery UI 1.11.4 -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() . 'assets/plugins/jquery-ui/jquery-ui.min.js' ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


    <!-- Bootstrap 4 -->
    <script src="<?= base_url() . 'assets/plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js' ?>"></script>
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
    <!-- Sweetalert -->
    <script src="<?= base_url() . 'assets/plugins/sweetalert2/sweetalert2.min.js' ?>"></script>
    <!-- Toastr -->
    <script src="<?= base_url() . 'assets/plugins/toastr/toastr.min.js' ?>"></script>
    <script src="<?= base_url() . '/assets/dist/js/datatablesConfig.js' ?>"></script>
    <script src="<?= base_url() . '/assets/dist/js/goa.js' ?>"></script>
    
    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.3.3/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    
</body>

</html>
<script>
    $(function() {
        bsCustomFileInput.init();
    });

    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 10000
        });
        <?php if ($this->session->flashdata('success')) { ?> Toast.fire({
                icon: 'success',
                title: '<?= $this->session->flashdata('success'); ?>'
            });
        <?php } else if ($this->session->flashdata('error')) { ?> Toast.fire({
                icon: 'error',
                title: '<?= $this->session->flashdata('error'); ?>'
            });
        <?php } else if ($this->session->flashdata('warning')) { ?> Toast.fire({
                icon: 'warning',
                title: '<?= $this->session->flashdata('warning'); ?>'
            });
        <?php } else if ($this->session->flashdata('info')) { ?> Toast.fire({
                icon: 'info',
                title: '<?= $this->session->flashdata('info'); ?>'
            });
        <?php } ?>
    });
    $(window).on('load', function() {
    setTimeout(function() {
        $('#global-loading').fadeOut('slow');
    }, ); // Delay 0.5 detik (opsional)
});
</script>
