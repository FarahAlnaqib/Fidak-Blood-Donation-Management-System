<?php
include 'conn.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $return_url = isset($_GET['return']) ? $_GET['return'] : 'query.php';
    
    $sql = "DELETE FROM contact_query WHERE query_id = $id";
    $result = mysqli_query($conn, $sql);
    
    if($result) {
        header("Location: $return_url?deleted=1");
        exit();
    } else {
        header("Location: $return_url?error=1");
        exit();
    }
} else {
    header("Location: query.php");
    exit();
}
?>