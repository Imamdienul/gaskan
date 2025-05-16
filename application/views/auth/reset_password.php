<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password - Gas</title>
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
    .password-strength {
      margin-top: 5px;
      font-size: 12px;
    }
    .password-strength-meter {
      height: 3px;
      background-color: #f3f3f3;
      margin-top: 5px;
      border-radius: 3px;
    }
    .password-strength-meter .strength {
      height: 100%;
      border-radius: 3px;
      transition: width 0.3s;
    }
    .weak {
      background-color: #ff4d4d;
      width: 25%;
    }
    .medium {
      background-color: #ffa64d;
      width: 50%;
    }
    .strong {
      background-color: #ffff4d;
      width: 75%;
    }
    .very-strong {
      background-color: #4CAF50;
      width: 100%;
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
        <p>Buat password baru untuk akun Anda</p>
      </div>
    </div>
    <div class="login-section">
      <div class="login-header">
        <h1>Reset Password</h1>
        <p>Silakan masukkan password baru Anda</p>
      </div>

      <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger">
          <?= $this->session->flashdata('error'); ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('auth/process_reset_password') ?>" method="post">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="token" value="<?= $token ?>">
        
        <div class="form-group">
          <label for="password">Password Baru</label>
          <i class="fas fa-lock"></i>
          <input type="password" name="password" id="password" placeholder="Masukkan password baru" required minlength="8">
          <div class="password-strength">
            <div>Kekuatan Password: <span id="strength-text">Belum dimasukkan</span></div>
            <div class="password-strength-meter">
              <div class="strength" id="strength-meter"></div>
            </div>
          </div>
        </div>
        
        <div class="form-group">
          <label for="confirm_password">Konfirmasi Password</label>
          <i class="fas fa-lock"></i>
          <input type="password" name="confirm_password" id="confirm_password" placeholder="Konfirmasi password baru" required minlength="8">
          <p id="password-match" style="font-size: 12px; margin-top: 5px;"></p>
        </div>
        
        <button type="submit" class="login-button" id="submit-btn">
          <i class="fas fa-save" style="margin-right: 8px;"></i> Perbarui Password
        </button>
        
        <div class="back-to-login">
          <a href="<?= base_url('auth/login') ?>">
            <i class="fas fa-arrow-left"></i> Kembali ke halaman login
          </a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#password').on('input', function() {
        var password = $(this).val();
        var strength = checkPasswordStrength(password);
        
        // Update strength meter
        $('#strength-meter').removeClass('weak medium strong very-strong');
        
        if (password.length === 0) {
          $('#strength-text').text('Belum dimasukkan');
          $('#strength-meter').width(0);
        } else if (strength === 1) {
          $('#strength-text').text('Lemah');
          $('#strength-meter').addClass('weak');
        } else if (strength === 2) {
          $('#strength-text').text('Sedang');
          $('#strength-meter').addClass('medium');
        } else if (strength === 3) {
          $('#strength-text').text('Kuat');
          $('#strength-meter').addClass('strong');
        } else if (strength === 4) {
          $('#strength-text').text('Sangat Kuat');
          $('#strength-meter').addClass('very-strong');
        }
        
        // Check if passwords match
        checkPasswordsMatch();
      });
      
      $('#confirm_password').on('input', function() {
        checkPasswordsMatch();
      });
      
      function checkPasswordsMatch() {
        var password = $('#password').val();
        var confirmPassword = $('#confirm_password').val();
        
        if (confirmPassword.length === 0) {
          $('#password-match').text('');
          return;
        }
        
        if (password === confirmPassword) {
          $('#password-match').text('Password cocok').css('color', '#4CAF50');
        } else {
          $('#password-match').text('Password tidak cocok').css('color', '#ff4d4d');
        }
      }
      
      function checkPasswordStrength(password) {
        // 0: No password
        // 1: Weak - only letters/numbers, too short
        // 2: Medium - mixture of letters and numbers, medium length
        // 3: Strong - mixture of letters, numbers and special chars, decent length
        // 4: Very strong - mixture of letters, numbers, special chars, good length
        
        if (password.length === 0) {
          return 0;
        }
        
        var strength = 0;
        
        // Length check
        if (password.length >= 8) {
          strength += 1;
        }
        if (password.length >= 12) {
          strength += 1;
        }
        
        // Character variety check
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
          strength += 1;
        }
        if (/[0-9]/.test(password)) {
          strength += 1;
        }
        if (/[^a-zA-Z0-9]/.test(password)) {
          strength += 1;
        }
        
        return Math.min(Math.floor(strength / 2) + 1, 4);
      }
    });
  </script>
</body>
</html>