<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "pagasa_academy_db.";

// Dito nanggagaling ang variable na $conn
$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>