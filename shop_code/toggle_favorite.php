<?php
include 'conectare.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prod_id'])) {
    $prod_id = mysqli_real_escape_string($conectare, $_POST['prod_id']);
    $user_id = 1; // Exemplu: utilizatorul curent (trebuie schimbat dacă ai autentificare)
 
    // Verificăm dacă produsul este deja în favorite
    $check_query = "SELECT * FROM favorites WHERE u_id = '$user_id' AND prod_id = '$prod_id'";
    $check_result = mysqli_query($conectare, $check_query);
 
    if (mysqli_num_rows($check_result) > 0) {
        echo "Product is already in favorites.";
    } else {
        // Adăugăm produsul în tabelul `favorites`
        $query = "INSERT INTO favorites (u_id, prod_id, created_at) VALUES ('$user_id', '$prod_id', NOW())";
        if (mysqli_query($conectare, $query)) {
            echo "Success";
        } else {
            echo "Error: " . mysqli_error($conectare);
        }
    }
} else {
    echo "Invalid request.";
}
?>