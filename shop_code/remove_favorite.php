<?php
include 'conectare.php'; // Include the database connection
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prod_id'])) {
    // Ensure the user is logged in
    if (isset($_SESSION['id'])) {
        $user_id = intval($_SESSION['id']);
        $prod_id = intval($_POST['prod_id']);

        // Remove the favorite from the database
        $sql = "DELETE FROM favorites WHERE u_id = $user_id AND prod_id = $prod_id";
        if (mysqli_query($conectare, $sql)) {
            echo "success";
        } else {
            echo "error: " . mysqli_error($conectare);
        }
    } else {
        echo "error: user not logged in";
    }
}
?>
