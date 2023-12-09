<?php
if (isset($_GET['file_id'])) {
    // Configuration for database connection
    $dbHost = 'localhost';
    $dbUser = 'hyegia';
    $dbPass = 'hyegia';
    $dbName = 'hyegia'; // Use your database name here

    // Connect to the database
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $file_id = $_GET['file_id'];

    // Fetch file information from the database based on the file_id
    $sql = "SELECT file_name, file_path FROM uploaded_files WHERE file_id = $file_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $filePath = $row['file_path'];
        $fileName = $row['file_name'];

        // Set appropriate headers to make the file downloadable
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        readfile($filePath);
    } else {
        // File not found in the database
        echo "File not found in the database.";
    }

    // Close the database connection
    $conn->close();
}
?>
