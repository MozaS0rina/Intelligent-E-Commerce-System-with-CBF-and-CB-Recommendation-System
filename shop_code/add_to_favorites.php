<?php
include 'conectare.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prod_id']) && isset($_POST['u_id'])) {
    $prod_id = intval($_POST['prod_id']);
    $u_id = intval($_POST['u_id']);

    // Check if the product is already added to favorites for this user
    $check_sql = "SELECT * FROM favorites WHERE u_id = $u_id AND prod_id = $prod_id";
    $check_result = mysqli_query($conectare, $check_sql);

    if (mysqli_num_rows($check_result) == 0) {
        // Add to favorites if not already present
        $sql = "INSERT INTO favorites (u_id, prod_id) VALUES ($u_id, $prod_id)";
        if (mysqli_query($conectare, $sql)) {
            echo 'Product added to favorites!';
        } else {
            echo 'Error: ' . mysqli_error($conectare);
        }
    } else {
        echo 'Product already in favorites!';
    }
}
?>
