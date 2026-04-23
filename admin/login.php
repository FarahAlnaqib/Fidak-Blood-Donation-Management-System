<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Fidak (BBMS)">
  <meta name="author" content="">
  <title>Fidak (BBMS) - Admin Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    body {
      font-family: 'Noto Kufi Arabic', sans-serif;
      background: 
    linear-gradient(rgba(0,0,0,0.6), rgba(70,10,10,0.8)),
    url('https://images.pexels.com/photos/3825586/pexels-photo-3825586.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') 
    no-repeat center center/cover fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      align-items: center;
    }
    .login-container {
      max-width: 600px;
      margin: 0 auto;
    }
    .login-card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      background: rgba(255,255,255,0.95);
    }
    .login-header {
      background: #d32f2f;
      color: white;
      padding: 20px;
      text-align: center;
      border-radius: 10px 10px 0 0;
    }
    .login-body {
      padding: 30px;
    }
    .form-control {
      border-radius: 5px;
      padding: 12px 15px;
    }
    .btn-login {
      background: #d32f2f;
      border: none;
      padding: 12px 30px;
      font-weight: bold;
    }
    .btn-login:hover {
      background: #b71c1c;
    }
    .input-group-text {
      background: #d32f2f;
      color: white;
      border: none;
    }
    .required-field::after {
      content: " *";
      color: #d32f2f;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="login-container">
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="login-card">
        <div class="login-header">
          <h2><i class="fas fa-tint"></i> Fidak (BBMS) & Management</h2>
          <p>Admin Login Portal</p>
        </div>
        
        <div class="login-body">
          <div class="form-group">
            <label for="username" class="required-field" style="font-weight:bold">Username</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
              <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
            </div>
          </div>
          
          <div class="form-group">
            <label for="password" class="required-field" style="font-weight:bold">Password</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
              </div>
              <input type="password" name="password" class="form-control" placeholder="Enter your Password" required>
            </div>
          </div>
          
          <div class="form-group text-center mt-4">
            <button type="submit" name="login" class="btn btn-login btn-block">
              <i class="fas fa-sign-in-alt"></i> LOGIN
            </button>
          </div>
          
          <?php
            include 'conn.php';

            if(isset($_POST["login"])){
              $username=mysqli_real_escape_string($conn,$_POST["username"]);
              $password=mysqli_real_escape_string($conn,$_POST["password"]);

              $sql="SELECT * from admin_info where admin_username='$username' and admin_password='$password'";
              $result=mysqli_query($conn,$sql) or die("query failed.");

              if(mysqli_num_rows($result)>0) {
                while($row=mysqli_fetch_assoc($result)){
                  session_start();
                  $_SESSION['loggedin'] = true;
                  $_SESSION["username"]=$username;
                  header("Location: dashboard.php");
                }
              }
              else {
                echo '<div class="alert alert-danger mt-3" style="font-weight:bold"> 
                  <i class="fas fa-exclamation-circle"></i> Username and Password are not matched!
                </div>';
              }
            }
          ?>
        </div>
      </div>
    </form>
  </div>
</div>

</body>
</html>