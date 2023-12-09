<?php
// Database configuration
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'hello';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $pdf_id = $_GET['id'];

    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the PDF data from the database based on the ID
    $sql = "SELECT pdf_data FROM pdfs WHERE id = $pdf_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pdf_data = $row['pdf_data'];

        // Close the database connection
        $conn->close();

        // Set the appropriate HTTP headers for PDF rendering
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="viewed_pdf.pdf"');

        // Output the PDF data to the browser
        echo $pdf_data;
    } else {
        $conn->close();
        echo 'PDF not found in the database.';
    }
} else {
    echo 'Invalid PDF ID.';
}
?>
