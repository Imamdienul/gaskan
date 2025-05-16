<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome Back - GAS</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <link rel="icon" href="<?= base_url() . 'assets/images/favicon1.png' ?>" type="image/jpeg">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/login.css') ?>">
  
  <style>
    .welcome-back {
      text-align: center;
      margin-bottom: 30px;
    }
    
    .user-avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background-color: #f0f0f0;
      margin: 0 auto 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 40px;
      color: #666;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    
    .welcome-message {
      margin-top: 20px;
      font-size: 16px;
      color: #666;
    }
    
    .action-buttons {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-top: 30px;
    }
    
    .continue-button {
      background: linear-gradient(to right, #4776E6, #8E54E9);
      color: white;
      border: none;
      border-radius: 6px;
      padding: 12px 20px;
      font-size: 16px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(71, 118, 230, 0.2);
    }
    
    .continue-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(71, 118, 230, 0.3);
    }
    
    .different-account {
      background: transparent;
      border: 1px solid #ddd;
      color: #666;
      border-radius: 6px;
      padding: 12px 20px;
      font-size: 16px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }
    
    .different-account:hover {
      background: #f9f9f9;
    }
    
    .button-icon {
      margin-right: 8px;
    }
    
    .last-login {
      font-size: 12px;
      color: #999;
      margin-top: 15px;
      text-align: center;
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
        <h2>Welcome Back</h2>
        <p>Continue where you left off in Gisaka Automation System Next Generation</p>
      </div>
    </div>
    <div class="login-section">
      <div class="login-header">
        <h1>GAS</h1>
        <p>We're glad to see you again</p>
      </div>
      
      <div class="welcome-back">
        <div class="user-avatar">
          <i class="fas fa-user"></i>
        </div>
        <h2><?= $user->nama_user ?></h2>
        <p class="welcome-message">Your session is still active.</p>
      </div>
      
      <div class="action-buttons">
        <a href="<?= base_url('auth/continue_session') ?>" class="continue-button">
          <i class="fas fa-sign-in-alt button-icon"></i> Continue
        </a>
        
        <a href="<?= base_url('auth/logout?full_logout=true') ?>" class="different-account">
          <i class="fas fa-user-alt button-icon"></i> Use different account
        </a>
      </div>
      
      <div class="last-login">
        <p>Last active: <?= date('d M Y, H:i') ?></p>
      </div>
    </div>
  </div>
</body>
</html>