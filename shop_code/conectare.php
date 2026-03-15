<?php
    $host = 'host_address'; // Adresa serverului MySQL 
    $user = 'phpMyAdminUser'; // Numele utilizatorului MySQL
    $password = 'password'; // Parola utilizatorului MySQL
    $database = 'db_name'; // Numele bazei de date

    $conectare = mysqli_connect($host, $user, $password, $database);

    if(!$conectare) {
        die("Conectarea la baza de date nu a reusit: " . mysqli_connect_error());
    } else {
        echo "";
    }
?>