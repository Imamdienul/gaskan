<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Gas</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <link rel="icon" href="<?= base_url() . 'assets/images/favicon1.png' ?>" type="image/jpeg">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/login.css') ?>">
  
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
        <h2>Welcome Back</h2>
        <p>Login Untuk Memasuki Gisaka Automation System Next Generation</p>
      </div>
    </div>
    <div class="login-section">
      <div class="login-header">
        <h1>GAS</h1>
        <p>Please enter your credentials to continue</p>
      </div>
      <form action="<?= base_url('auth/process') ?>" method="post">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="flock" id="lock">
        
        <div class="form-group">
          <label for="fusername">Username</label>
          <i class="fas fa-user"></i>
          <input type="text" name="fusername" id="fusername" placeholder="Enter your username" required>
        </div>
        
        <div class="form-group">
          <label for="fpassword">Password</label>
          <i class="fas fa-lock"></i>
          <input type="password" name="fpassword" id="fpassword" placeholder="Enter your password" required>
        </div>
        
        <div class="captcha-container">
          <canvas id="canvas"></canvas>
          <div class="form-group captcha-input">
            <i class="fas fa-shield-alt"></i>
            <input type="text" name="code" placeholder="Verification Code" required>
            <p id="not-valid" class="error-message"></p>
          </div>
        </div>
        
        <div class="form-extras">
  <div class="remember-me">
    <input type="checkbox" id="remember" name="remember">
    <label for="remember">Remember me</label>
  </div>
  <a href="<?= base_url('auth/forgot_password') ?>" class="forgot-password">Forgot Password?</a>
</div>
        
        <button type="submit" name="login" id="valid" class="login-button">
          <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i> Authenticate
        </button>
        
        <div class="social-login">
          <p>Or continue with</p>
          <div class="social-icons">
            <a href="#" title="Google"><i class="fab fa-google"></i></a>
            <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" title="Apple"><i class="fab fa-apple"></i></a>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="<?= base_url() . 'assets/dist/js/jquery-captcha.min.js' ?>"></script>
  <script src="<?= base_url() . 'assets/dist/js/login.js' ?>"></script>
</body>
</html>