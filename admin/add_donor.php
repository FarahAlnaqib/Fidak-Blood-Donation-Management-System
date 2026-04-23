<?php include 'session.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fidak (BBMS) - Add Donor</title>
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
    
    .form-section {
      background: white;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }
    
    .form-label {
      font-weight: 500;
      margin-bottom: 8px;
      color: #555;
    }
    
    .required-field::after {
      content: " *";
      color: #d32f2f;
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
    
    .btn-submit {
      background: #d32f2f;
      border: none;
      padding: 12px 30px;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.3s;
      min-width: 150px;
    }
    
    .btn-submit:hover {
      background: #b71c1c;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(183, 28, 28, 0.2);
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
      
      .navbar-brand {
        margin-left: 0 !important;
      }
    }
  </style>
</head>

<body>
  <?php
  include 'conn.php';
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  ?>
  
  <div id="header">
    <?php $active="add"; include 'header.php'; ?>
  </div>
  
  <div id="sidebar">
    <?php include 'sidebar.php'; ?>
  </div>
  
  <div id="content">
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h1 class="page-title">
              <i class="fas fa-user-plus"></i> Add New Donor
            </h1>
            <hr>
          </div>
        </div>
        
        <div class="form-section">
          <form name="donor" action="save_donor_data.php" method="post">
            <div class="row">
              <div class="col-lg-4 mb-4">
                <label class="form-label required-field">Full Name</label>
                <input type="text" name="fullname" class="form-control" required>
              </div>
              
              <div class="col-lg-4 mb-4">
                <label class="form-label required-field">Mobile Number</label>
                <input type="text" name="mobileno" class="form-control" required>
              </div>
              
              <div class="col-lg-4 mb-4">
                <label class="form-label">Email Address</label>
                <input type="email" name="emailid" class="form-control">
              </div>
            </div>

            <div class="row">
              <div class="col-lg-4 mb-4">
                <label class="form-label required-field">Age</label>
                <input type="text" name="age" class="form-control" required>
              </div>
              
              <div class="col-lg-4 mb-4">
                <label class="form-label required-field">Gender</label>
                <select name="gender" class="form-control" required>
                  <option value="">Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              
              <div class="col-lg-4 mb-4">
                <label class="form-label required-field">Blood Group</label>
                <select name="blood" class="form-control" required>
                  <option value="" selected disabled>Select Blood Group</option>
                  <?php
                    include 'conn.php';
                    $sql = "SELECT * FROM blood";
                    $result = mysqli_query($conn, $sql) or die("query unsuccessful.");
                    while($row = mysqli_fetch_assoc($result)) {
                  ?>
                  <option value="<?php echo $row['blood_group'] ?>"><?php echo $row['blood_group'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            
            <div class="row">
              <div class="col-lg-8 mb-4">
                <label class="form-label required-field">Address</label>
                <textarea class="form-control" name="address" rows="3" required></textarea>
              </div>
            </div>
            
            <div class="row mt-4">
              <div class="col-lg-4">
                <button type="submit" name="submit" class="btn btn-submit" onclick="popup()">
                  <i class="fas fa-save mr-2"></i> Save Donor
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <?php
  } else {
    echo '<div class="alert alert-danger login-alert">
            <h4><i class="fas fa-exclamation-triangle"></i> Access Denied</h4>
            <p class="mb-4"><b>Please login first to access the admin portal</b></p>
            <a href="login.php" class="btn btn-danger">
              <i class="fas fa-sign-in-alt"></i> Go to Login Page
            </a>
          </div>';
  }
  ?>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    function popup() {
      alert("Donor data added successfully.");
    }
  </script>
</body>
</html>