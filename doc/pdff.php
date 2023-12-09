<?php
// Database configuration
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'hello';

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["pdfFile"]) && $_FILES["pdfFile"]["error"] == 0) {
        $pdf_data = addslashes(file_get_contents($_FILES["pdfFile"]["tmp_name"]));
        $pdf_name = $_FILES["pdfFile"]["name"];

        // Insert the PDF data into the database
        $sql = "INSERT INTO pdfs (filename, pdf_data) VALUES ('$pdf_name', '$pdf_data')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('login successfully!');</script>";
            echo "<script>window.location.href = 'index.html';</script>";
        } else {
            echo "Error uploading PDF: " . $conn->error;
        }
    } else {
        echo "Invalid PDF file.";
    }
}

// Close the database connection
$conn->close();
?>
