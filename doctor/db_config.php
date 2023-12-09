<?php
// Replace these values with your database credentials
$host = 'localhost';
$username = 'hyegia';
$password = 'hyegia';
$database = 'appointments_db';

// Create a connection to the database
$connection = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
