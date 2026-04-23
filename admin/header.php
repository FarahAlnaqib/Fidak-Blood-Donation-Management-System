<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    body {
      font-family: 'Noto Kufi Arabic', sans-serif;
    }
    .navbar {
      background: linear-gradient(135deg, #d32f2f, #b71c1c);
      padding: 0.5rem 1rem;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    .navbar-brand {
      font-size: 1.5rem;
      font-weight: 700;
      color: white !important;
      display: flex;
      align-items: center;
      margin-right: 0;
    }
    .navbar-brand:hover {
      color: #f8f9fa !important;
      text-decoration: none;
    }
    .blood-drop-icon {
      margin-right: 10px;
    }
    .user-menu {
      display: flex;
      align-items: center;
      margin-left: auto;
    }
    .user-greeting {
      color: white;
      font-weight: 500;
      padding: 0.5rem 0.8rem;
      border-radius: 4px;
      transition: all 0.3s;
      cursor: pointer;
      display: flex;
      align-items: center;
    }
    .user-greeting:hover {
      background-color: rgba(255,255,255,0.1);
      text-decoration: none;
    }
    .user-icon {
      margin-right: 8px;
      font-size: 1.2rem;
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
    .dropdown-item {
      padding: 0.75rem 1.5rem;
      transition: all 0.2s;
      font-family: 'Noto Kufi Arabic', sans-serif;
    }
    .dropdown-item:hover {
      background-color: #f8f9fa;
      color: #d32f2f !important;
    }
    .dropdown-divider {
      margin: 0;
    }
    .caret-icon {
      margin-left: 8px;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">
      <i class="fas fa-tint blood-drop-icon"></i>Fidak (BBMS) Admin
    </a>
    
    <div class="user-menu">
      <div class="dropdown">
        <a class="user-greeting dropdown-toggle" href="#" role="button" id="userDropdown" data-toggle="dropdown">
          <i class="fas fa-user-circle user-icon"></i>
          <?php
            include 'conn.php';
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM admin_info WHERE admin_username='$username'";
            $result = mysqli_query($conn, $sql) or die("Query failed.");
            $row = mysqli_fetch_assoc($result);
            echo $row['admin_name'];
          ?>
          <i class="fas fa-caret-down caret-icon"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="userDropdown">
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

</body>
</html>