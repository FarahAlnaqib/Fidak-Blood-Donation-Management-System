<?php 
include 'conn.php';
include 'session.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fidak (BBMS) - Pending Queries</title>
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
      text-align: center;
    }
    
    .status-badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 500;
    }
    
    .status-pending {
      background-color: #fff3cd;
      color: #856404;
    }
    
    .status-read {
      background-color: #d4edda;
      color: #155724;
    }
    
    .action-btn {
      padding: 5px 12px;
      border-radius: 4px;
      font-size: 0.8rem;
      font-weight: 500;
      transition: all 0.2s;
    }
    
    .delete-btn {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
    
    .delete-btn:hover {
      background-color: #f1b0b7;
      color: #721c24;
      text-decoration: none;
    }
    
    .message-preview {
      max-width: 300px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
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
      
      .table td, .table th {
        padding: 0.75rem 0.5rem;
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
    <?php $active="query"; include 'sidebar.php'; ?>
  </div>
  
  <div id="content">
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h1 class="page-title">
              <i class="fas fa-clock"></i> Pending Queries
            </h1>
            <hr>
          </div>
        </div>
        
        <?php
        // Handle marking query as read
        if(isset($_GET['id'])) {
          $que_id = $_GET['id'];
          $sql1 = "UPDATE contact_query SET query_status='1' WHERE query_id={$que_id}";
          $result = mysqli_query($conn, $sql1);
          
          if($result) {
            echo '<div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="fas fa-check-circle"></i> Query marked as read successfully.
                  </div>';
          }
        }
        ?>
        
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <h5 class="mb-0">Unread Contact Queries</h5>
              </div>
              <div class="col-md-6 text-right">
                <?php
                $pending_sql = "SELECT COUNT(*) as pending FROM contact_query WHERE query_status > 1";
                $pending_result = mysqli_query($conn, $pending_sql);
                $pending_row = mysqli_fetch_assoc($pending_result);
                ?>
                <span class="badge badge-warning">
                  <?php echo $pending_row['pending'] . " Pending"; ?>
                </span>
              </div>
            </div>
          </div>
          
          <div class="card-body">
            <?php
            $limit = 10;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
            $count = $offset + 1;
            
            $sql = "SELECT * FROM contact_query WHERE query_status > 1 LIMIT {$offset},{$limit}";
            $result = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($result) > 0) {
            ?>
            
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="thead-light">
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($result)) { ?>
                  <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['query_name']; ?></td>
                    <td><?php echo $row['query_mail']; ?></td>
                    <td><?php echo $row['query_number']; ?></td>
                    <td class="message-preview" title="<?php echo htmlspecialchars($row['query_message']); ?>">
                      <?php echo substr($row['query_message'], 0, 30) . '...'; ?>
                    </td>
                    <td><?php echo date('d M Y', strtotime($row['query_date'])); ?></td>
                    <td>
                      <a href="pending_query.php?id=<?php echo $row['query_id'];?>" 
                         onclick="return confirm('Mark this query as read?')"
                         class="status-badge status-pending">Pending</a>
                    </td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" 
                                data-target="#messageModal<?php echo $row['query_id']; ?>" title="View Full Message">
                          <i class="fas fa-eye"></i>
                        </button>
                        <a href='delete_query.php?id=<?php echo $row['query_id']; ?>' 
                           class="btn btn-sm btn-outline-danger" title="Delete"
                           onclick="return confirm('Are you sure you want to delete this query?')">
                          <i class="fas fa-trash"></i>
                        </a>
                      </div>
                      
                      <!-- Message Modal -->
                      <div class="modal fade" id="messageModal<?php echo $row['query_id']; ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Query Details</h5>
                              <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p><strong>Name:</strong> <?php echo $row['query_name']; ?></p>
                              <p><strong>Email:</strong> <?php echo $row['query_mail']; ?></p>
                              <p><strong>Mobile:</strong> <?php echo $row['query_number']; ?></p>
                              <p><strong>Date:</strong> <?php echo date('d M Y, h:i A', strtotime($row['query_date'])); ?></p>
                              <hr>
                              <p><strong>Message:</strong></p>
                              <p><?php echo nl2br(htmlspecialchars($row['query_message'])); ?></p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <a href="pending_query.php?id=<?php echo $row['query_id'];?>" class="btn btn-primary">
                                Mark as Read
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            
            <?php 
            $total_sql = "SELECT COUNT(*) as total FROM contact_query WHERE query_status > 1";
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
                  <a class="page-link" href="pending_query.php?page=<?php echo $page-1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo; Prev</span>
                  </a>
                </li>
                <?php } ?>
                
                <?php for($i = 1; $i <= $total_page; $i++) { ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                  <a class="page-link" href="pending_query.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
                <?php } ?>
                
                <?php if($total_page > $page) { ?>
                <li class="page-item">
                  <a class="page-link" href="pending_query.php?page=<?php echo $page+1; ?>" aria-label="Next">
                    <span aria-hidden="true">Next &raquo;</span>
                  </a>
                </li>
                <?php } ?>
              </ul>
            </nav>
            <?php } ?>
            
            <?php } else { ?>
            <div class="alert alert-info text-center">
              <i class="fas fa-info-circle"></i> No pending queries found.
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