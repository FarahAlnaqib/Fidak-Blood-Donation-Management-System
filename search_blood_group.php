<?php
if (!isset($_POST['blood']) || empty($_POST['blood'])) {
    die('<div class="alert alert-danger">Blood group not provided.</div>');
}

$bg = $_POST['blood'];
$conn = mysqli_connect("localhost", "root", "", "fidak_bbms") or die("Connection error");

$sql = "SELECT * FROM donor_details 
        JOIN blood ON donor_details.donor_blood = blood.blood_group
        WHERE blood.blood_group = '{$bg}' 
        ORDER BY rand() 
        LIMIT 5";

$result = mysqli_query($conn, $sql) or die("query unsuccessful.");

if (mysqli_num_rows($result) > 0) {
    echo '<div class="row">';
    while ($row = mysqli_fetch_assoc($result)) {
?>
        <div class="col-lg-4 col-sm-6 portfolio-item"><br>
            <div class="card" style="width:300px">
            <img class="card-img-top" 
     src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fstatic.vecteezy.com%2Fsystem%2Fresources%2Fpreviews%2F021%2F432%2F955%2Fnon_2x%2Fblood-donation-icon-png.png&f=1&nofb=1&ipt=f513b47534faa14ec19aba5a77d9ea0205e286f1973d15d2d8f14e6351ca9d1b" 
     alt="Blood donation card"
     style="width:100%;height:300px;object-fit:cover">                
     <div class="card-body">
                    <h3 class="card-title"><?php echo $row['donor_name']; ?></h3>
                    <p class="card-text">
                        <b>Blood Group : </b> <b><?php echo $row['blood_group']; ?></b><br>
                        <b>Mobile No. : </b> <?php echo $row['donor_number']; ?><br>
                        <b>Gender : </b><?php echo $row['donor_gender']; ?><br>
                        <b>Age : </b> <?php echo $row['donor_age']; ?><br>
                        <b>Address : </b> <?php echo $row['donor_address']; ?><br>
                    </p>
                </div>
            </div>
        </div>
<?php
    }
    echo '</div>';
} else {
    echo '<div class="alert alert-danger">No Donor Found For your search Blood group</div>';
}
?>