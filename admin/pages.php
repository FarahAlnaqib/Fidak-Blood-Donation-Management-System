<?php 
include 'conn.php';
include 'session.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fidak (BBMS) - Manage Pages</title>
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
    
    .card {
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
    }
    
    .table {
      margin-bottom: 0;
    }
    
    .table th {
      border-top: none;
      font-weight: 600;
      color: #555;
      text-transform: uppercase;
      font-size: 0.8rem;
      letter-spacing: 0.5px;
      text-align: center;
    }
    
    .table td {
      vertical-align: middle;
    }
    
    .page-data {
      max-height: 120px;
      overflow-y: auto;
      text-align: left;
      padding: 10px;
      background: #f8f9fa;
      border-radius: 5px;
      border: 1px solid #eee;
    }
    
    .edit-btn {
      background-color: #d1ecf1;
      color: #0c5460;
      padding: 8px 15px;
      border-radius: 4px;
      transition: all 0.2s;
    }
    
    .edit-btn:hover {
      background-color: #bee5eb;
      color: #0c5460;
      text-decoration: none;
      transform: translateY(-2px);
    }
    
    .pagination {
      justify-content: center;
      margin-top: 20px;
    }
    
    .page-item.active .page-link {
      background-color: #d32f2f;
      border-color: #d32f2f;
    }
    
    .page-link {
      color: #d32f2f;
      margin: 0 5px;
      border-radius: 4px !important;
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
    
    @media (max-width: 768px) {
      .table-responsive {
        border: none;
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
    <?php $active="pages"; include 'sidebar.php'; ?>
  </div>
  
  <div id="content">
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h1 class="page-title">
              <i class="fas fa-file-alt"></i> Manage Page Content
            </h1>
            <hr>
          </div>
        </div>
        
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <h5 class="mb-0">All Website Pages</h5>
              </div>
              <div class="col-md-6 text-right">
                <?php
                $total_sql = "SELECT COUNT(*) as total FROM pages";
                $total_result = mysqli_query($conn, $total_sql);
                $total_row = mysqli_fetch_assoc($total_result);
                ?>
                <span class="badge badge-primary">
                  <?php echo $total_row['total'] . " Pages"; ?>
                </span>
              </div>
            </div>
          </div>
          
          <div class="card-body">
            <?php
            $limit = 5;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
            $count = $offset + 1;
            
            $sql = "SELECT * FROM pages LIMIT {$offset},{$limit}";
            $result = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($result) > 0) {
            ?>
            
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="thead-light">
                  <tr>
                    <th>#</th>
                    <th>Page Name</th>
                    <th>Page Type</th>
                    <th>Content Preview</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($result)) { ?>
                  <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['page_name']; ?></td>
                    <td><?php echo $row['page_type']; ?></td>
                    <td>
                      <div class="page-data">
                        <?php echo substr(strip_tags($row['page_data']), 0, 100) . '...'; ?>
                      </div>
                    </td>
                    <td>
                      <a href='update_page_details.php?type=<?php echo $row['page_type'];?>' 
                         class="edit-btn" title="Edit Page">
                        <i class="fas fa-edit mr-1"></i> Edit
                      </a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            
            <?php 
            $total_sql = "SELECT COUNT(*) as total FROM pages";
            $total_result = mysqli_query($conn, $total_sql);
            $total_row = mysqli_fetch_assoc($total_result);
            $total_records = $total_row['total'];
            $total_page = ceil($total_records / $limit);
            
            if($total_page > 1) {
            ?>
            <nav aria-label="Page navigation">
              <ul class="pagination">
                <?php if($page > 1) { ?>
                <li class="page-item">
                  <a class="page-link" href="pages.php?page=<?php echo $page-1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo; Prev</span>
                  </a>
                </li>
                <?php } ?>
                
                <?php for($i = 1; $i <= $total_page; $i++) { ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                  <a class="page-link" href="pages.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
                <?php } ?>
                
                <?php if($total_page > $page) { ?>
                <li class="page-item">
                  <a class="page-link" href="pages.php?page=<?php echo $page+1; ?>" aria-label="Next">
                    <span aria-hidden="true">Next &raquo;</span>
                  </a>
                </li>
                <?php } ?>
              </ul>
            </nav>
            <?php } ?>
            
            <?php } else { ?>
            <div class="alert alert-info text-center">
              <i class="fas fa-info-circle"></i> No pages found.
            </div>
            <?php } ?>
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