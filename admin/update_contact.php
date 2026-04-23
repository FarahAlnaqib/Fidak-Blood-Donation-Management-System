<?php 
include 'conn.php';
include 'session.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fidak (BBMS) - Update Contact Info</title>
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
    
    .contact-card {
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
    
    .btn-update {
      background: #d32f2f;
      border: none;
      padding: 12px 30px;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.3s;
    }
    
    .btn-update:hover {
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
    }
  </style>
</head>
<body>
  <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { 
    // Fetch current contact info
    $sql = "SELECT * FROM contact_info WHERE contact_id='1'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
  ?>
  
  <div id="header">
    <?php include 'header.php'; ?>
  </div>
  
  <div id="sidebar">
    <?php $active="contact"; include 'sidebar.php'; ?>
  </div>
  
  <div id="content">
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h1 class="page-title">
              <i class="fas fa-address-book"></i> Update Contact Information
            </h1>
            <hr>
          </div>
        </div>
        
        <?php 
        if(isset($_POST['update'])) {
          $address = mysqli_real_escape_string($conn, $_POST['address']);
          $email = mysqli_real_escape_string($conn, $_POST['email']);
          $number = mysqli_real_escape_string($conn, $_POST['contactno']);
          
          $sql = "UPDATE contact_info SET 
                  contact_address='{$address}', 
                  contact_mail='{$email}', 
                  contact_phone='{$number}' 
                  WHERE contact_id='1'";
          $result = mysqli_query($conn, $sql);
          
          if($result) {
            echo '<div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><i class="fas fa-check-circle"></i> Success!</strong> Contact details updated successfully.
                  </div>';
            
            // Refresh the data
            $sql = "SELECT * FROM contact_info WHERE contact_id='1'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
          } else {
            echo '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><i class="fas fa-exclamation-circle"></i> Error!</strong> Failed to update contact details.
                  </div>';
          }
        }
        ?>
        
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="contact-card card">
              <div class="card-header">
                <h5 class="mb-0">Current Contact Details</h5>
              </div>
              <div class="card-body">
                <form method="post" name="change_contact">
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label form-label">Address</label>
                    <div class="col-md-9">
                      <textarea class="form-control" name="address" id="address" rows="3" required><?php echo $row['contact_address'] ?? ''; ?></textarea>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label form-label">Email Address</label>
                    <div class="col-md-9">
                      <input type="email" class="form-control" name="email" id="email" value="<?php echo $row['contact_mail'] ?? ''; ?>" required>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label form-label">Contact Number</label>
                    <div class="col-md-9">
                      <input type="text" class="form-control" name="contactno" id="contactno" value="<?php echo $row['contact_phone'] ?? ''; ?>" required>
                    </div>
                  </div>
                  
                  <div class="form-group row mt-4">
                    <div class="col-md-9 offset-md-3">
                      <button type="submit" name="update" class="btn btn-update">
                        <i class="fas fa-save mr-2"></i> Update Contact Info
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
</body>
</html>