<?php
require_once 'db_config.php';

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

// Include the Twilio PHP library
require_once 'vendor/autoload.php';

use Twilio\Rest\Client;

// Function to sanitize the input data
function sanitizeInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the input data
    $doctorName = sanitizeInput($_POST['doctorName']);
    $specialty = sanitizeInput($_POST['specialty']);
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $gender = sanitizeInput($_POST['gender']);
    $date = sanitizeInput($_POST['date']);
    $slots = sanitizeInput($_POST['slots']);
    $reason = sanitizeInput($_POST['reason']);

    // Insert the data into the database
    $query = "INSERT INTO appointments (doctor_name, specialty, patient_name, patient_email, patient_phone, patient_gender, appointment_date, appointment_slot, reason_for_consultation)
              VALUES ('$doctorName', '$specialty', '$name', '$email', '$phone', '$gender', '$date', '$slots', '$reason')";

    if (mysqli_query($connection, $query)) {
        // Data inserted successfully
        echo "<script>alert('Booked Appointment!');</script>";
        // echo "<script>window.location.href = 'appo.html';</script>";

        // Send SMS to patient using Twilio API
        sendSMSToPatient($name, $phone, $doctorName, $specialty, $date, $slots);
    } else {
        // Error occurred
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }

    // Close the database connection
    mysqli_close($connection);
}

// Function to send SMS to the patient using Twilio API
function sendSMSToPatient($name, $phone, $doctorName, $specialty, $date, $slots) {
    // Replace with your Twilio Account SID, Auth Token, and Twilio phone number
    $accountSid = 'AC16204cd82205f7423d41ca668a5ac584';
    $authToken = 'e60265998a89645f23059bab6d823b73';
    $twilioPhoneNumber = '+17623395604';

    // Initialize Twilio client
    $twilioClient = new Client($accountSid, $authToken);

    // Format the SMS message
    $message = "Hi $name, your appointment with $doctorName ($specialty) has been confirmed on $date at $slots. See you on the appointment day. Thank you!";

    try {
        // Send SMS
        $twilioClient->messages->create(
            $phone, // The patient's phone number
            [
                'from' => $twilioPhoneNumber,
                'body' => $message
            ]
        );

        echo "<script>alert('SMS sent successfully!');</script>";
        echo "<script>window.location.href = 'appo.html';</script>";
        // echo "<script>alert('SMS sent successfully!');</script>";
    } catch (Exception $e) {
        echo "Error sending SMS: " . $e->getMessage();
    }
}
?>
