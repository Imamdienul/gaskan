<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= base_url() . 'assets/images/favicon1.png' ?>" type="image/jpeg">

    <title>GAS | <?= $this->uri->segment(1) ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@farbelous/fontawesome-iconpicker@3.2.0/dist/css/fontawesome-iconpicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/fontawesome-free/css/all.min.css' ?>">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' ?>">
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/jqvmap/jqvmap.min.css' ?>">
    <link rel="stylesheet" href="<?= base_url() . 'assets/dist/css/adminlte.min.css' ?>">
    <link rel="stylesheet" href="<?= base_url() . 'assets/dist/css/custom.css' ?>">
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css' ?>">
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/daterangepicker/daterangepicker.css' ?>">
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/summernote/summernote-bs4.min.css' ?>">
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/sweetalert2/dark.css' ?>">
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/toastr/toastr.min.css' ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
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
        <nav class="main-header navbar navbar-expand navbar-black navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <p class="m-0 text-muted text-md mr-4">Gisaka Automation System</p>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <div class="sidebar">
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
                <?php $this->load->view('sidebar'); ?>
            </div>
        </aside>

        <style>
            .nav-sidebar .nav-treeview {
                padding-left: 15px !important;
            }

            .nav-sidebar .nav-treeview .nav-item {
                margin-left: 10px !important;
            }

            .nav-sidebar .nav-treeview .nav-link {
                padding-left: 20px !important;
            }

            .nav-sidebar .nav-treeview::before {
                content: '';
                position: absolute;
                left: 23px;
                top: 0;
                bottom: 0;
                width: 2px;
                background: rgba(255, 255, 255, 0.1);
            }

            .nav-treeview .nav-link i {
                margin-right: 5px;
            }
        </style>

        <div class="content-wrapper">
            <?= $contents ?>
        </div>
        
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

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() . 'assets/plugins/jquery-ui/jquery-ui.min.js' ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@farbelous/fontawesome-iconpicker@3.2.0/dist/js/fontawesome-iconpicker.min.js"></script>
    <script src="<?= base_url() . 'assets/plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/plugins/chart.js/Chart.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/plugins/sparklines/sparkline.js' ?>"></script>
    <script src="<?= base_url() . 'assets/plugins/jqvmap/jquery.vmap.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/plugins/jqvmap/maps/jquery.vmap.usa.js' ?>"></script>
    <script src="<?= base_url() . 'assets/plugins/jquery-knob/jquery.knob.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/plugins/moment/moment.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/plugins/daterangepicker/daterangepicker.js' ?>"></script>
    <script src="<?= base_url() . 'assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/plugins/summernote/summernote-bs4.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/dist/js/adminlte.js' ?>"></script>
    <script src="<?= base_url() . 'assets/plugins/sweetalert2/sweetalert2.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/plugins/toastr/toastr.min.js' ?>"></script>
    <script src="<?= base_url() . '/assets/dist/js/datatablesConfig.js' ?>"></script>
    <script src="<?= base_url() . '/assets/dist/js/goa.js' ?>"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.3.3/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
</body>

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
        <?php if ($this->session->flashdata('success')) { ?> 
            Toast.fire({
                icon: 'success',
                title: '<?= $this->session->flashdata('success'); ?>'
            });
        <?php } else if ($this->session->flashdata('error')) { ?> 
            Toast.fire({
                icon: 'error',
                title: '<?= $this->session->flashdata('error'); ?>'
            });
        <?php } else if ($this->session->flashdata('warning')) { ?> 
            Toast.fire({
                icon: 'warning',
                title: '<?= $this->session->flashdata('warning'); ?>'
            });
        <?php } else if ($this->session->flashdata('info')) { ?> 
            Toast.fire({
                icon: 'info',
                title: '<?= $this->session->flashdata('info'); ?>'
            });
        <?php } ?>
    });
    
    $(window).on('load', function() {
        setTimeout(function() {
            $('#global-loading').fadeOut('slow');
        });
    });
</script>
</html>