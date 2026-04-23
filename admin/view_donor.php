<?php
include 'conn.php';
include 'session.php';

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT d.*, b.blood_group 
            FROM donor_details d
            LEFT JOIN blood b ON d.donor_blood = b.blood_group
            WHERE d.donor_id = $id";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        header("Location: donor_list.php?error=notfound");
        exit();
    }
} else {
    header("Location: donor_list.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Donor - Fidak (BBMS)</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Noto Kufi Arabic', sans-serif;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .card-header {
            background-color: #d32f2f;
            color: white;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .info-value {
            padding-left: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Donor Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><span class="info-label">Name:</span> 
                                <span class="info-value"><?php echo htmlspecialchars($row['donor_name']); ?></span></p>
                                
                                <p><span class="info-label">Email:</span>
                                <span class="info-value"><?php echo htmlspecialchars($row['donor_mail']); ?></span></p>
                                
                                <p><span class="info-label">Mobile:</span>
                                <span class="info-value"><?php echo htmlspecialchars($row['donor_number']); ?></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><span class="info-label">Age:</span>
                                <span class="info-value"><?php echo htmlspecialchars($row['donor_age']); ?></span></p>
                                
                                <p><span class="info-label">Gender:</span>
                                <span class="info-value"><?php echo htmlspecialchars($row['donor_gender']); ?></span></p>
                                
                                <p><span class="info-label">Blood Group:</span>
                                <span class="info-value"><span class="badge badge-danger"><?php echo htmlspecialchars($row['blood_group']); ?></span></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="donor_list.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="edit_donor.php?id=<?php echo $row['donor_id']; ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>