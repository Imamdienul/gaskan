<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password - Gas</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <link rel="icon" href="<?= base_url() . 'assets/images/favicon1.png' ?>" type="image/jpeg">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/login.css') ?>">
  
  <style>
    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border: 1px solid transparent;
      border-radius: 4px;
    }
    .alert-success {
      color: #3c763d;
      background-color: #dff0d8;
      border-color: #d6e9c6;
    }
    .alert-danger {
      color: #a94442;
      background-color: #f2dede;
      border-color: #ebccd1;
    }
    .alert-info {
      color: #31708f;
      background-color: #d9edf7;
      border-color: #bce8f1;
    }
    .back-to-login {
      text-align: center;
      margin-top: 20px;
    }
    .back-to-login a {
      color: #007bff;
      text-decoration: none;
    }
    .back-to-login a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="floating-decoration decoration-1"></div>
  <div class="floating-decoration decoration-2"></div>
  
  <div class="container">
    <div class="image-section">
      <div class="image-content">
        <div class="logo">
          <img src="<?= base_url() . 'assets/images/logo.png' ?>" alt="Company Logo">
        </div>
        <h2>Reset Password</h2>
        <p>Masukkan email Anda untuk menerima link reset password</p>
      </div>
    </div>
    <div class="login-section">
      <div class="login-header">
        <h1>Lupa Password</h1>
        <p>Kami akan mengirimkan instruksi reset password ke email Anda</p>
      </div>

      <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success">
          <?= $this->session->flashdata('success'); ?>
        </div>
      <?php endif; ?>

      <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger">
          <?= $this->session->flashdata('error'); ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('auth/process_forgot_password') ?>" method="post">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        
        <div class="form-group">
          <label for="email">Email</label>
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" id="email" placeholder="Masukkan email Anda" required>
        </div>
        
        <button type="submit" class="login-button">
          <i class="fas fa-paper-plane" style="margin-right: 8px;"></i> Kirim Link Reset
        </button>
        
        <div class="back-to-login">
          <a href="<?= base_url('auth/login') ?>">
            <i class="fas fa-arrow-left"></i> Kembali ke halaman login
          </a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>