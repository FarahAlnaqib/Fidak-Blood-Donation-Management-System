<?php 
include 'conn.php';
include 'session.php';

// Handle delete action
if(isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $sql = "DELETE FROM donor_details WHERE donor_id = $id";
    if(mysqli_query($conn, $sql)) {
        header("Location: donor_list.php?deleted=1");
        exit();
    } else {
        header("Location: donor_list.php?error=delete_failed");
        exit();
    }
}

// Handle search
$search = '';
if(isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fidak (BBMS) - Donor List</title>
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
    }
    
    .table td {
      vertical-align: middle;
    }
    
    .action-btn {
      padding: 5px 12px;
      border-radius: 4px;
      font-size: 0.8rem;
      font-weight: 500;
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
    
    .search-box {
      max-width: 300px;
      margin-bottom: 20px;
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
    <?php $active="list"; include 'sidebar.php'; ?>
  </div>
  
  <div id="content">
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h1 class="page-title">
              <i class="fas fa-list-ul"></i> Donor List
            </h1>
            <hr>
          </div>
        </div>
        
        <div class="card">
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col-md-6">
                <h5 class="mb-0">All Registered Donors</h5>
              </div>
              <div class="col-md-6 text-right">
                <form method="GET" class="form-inline float-right">
                  <div class="input-group search-box">
                    <input type="text" name="search" class="form-control" placeholder="Search donors..." value="<?php echo htmlspecialchars($search); ?>">
                    <div class="input-group-append">
                      <button class="btn btn-danger" type="submit">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          
          <div class="card-body">
            <?php if(isset($_GET['deleted'])) { ?>
              <div class="alert alert-success">Donor deleted successfully!</div>
            <?php } elseif(isset($_GET['error'])) { ?>
              <div class="alert alert-danger">Error deleting donor. Please try again.</div>
            <?php } elseif(isset($_GET['updated'])) { ?>
              <div class="alert alert-success">Donor updated successfully!</div>
            <?php } ?>
            
            <?php
            $limit = 10;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
            $count = $offset + 1;
            
            $sql = "SELECT d.*, b.blood_group 
                    FROM donor_details d
                    LEFT JOIN blood b ON d.donor_blood = b.blood_group";
            
            if(!empty($search)) {
                $sql .= " WHERE d.donor_name LIKE '%$search%' 
                          OR d.donor_number LIKE '%$search%'
                          OR d.donor_mail LIKE '%$search%'
                          OR b.blood_group LIKE '%$search%'";
            }
            
            $sql .= " ORDER BY d.donor_id DESC LIMIT {$offset},{$limit}";
            
            $result = mysqli_query($conn, $sql);
            
            $count_sql = "SELECT COUNT(*) as total FROM donor_details d
                          LEFT JOIN blood b ON d.donor_blood = b.blood_group";
            
            if(!empty($search)) {
                $count_sql .= " WHERE d.donor_name LIKE '%$search%' 
                              OR d.donor_number LIKE '%$search%'
                              OR d.donor_mail LIKE '%$search%'
                              OR b.blood_group LIKE '%$search%'";
            }
            
            $count_result = mysqli_query($conn, $count_sql);
            $total_row = mysqli_fetch_assoc($count_result);
            $total_records = $total_row['total'];
            $total_page = ceil($total_records / $limit);
            
            if(mysqli_num_rows($result) > 0) {
            ?>
            
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="thead-light">
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Blood Group</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($result)) { ?>
                  <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo htmlspecialchars($row['donor_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['donor_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['donor_mail']); ?></td>
                    <td><?php echo htmlspecialchars($row['donor_age']); ?></td>
                    <td><?php echo htmlspecialchars($row['donor_gender']); ?></td>
                    <td>
                      <span class="badge badge-danger">
                        <?php echo htmlspecialchars($row['blood_group']); ?>
                      </span>
                    </td>
                    <td>
                      <div class="btn-group">
                        <a href='view_donor.php?id=<?php echo $row['donor_id']; ?>' 
                           class="btn btn-sm btn-outline-primary" title="View">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href='edit_donor.php?id=<?php echo $row['donor_id']; ?>' 
                           class="btn btn-sm btn-outline-success" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        <a href='donor_list.php?delete_id=<?php echo $row['donor_id']; ?>' 
                           class="btn btn-sm btn-outline-danger" title="Delete"
                           onclick="return confirm('Are you sure you want to delete this donor?')">
                          <i class="fas fa-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            
            <?php if($total_page > 1) { ?>
            <nav aria-label="Page navigation">
              <ul class="pagination">
                <?php if($page > 1) { ?>
                <li class="page-item">
                  <a class="page-link" href="donor_list.php?page=<?php echo $page-1; ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo; Prev</span>
                  </a>
                </li>
                <?php } ?>
                
                <?php for($i = 1; $i <= $total_page; $i++) { ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                  <a class="page-link" href="donor_list.php?page=<?php echo $i; ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>"><?php echo $i; ?></a>
                </li>
                <?php } ?>
                
                <?php if($total_page > $page) { ?>
                <li class="page-item">
                  <a class="page-link" href="donor_list.php?page=<?php echo $page+1; ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>" aria-label="Next">
                    <span aria-hidden="true">Next &raquo;</span>
                  </a>
                </li>
                <?php } ?>
              </ul>
            </nav>
            <?php } ?>
            
            <?php } else { ?>
            <div class="alert alert-info text-center">
              <i class="fas fa-info-circle"></i> No donor records found.
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