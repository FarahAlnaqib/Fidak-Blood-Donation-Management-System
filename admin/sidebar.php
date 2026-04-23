<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fidak (BBMS) - Admin Panel</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      font-family: 'Noto Kufi Arabic', sans-serif;
      padding-top: 60px; /* Space for fixed navbar */
      background-color: #f8f9fa;
    }
    
    /* Header Styles */
    .navbar {
      background: linear-gradient(135deg, #d32f2f, #b71c1c);
      padding: 0.5rem 1rem;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1030;
      height: 60px;
    }
    
    .navbar-brand {
      font-size: 1.5rem;
      font-weight: 700;
      color: white !important;
      display: flex;
      align-items: center;
      margin-left: 220px; /* Account for sidebar width */
    }
    
    /* Sidebar Styles */
    .sidebar {
      width: 220px;
      height: calc(100vh - 60px);
      background: linear-gradient(135deg, #2c3e50, #34495e);
      position: fixed;
      left: 0;
      top: 60px; /* Below navbar */
      padding-top: 20px;
      box-shadow: 2px 0 15px rgba(0,0,0,0.1);
      z-index: 1020;
      overflow-y: auto;
    }
    
    .sidebar-menu {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    
    .sidebar-menu a {
      display: flex;
      align-items: center;
      color: rgba(255,255,255,0.8);
      padding: 15px 20px;
      text-decoration: none;
      font-weight: 500;
      font-size: 15px;
      transition: all 0.3s;
      border-left: 4px solid transparent;
    }
    
    .sidebar-menu a:hover:not(.active) {
      background: rgba(255,255,255,0.1);
      color: white;
      border-left: 4px solid rgba(255,255,255,0.3);
    }
    
    .sidebar-menu i {
      width: 25px;
      font-size: 18px;
      margin-right: 10px;
      text-align: center;
    }
    
    .active {
      background: linear-gradient(to right, #d32f2f, #b71c1c);
      color: white !important;
      border-left: 4px solid white !important;
    }
    
    /* Content Area */
    #content {
      margin-left: 220px;
      padding: 20px;
      transition: all 0.3s;
    }
    
    /* User Dropdown */
    .user-menu {
      display: flex;
      align-items: center;
      margin-left: auto;
    }
    
    .dropdown-menu {
      border: none;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      border-radius: 8px;
      padding: 0;
      overflow: hidden;
      right: 0;
      left: auto;
    }
    
    /* Responsive Styles */
    @media (max-width: 992px) {
      .navbar-brand {
        margin-left: 0;
      }
      
      .sidebar {
        transform: translateX(-220px);
      }
      
      #content {
        margin-left: 0;
      }
      
      .sidebar.active {
        transform: translateX(0);
      }
    }
  </style>
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <button class="navbar-toggler d-lg-none" type="button" id="sidebarToggle">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <a class="navbar-brand" href="dashboard.php">
      <i class="fas fa-tint mr-2"></i>Fidak (BBMS) Admin
    </a>
    
    <div class="user-menu">
      <div class="dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle mr-2"></i>
          <?php
            include 'conn.php';
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM admin_info WHERE admin_username='$username'";
            $result = mysqli_query($conn, $sql) or die("Query failed.");
            $row = mysqli_fetch_assoc($result);
            echo $row['admin_name'];
          ?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="change_password.php">
            <i class="fas fa-key mr-2"></i>Change Password
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">
            <i class="fas fa-sign-out-alt mr-2"></i>Logout
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Sidebar -->
<div class="sidebar">
  <ul class="sidebar-menu">
    <li>
      <a href="dashboard.php" <?php if($active=='dashboard') echo "class='active'"; ?>>
        <i class="fas fa-tachometer-alt"></i> Dashboard
      </a>
    </li>
    <li>
      <a href="add_donor.php" <?php if($active=='add') echo "class='active'"; ?>>
        <i class="fas fa-user-plus"></i> Add Donor
      </a>
    </li>
    <li>
      <a href="donor_list.php" <?php if($active=='list') echo "class='active'"; ?>>
        <i class="fas fa-list-ul"></i> Donor List
      </a>
    </li>
    <li>
      <a href="query.php" <?php if($active=='query') echo "class='active'"; ?>>
        <i class="fas fa-question-circle"></i> Contact Queries
      </a>
    </li>
    <li>
      <a href="pages.php" <?php if($active=='pages') echo "class='active'"; ?>>
        <i class="fas fa-file-alt"></i> Manage Pages
      </a>
    </li>
    <li>
      <a href="update_contact.php" <?php if($active=='contact') echo "class='active'"; ?>>
        <i class="fas fa-address-card"></i> Contact Info
      </a>
    </li>
  </ul>
</div>

<!-- Main Content -->
<div id="content">
  <!-- Your page content goes here -->
</div>

<!-- JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  // Toggle sidebar on mobile
  $(document).ready(function() {
    $('#sidebarToggle').click(function() {
      $('.sidebar').toggleClass('active');
    });
    
    // Close sidebar when clicking outside
    $(document).click(function(e) {
      if (!$(e.target).closest('.sidebar').length && !$(e.target).closest('#sidebarToggle').length) {
        $('.sidebar').removeClass('active');
      }
    });
  });
</script>

</body>
</html>