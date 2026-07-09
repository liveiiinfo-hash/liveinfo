<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "whatsapp_admin";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// echo "Database Connected Successfully!"; // Uncomment only for testing

?>