<?php 
include 'conn.php';
include 'session.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fidak (BBMS) - Update Page Content</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script type="text/javascript" src="nicEdit.js"></script>
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
    
    .editor-card {
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
    
    /* NicEditor Customization */
    #area4 {
      width: 100%;
      min-height: 400px;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
    }
    
    .nicEdit-panel {
      background: #f8f9fa !important;
      border-radius: 8px 8px 0 0 !important;
      border: 1px solid #ddd !important;
      border-bottom: none !important;
    }
    
    .nicEdit-main {
      padding: 15px !important;
      border-radius: 0 0 8px 8px !important;
      border: 1px solid #ddd !important;
      border-top: none !important;
      min-height: 300px;
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
      #area4 {
        width: 100%;
        min-height: 300px;
      }
      
      .nicEdit-panel > div > * {
        opacity: 1 !important;
      }
      
      .nicEdit-buttonContain {
        padding: .5em;
      }
      
      .nicEdit-selectContain {
        margin-top: 8px;
        padding: .5em;
      }
      
      .nicEdit-selectTxt {
        font-family: Tahoma !important;
        font-size: 12px !important;
      }
    }
  </style>
</head>
<body>
  <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { 
    $page_type = isset($_GET['type']) ? $_GET['type'] : '';
    $page_title = '';
    
    switch($page_type) {
      case "aboutus":
        $page_title = "About Us";
        break;
      case "donor":
        $page_title = "Why Donate Blood";
        break;
      case "needforblood":
        $page_title = "The Need For Blood";
        break;
      case "bloodtips":
        $page_title = "Blood Tips";
        break;
      case "whoyouhelp":
        $page_title = "Who You Could Help";
        break;
      case "bloodgroups":
        $page_title = "Blood Groups";
        break;
      case "universal":
        $page_title = "Universal Donors And Recipients";
        break;
      default:
        $page_title = "Page Content";
    }
    
    // Get current page content
    $sql = "SELECT page_data FROM pages WHERE page_type='{$page_type}'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $current_content = $row['page_data'] ?? '';
  ?>
  
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
              <i class="fas fa-edit"></i> Update Page Content
            </h1>
            <hr>
          </div>
        </div>
        
        <?php 
        if(isset($_POST['submit'])) {
          $data = mysqli_real_escape_string($conn, $_POST['data']);
          $sql = "UPDATE pages SET page_data='{$data}' WHERE page_type='{$page_type}'";
          $result = mysqli_query($conn, $sql);
          
          if($result) {
            echo '<div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><i class="fas fa-check-circle"></i> Success!</strong> Page content updated successfully.
                  </div>';
            
            // Refresh the content
            $sql = "SELECT page_data FROM pages WHERE page_type='{$page_type}'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $current_content = $row['page_data'];
          } else {
            echo '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><i class="fas fa-exclamation-circle"></i> Error!</strong> Failed to update page content.
                  </div>';
          }
        }
        ?>
        
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="editor-card card">
              <div class="card-header">
                <h5 class="mb-0">Editing: <?php echo $page_title; ?></h5>
              </div>
              <div class="card-body">
                <form name="update_page" method="post">
                  <div class="form-group row">
                    <label class="col-md-2 col-form-label form-label">Page Content:</label>
                    <div class="col-md-10">
                      <textarea cols="60" rows="10" id="area4" name="data"><?php echo htmlspecialchars($current_content); ?></textarea>
                    </div>
                  </div>
                  
                  <div class="form-group row mt-4">
                    <div class="col-md-10 offset-md-2">
                      <button type="submit" name="submit" class="btn btn-update">
                        <i class="fas fa-save mr-2"></i> Update Content
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
  
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
      new nicEditor({
        buttonList : ['fontSize','fontFamily','fontFormat','bold','italic','underline','strikeThrough','subscript','superscript','left','center','right','justify','ol','ul','indent','outdent','image','upload','link','unlink','forecolor','bgcolor','xhtml'],
        iconsPath : 'nicEditorIcons.gif'
      }).panelInstance('area4');
    });
  </script>
  
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