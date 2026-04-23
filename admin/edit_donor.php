<?php
include 'conn.php';
include 'session.php';

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM donor_details WHERE donor_id = $id";
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

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $age = intval($_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $blood = intval($_POST['blood']);

    $update_sql = "UPDATE donor_details SET 
                  donor_name = '$name',
                  donor_mail = '$email',
                  donor_number = '$mobile',
                  donor_age = $age,
                  donor_gender = '$gender',
                  donor_blood = $blood
                  WHERE donor_id = $id";

    if(mysqli_query($conn, $update_sql)) {
        header("Location: donor_list.php?updated=1");
        exit();
    } else {
        $error = "Error updating donor: " . mysqli_error($conn);
    }
}

// Get blood groups for dropdown
$blood_sql = "SELECT * FROM blood";
$blood_result = mysqli_query($conn, $blood_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Donor - Fidak (BBMS)</title>
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
        .form-group {
            margin-bottom: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Edit Donor</h4>
                    </div>
                    <div class="card-body">
                        <?php if(isset($error)) { ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php } ?>
                        
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name *</label>
                                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($row['donor_name']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email *</label>
                                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['donor_mail']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile Number *</label>
                                        <input type="text" name="mobile" class="form-control" value="<?php echo htmlspecialchars($row['donor_number']); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Age *</label>
                                        <input type="number" name="age" class="form-control" value="<?php echo htmlspecialchars($row['donor_age']); ?>" required min="18" max="65">
                                    </div>
                                    <div class="form-group">
                                        <label>Gender *</label>
                                        <select name="gender" class="form-control" required>
                                            <option value="Male" <?php echo $row['donor_gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                            <option value="Female" <?php echo $row['donor_gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                            <option value="Other" <?php echo $row['donor_gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Blood Group *</label>
                                        <select name="blood" class="form-control" required>
                                            <?php 
                                            mysqli_data_seek($blood_result, 0);
                                            while($blood = mysqli_fetch_assoc($blood_result)) { ?>
                                                <option value="<?php echo $blood['blood_group']; ?>" <?php echo $blood['blood_group'] == $row['donor_blood'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($blood['blood_group']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-right mt-4">
                                <a href="donor_list.php" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>
                        </form>
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