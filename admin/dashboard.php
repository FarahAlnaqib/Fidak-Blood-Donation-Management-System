<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fidak (BBMS) - Dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
  <style>
    body {
      font-family: 'Noto Kufi Arabic', sans-serif;
      background-color: #f8f9fa;
      color: #333;
    }
    
    #sidebar {
      position: fixed;
      width: 220px;
      height: 100%;
      background: linear-gradient(135deg, #2c3e50, #34495e);
      color: white;
      padding-top: 20px;
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
      z-index: 1000;
    }
    
    #content {
      margin-left: 220px;
      padding: 20px;
      transition: all 0.3s;
    }
    
    @media screen and (max-width: 768px) {
      #sidebar {
        width: 100%;
        height: auto;
        position: relative;
      }
      #content {
        margin-left: 0;
      }
    }
    
    .page-title {
      color: #d32f2f;
      font-weight: 700;
      margin-bottom: 20px;
      border-bottom: 2px solid #d32f2f;
      padding-bottom: 10px;
      display: inline-block;
    }
    
    .stat-card {
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      margin-bottom: 30px;
      border: none;
      transition: transform 0.3s;
      overflow: hidden;
    }
    
    .stat-card:hover {
      transform: translateY(-5px);
    }
    
    .stat-card-body {
      padding: 30px 20px;
      text-align: center;
    }
    
    .stat-number {
      font-size: 2.5rem;
      font-weight: 700;
      margin: 15px 0;
      color: #2c3e50;
    }
    
    .stat-title {
      font-size: 1.1rem;
      font-weight: 500;
      margin-bottom: 20px;
      color: #555;
    }
    
    .btn-detail {
      background: #d32f2f;
      border: none;
      padding: 10px 25px;
      font-weight: 500;
      border-radius: 50px;
      transition: all 0.3s;
    }
    
    .btn-detail:hover {
      background: #b71c1c;
      box-shadow: 0 5px 15px rgba(183, 28, 28, 0.3);
    }
    
    .card-donors {
      border-top: 5px solid #3498db;
    }
    
    .card-queries {
      border-top: 5px solid #2ecc71;
    }
    
    .card-pending {
      border-top: 5px solid #9b59b6;
    }
    
    .login-alert {
      max-width: 500px;
      margin: 100px auto;
      text-align: center;
    }
  </style>
</head>

<body>
  <?php
  include 'conn.php';
  include 'session.php';
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  ?>

  <div id="header">
    <?php include 'header.php'; ?>
  </div>
  
  <div id="sidebar">
    <?php 
    $active = "dashboard";
    include 'sidebar.php'; 
    ?>
  </div>
  
  <div id="content">
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h1 class="page-title">
              <i class="fas fa-tachometer-alt"></i> Dashboard Overview
            </h1>
            <hr>
          </div>
        </div>
        
        <div class="row">
          <!-- Donors Card -->
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card card-donors">
              <div class="stat-card-body">
                <?php
                $sql = "SELECT * FROM donor_details";
                $result = mysqli_query($conn, $sql) or die("query failed.");
                $row = mysqli_num_rows($result);
                ?>
                
                <i class="fas fa-users fa-3x" style="color: #3498db;"></i>
                <div class="stat-number"><?php echo $row; ?></div>
                <div class="stat-title">Blood Donors Available</div>
                <button class="btn btn-detail" onclick="window.location.href = 'donor_list.php';">
                  View Details <i class="fas fa-arrow-right ml-2"></i>
                </button>
              </div>
            </div>
          </div>
          
          <!-- All Queries Card -->
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card card-queries">
              <div class="stat-card-body">
                <?php
                $sql1 = "SELECT * FROM contact_query";
                $result1 = mysqli_query($conn, $sql1) or die("query failed.");
                $row1 = mysqli_num_rows($result1);
                ?>
                
                <i class="fas fa-question-circle fa-3x" style="color: #2ecc71;"></i>
                <div class="stat-number"><?php echo $row1; ?></div>
                <div class="stat-title">All User Queries</div>
                <button class="btn btn-detail" onclick="window.location.href = 'query.php';">
                  View Details <i class="fas fa-arrow-right ml-2"></i>
                </button>
              </div>
            </div>
          </div>
          
          <!-- Pending Queries Card -->
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card card-pending">
              <div class="stat-card-body">
                <?php
                $sql2 = "SELECT * FROM contact_query WHERE query_status=2";
                $result2 = mysqli_query($conn, $sql2) or die("query failed.");
                $row2 = mysqli_num_rows($result2);
                ?>
                
                <i class="fas fa-clock fa-3x" style="color: #9b59b6;"></i>
                <div class="stat-number"><?php echo $row2; ?></div>
                <div class="stat-title">Pending Queries</div>
                <button class="btn btn-detail" onclick="window.location.href = 'pending_query.php';">
                  View Details <i class="fas fa-arrow-right ml-2"></i>
                </button>
              </div>
            </div>
          </div>
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

</body>
</html>