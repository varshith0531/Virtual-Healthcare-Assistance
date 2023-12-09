<?php
// Replace these values with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doc";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the submitted username and password
$username = $_POST['username'];
$password = $_POST['password'];

// Query to check if the username and password are valid
$sql = "SELECT * FROM doctors WHERE un = '$username' AND ps = '$password'";
$result = $conn->query($sql);

// If the query returns a match, the login is successful
if ($result->num_rows == 1) {
    // Perform login actions here (e.g., set session, redirect to a dashboard, etc.)
    echo "<script>alert('login successfully!');</script>";
        echo "<script>window.location.href = 'index.html';</script>";
} else {
    echo "Invalid username or password.";
}

// Close the database connection
$conn->close();
?>
