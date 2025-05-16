<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GAS | Verifikasi Telegram</title>



    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= base_url() . 'assets/images/favicon1.png' ?>" type="image/jpeg">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/fontawesome-free/css/all.min.css' ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css' ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() . 'assets/dist/css/adminlte.min.css' ?>">
    <!-- <link rel="stylesheet" href="<?= base_url("assets/dist/css/custom.css") ?>"> -->

    <!-- Sweetalert -->
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/sweetalert2/dark.css' ?>">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url() . 'assets/plugins/toastr/toastr.min.css' ?>">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page bg-dark">
    <div class="login-box">
        <div class="row  justify-content-center">
        </div>
        <div class="login-logo">
            <p class="font-weight-light " style="font-size:1.9rem;">Gisaka Automation System</p>
        </div>
        <!-- /.login-logo -->
        <div class="card ">
            <div class="card-body login-card-body ">
                <p class="H-1 text-center">KODE VERIFIKASI TELEGRAM</p>
                <p class="text-xl text-bold text-center alert alert-info" style="letter-spacing: 5px;">
                    <?= $code ?>
                </p>
                <hr>
                <p class="text-bold pt-3">Langkah - Langkah Verifikasi Akun :</p>
                <ol>
                    <li>Buka aplikasi Telegram.</li>
                    <li>Cari <b>@GAS_NotificationBot</b> atau klik link berikut <a
                            href="https://t.me/GAS_NotificationBot" target="_blank">https://t.me/GAS_NotificationBot</a>
                    </li>
                    <!-- <img class="img mb-2" src="<?= base_url('assets/images/gas_bot.png') ?>" alt="Photo" height="100px"> -->
                    <li>
                        Mulai chat dengan <b>@GAS_NotificationBot</b>.
                    </li>
                    <li>Masukan <b>Kode Verifikasi Telegram</b> dengan format
                        <code> /verify [spasi] kode verifikasi</code>.
                    </li>
                    <li>Setelah <b>berhasil</b> melakukan verifikasi pada telegram, silahkan login kembali pada
                        <a href="https://gas.gisaka.net/">gas.gisaka.net</a>
                    </li>
                    <li>Jika terjadi masalah dalam verifikasi, silahkan hubungi administrator dengan klik link berikut
                        <a href="https://wa.me/6287776451664/?text=Hallo%20Administrator%20GOA%2C%20%0A"
                            target="_blank">wa.me/administrator</a>.
                    </li>

                </ol>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url() . 'assets/plugins/jquery/jquery.min.js' ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() . 'assets/plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() . 'assets/dist/js/adminlte.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/dist/js/jquery-captcha.min.js' ?>"></script>
    <script src="<?= base_url() . 'assets/dist/js/login.js' ?>"></script>
    <!-- Sweetalert -->
    <script src="<?= base_url() . 'assets/plugins/sweetalert2/sweetalert2.min.js' ?>"></script>
    <!-- Toastr -->
    <script src="<?= base_url() . 'assets/plugins/toastr/toastr.min.js' ?>"></script>
    <!-- Alert Config -->

</body>

</html>