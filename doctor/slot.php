<?php
// Assuming you have a database connection established already
// Replace DB_HOST, DB_USERNAME, DB_PASSWORD, and DB_NAME with your database credentials

// Establish a database connection
$host = 'localhost';
$username = 'hyegia';
$password = 'hyegia';
$database = 'appointments_db';

// Create a connection to the database
$connection = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die('Failed to connect to the database: ' . mysqli_connect_error());
}

// Query to retrieve booked slots
$query = "SELECT date, slots FROM booked_slots_table"; // Replace 'booked_slots_table' with your actual table name

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Error retrieving booked slots: ' . mysqli_error($conn));
}

// Prepare an empty array to store the booked slots data
$bookedSlots = array();

// Fetch and format the booked slots data
while ($row = mysqli_fetch_assoc($result)) {
    $date = $row['date'];
    $slots = explode(",", $row['slots']);
    $bookedSlots[$date] = $slots;
}

// Close the database connection
mysqli_close($conn);

// Return the booked slots data as JSON
header('Content-Type: application/json');
echo json_encode($bookedSlots);
?>
