<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Need Blood - Fidak (BBMS)</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #e53935;
            --primary-dark: #c62828;
            --secondary: #f5f5f5;
            --dark: #212121;
            --light: #ffffff;
            --gray: #757575;
        }
        
        body {
            font-family: 'Poppins', 'Noto Kufi Arabic', sans-serif;
            background-color: #fafafa;
            color: var(--dark);
            line-height: 1.8;
        }
        
        .need-blood-section {
            padding: 80px 0;
        }
        
        .section-title {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }
        
        .search-form {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 8px;
        }
        
        .required-field:after {
            content: '*';
            color: var(--primary);
            margin-left: 4px;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(229, 57, 53, 0.25);
        }
        
        select.form-control {
            height: auto;
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        .btn-search {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-search:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .donor-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }
        
        .donor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        
        .donor-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .donor-details {
            padding: 20px;
        }
        
        .donor-name {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .blood-group {
            font-weight: 700;
            color: var(--primary);
        }
        
        .donor-info {
            margin-bottom: 8px;
        }
        
        .donor-info i {
            color: var(--primary);
            margin-right: 8px;
            width: 20px;
        }
        
        .alert-danger {
            border-radius: 8px;
            padding: 15px;
        }
        
        @media (max-width: 768px) {
            .need-blood-section {
                padding: 50px 0;
            }
        }
    </style>
</head>
<body>
    <?php 
    $active = 'need';
    include('head.php');
    ?>

    <div class="need-blood-section">
        <div class="container">
            <h1 class="section-title">Need Blood</h1>
            
            <form name="needblood" method="post" class="search-form">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label required-field">Blood Group</label>
                            <select name="blood" class="form-control" required>
                                <option value="" selected disabled>Select Blood Group</option>
                                <?php
                                    include 'conn.php';
                                    $sql = "SELECT * FROM blood";
                                    $result = mysqli_query($conn, $sql) or die("query unsuccessful.");
                                    while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <option value="<?php echo $row['blood_group'] ?>"><?php echo $row['blood_group'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label required-field">Reason for needing blood</label>
                            <textarea class="form-control" name="address" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" name="search" class="btn btn-search">
                            <i class="fas fa-search mr-2"></i> Search Donors
                        </button>
                    </div>
                </div>
            </form>
            
            <div class="row">
                <?php 
                if(isset($_POST['search'])) {
                    $bg = $_POST['blood'];
                    $sql = "SELECT * FROM donor_details JOIN blood WHERE donor_details.donor_blood=blood.blood_group AND donor_blood='{$bg}' ORDER BY rand() LIMIT 5";
                    $result = mysqli_query($conn, $sql) or die("query unsuccessful.");
                    
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="donor-card">
                    <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.sriramakrishnahospital.com%2Fwp-content%2Fuploads%2F2021%2F06%2FBlood-Donation-1.jpg&f=1&nofb=1&ipt=b2320609f97c7c3c1c2fa3b0f01f51d4bb06a97a588cd2b62b10cd623cb16104" 
                    class="donor-img" 
                    alt="Blood Donation Logo"
                    width="120">                        
                    <div class="donor-details">
                            <h3 class="donor-name"><?php echo $row['donor_name']; ?></h3>
                            <p class="donor-info">
                                <i class="fas fa-tint"></i>
                                <span class="blood-group"><?php echo $row['blood_group']; ?></span>
                            </p>
                            <p class="donor-info">
                                <i class="fas fa-phone-alt"></i>
                                <?php echo $row['donor_number']; ?>
                            </p>
                            <p class="donor-info">
                                <i class="fas fa-venus-mars"></i>
                                <?php echo $row['donor_gender']; ?>
                            </p>
                            <p class="donor-info">
                                <i class="fas fa-birthday-cake"></i>
                                <?php echo $row['donor_age']; ?> years
                            </p>
                            <p class="donor-info">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo $row['donor_address']; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
                        }
                    } else {
                        echo '<div class="col-12"><div class="alert alert-danger">No donors found for the selected blood group. Please try another blood type.</div></div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>