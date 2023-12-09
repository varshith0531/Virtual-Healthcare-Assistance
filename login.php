<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_id = $_POST['login_id'];
    $login_pass = $_POST['login_pass'];

    // Perform validation and authentication against the database
    $conn = new mysqli('localhost', 'root', '', 'hyegia');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    } else {
        // Prepare and execute a query to fetch the user's data
        $stmt = $conn->prepare("SELECT * FROM login WHERE (email=? OR phonenumber=?) AND password=?");
        $stmt->bind_param('sss', $login_id, $login_id, $login_pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // User credentials are valid, redirect to index.html or any other page you want.
            echo "<script>alert('Login successful!');</script>";
            echo "<script>window.location.href = 'index1.html';</script>";
            exit; // Make sure to exit after redirection to prevent further execution of the script.
        } else {
            // Invalid login credentials, display an error message or redirect back to login page with an error.
            echo "<script>alert('Invalid credentials. Please try again.');</script>";
            echo "<script>window.location.href = 'index.html';</script>";
        }

        $stmt->close();
        $conn->close();
    }
}
?>
