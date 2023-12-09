<?php
// Check if a file is uploaded successfully
if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
    $file_name = $_FILES['fileInput']['name'];
    $file_data = file_get_contents($_FILES['fileInput']['tmp_name']);

    // Database configuration
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'hyegia';

    // Connect to the database
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the query to insert the PDF data into the database
    $stmt = $conn->prepare("INSERT INTO pdf_files (file_name, file_data) VALUES (?, ?)");
    $stmt->bind_param("sb", $file_name, $file_data);

    if ($stmt->execute()) {
        echo "<script>alert('Records Uploaded successfully!');</script>";
        echo "<script>window.location.href = 'index2.html';</script>";
    } else {
        echo "Error uploading PDF: " . $conn->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>