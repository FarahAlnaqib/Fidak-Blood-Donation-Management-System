<?php 
include 'conn.php';
include 'session.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fidak (BBMS) - Change Password</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      font-family: 'Noto Kufi Arabic', sans-serif;
      background-color: #f8f9fa;
      color: #333;
      padding-top: 60px;
    }
    
    #sidebar {
      width: 220px;
      height: calc(100vh - 60px);
      background: linear-gradient(135deg, #2c3e50, #34495e);
      position: fixed;
      left: 0;
      top: 60px;
      padding-top: 20px;
      box-shadow: 2px 0 15px rgba(0,0,0,0.1);
      z-index: 1020;
      overflow-y: auto;
    }
    
    #content {
      margin-left: 220px;
      padding: 20px;
      transition: all 0.3s;
    }
    
    .page-title {
      color: #d32f2f;
      font-weight: 700;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
    }
    
    .page-title i {
      margin-right: 15px;
      font-size: 1.5rem;
    }
    
    .password-card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }
    
    .card-header {
      background-color: white;
      border-bottom: 1px solid rgba(0,0,0,0.05);
      font-weight: 600;
      padding: 15px 25px;
      border-radius: 10px 10px 0 0 !important;
    }
    
    .form-label {
      font-weight: 500;
      color: #555;
    }
    
    .form-control {
      border-radius: 8px;
      padding: 12px 15px;
      border: 1px solid #ddd;
      transition: all 0.3s;
    }
    
    .form-control:focus {
      border-color: #d32f2f;
      box-shadow: 0 0 0 0.2rem rgba(211, 47, 47, 0.1);
    }
    
    .btn-save {
      background: #d32f2f;
      border: none;
      padding: 12px 30px;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.3s;
    }
    
    .btn-save:hover {
      background: #b71c1c;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(183, 28, 28, 0.2);
    }
    
    .password-strength {
      height: 5px;
      margin-top: 5px;
      border-radius: 5px;
      transition: all 0.3s;
    }
    
    .strength-weak {
      background-color: #dc3545;
      width: 25%;
    }
    
    .strength-medium {
      background-color: #ffc107;
      width: 50%;
    }
    
    .strength-strong {
      background-color: #28a745;
      width: 100%;
    }
    
    .login-alert {
      max-width: 500px;
      margin: 100px auto;
      text-align: center;
    }
    
    @media (max-width: 992px) {
      #sidebar {
        transform: translateX(-220px);
      }
      
      #content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>
  <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
  
  <div id="header">
    <?php include 'header.php'; ?>
  </div>
  
  <div id="sidebar">
    <?php $active=""; include 'sidebar.php'; ?>
  </div>
  
  <div id="content">
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h1 class="page-title">
              <i class="fas fa-key"></i> Change Password
            </h1>
            <hr>
          </div>
        </div>
        
        <?php
        if(isset($_POST["submit"])) {
          $username = $_SESSION['username'];
          $password = mysqli_real_escape_string($conn, $_POST["currpassword"]);
          
          $sql = "SELECT * FROM admin_info WHERE admin_username='$username'";
          $result = mysqli_query($conn, $sql) or die("Query failed.");
          
          if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            
            if($password == $row['admin_password']) {
              $newpassword = mysqli_real_escape_string($conn, $_POST["newpassword"]);
              $confpassword = mysqli_real_escape_string($conn, $_POST["confirmpassword"]);
              
              if($newpassword == $confpassword) {
                if($newpassword != $password) {
                  $sql1 = "UPDATE admin_info SET admin_password='{$newpassword}' WHERE admin_username='{$username}'";
                  $result1 = mysqli_query($conn, $sql1);
                  
                  if($result1) {
                    echo '<div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fas fa-check-circle"></i> <strong>Success!</strong> Password changed successfully.
                          </div>';
                  }
                } else {
                  echo '<div class="alert alert-info alert-dismissible fade show">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <i class="fas fa-info-circle"></i> <strong>Note:</strong> New password cannot be same as current password.
                        </div>';
                }
              } else {
                echo '<div class="alert alert-warning alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fas fa-exclamation-triangle"></i> <strong>Warning!</strong> New password and confirm password do not match.
                      </div>';
              }
            } else {
              echo '<div class="alert alert-danger alert-dismissible fade show">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <i class="fas fa-times-circle"></i> <strong>Error!</strong> Current password is incorrect.
                    </div>';
            }
          }
        }
        ?>
        
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="password-card card">
              <div class="card-header">
                <h5 class="mb-0">Update Your Password</h5>
              </div>
              <div class="card-body">
                <form method="post" name="chngpwd">
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label form-label">Current Password</label>
                    <div class="col-md-8">
                      <div class="input-group">
                        <input type="password" class="form-control" name="currpassword" id="currentPassword" required>
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#currentPassword">
                            <i class="fas fa-eye"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label form-label">New Password</label>
                    <div class="col-md-8">
                      <div class="input-group">
                        <input type="password" class="form-control" name="newpassword" id="newPassword" required>
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#newPassword">
                            <i class="fas fa-eye"></i>
                          </button>
                        </div>
                      </div>
                      <div class="password-strength" id="passwordStrength"></div>
                      <small class="form-text text-muted">Use 8 or more characters with a mix of letters, numbers & symbols</small>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label form-label">Confirm Password</label>
                    <div class="col-md-8">
                      <div class="input-group">
                        <input type="password" class="form-control" name="confirmpassword" id="confirmPassword" required>
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#confirmPassword">
                            <i class="fas fa-eye"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group row mt-4">
                    <div class="col-md-8 offset-md-4">
                      <button type="submit" name="submit" class="btn btn-save">
                        <i class="fas fa-save mr-2"></i> Save Changes
                      </button>
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
  
  <?php } else { ?>
  <div class="alert alert-danger login-alert">
    <h4><i class="fas fa-exclamation-triangle"></i> Access Denied</h4>
    <p class="mb-4"><b>Please login first to access the admin portal</b></p>
    <a href="login.php" class="btn btn-danger">
      <i class="fas fa-sign-in-alt"></i> Go to Login Page
    </a>
  </div>
  <?php } ?>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
  <script>
    // Toggle password visibility
    $(document).on('click', '.toggle-password', function() {
      const target = $(this).data('target');
      const input = $(target);
      const icon = $(this).find('i');
      
      if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
      }
    });
    
    // Password strength indicator
    $('#newPassword').on('keyup', function() {
      const password = $(this).val();
      const strengthBar = $('#passwordStrength');
      
      // Reset strength bar
      strengthBar.removeClass('strength-weak strength-medium strength-strong');
      
      if (password.length === 0) {
        strengthBar.css('width', '0%');
        return;
      }
      
      // Very simple strength check (you can enhance this)
      if (password.length < 6) {
        strengthBar.addClass('strength-weak');
      } else if (password.length < 10) {
        strengthBar.addClass('strength-medium');
      } else {
        strengthBar.addClass('strength-strong');
      }
    });
  </script>
</body>
</html>