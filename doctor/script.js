// Load the previously booked slots from local storage (if any)
const bookedSlots = JSON.parse(localStorage.getItem('bookedSlots')) || {};

// Function to check and disable booked slots
function checkAndDisableBookedSlots() {
    const slots = document.querySelectorAll('slots');

    slots.forEach((slot) => {
        const slotValue = slot.value;
        if (bookedSlots[slotValue]) {
            slot.disabled = true;
        }
    });
}

// Function to handle the form submission and update booked slots
function submitForm() {
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var phone = document.getElementById("phone").value;
    var gender = document.getElementById("gender").value;
    var date = document.getElementById("date").value;
    var slots = document.getElementById("slots").value;
    var reason = document.getElementById("reason").value;
    var doctorName = document.getElementById("doctorName").value;
    var specialty = document.getElementById("specialty").value;

    // Process the patient's details as needed (e.g., send to database)
    // For this example, we'll just log the details to the console
    console.log("Patient Name:", name);
    console.log("Patient Email:", email);
    console.log("Patient Phone Number:", phone);
    console.log("Gender:", gender);
    console.log("Date:", date);
    console.log("Selected Slot:", slots);
    console.log("Reason for Consultation:", reason);
    console.log("Selected Doctor:", doctorName);
    console.log("Specialty:", specialty);

    // Send patient details to backend server (you'll need to set up your backend)
    sendPatientDetailsToBackend(name, email, phone, gender, date, slots, reason, doctorName, specialty);

    // Send SMS to patient using Twilio API
    sendSMSToPatient(name, phone, doctorName, specialty, date, slots);

    // Update the bookedSlots object and store it in local storage
    bookedSlots[slots] = true;
    localStorage.setItem('bookedSlots', JSON.stringify(bookedSlots));

    // Check and disable booked slots on the page
    checkAndDisableBookedSlots();

    // Display a success message to the user
    showConfirmationMessage();

    return false; // Prevent form submission
}

// Function to display a confirmation message to the user
function showConfirmationMessage() {
    var patientDetailsSection = document.getElementById("patient-details");
    var confirmationMessage = document.createElement("div");
    confirmationMessage.classList.add("confirmation-message");
    confirmationMessage.textContent = "Appointment booked successfully! You will receive an SMS confirmation shortly.";
    patientDetailsSection.appendChild(confirmationMessage);
}

// Function to send patient details to the backend server (you need to implement this)
function sendPatientDetailsToBackend(name, email, phone, gender, date, slots, reason, doctorName, specialty) {
    // Implement your code to send the data to your backend server using fetch or XMLHttpRequest.
    // Example:
    /*
    fetch('your_backend_url', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            email: email,
            phone: phone,
            gender: gender,
            date: date,
            slots: slots,
            reason: reason,
            doctorName: doctorName,
            specialty: specialty
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Response from backend:", data);
    })
    .catch(error => {
        console.error("Error sending data to backend:", error);
    });
    */
}

// Function to send SMS to the patient using Twilio API
function sendSMSToPatient(name, phone, doctorName, specialty, date, slots) {
    // Replace with your Twilio Account SID, Auth Token, and Twilio phone number
    const accountSid = 'AC16204cd82205f7423d41ca668a5ac584';
    const authToken = 'e60265998a89645f23059bab6d823b73';
    const twilioPhoneNumber = '+17623395604';

    // Initialize Twilio client
    const client = require('twilio')(accountSid, authToken);

    // Format the SMS message
    const message = `Hi ${name}, your appointment with ${doctorName} (${specialty}) on ${date} at ${slots} has been confirmed. See you on the appointment day. Thank you!`;

    // Send SMS
    client.messages.create({
        to: phone,
        from: twilioPhoneNumber,
        body: message
    })
    .then(message => console.log("SMS sent successfully:", message.sid))
    .catch(error => console.error("Error sending SMS:", error));
}

// Function to get URL parameters by name
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

// Function to display the selected doctor's details on the page
function displaySelectedDoctorDetails() {
    var doctorNameParam = getParameterByName('doctor');
    var specialtyParam = getParameterByName('specialty');

    var selectedDoctorDetails = document.getElementById("selected-doctor-details");
    selectedDoctorDetails.innerHTML = "<h3>Selected Doctor: " + doctorNameParam + "</h3>" +
                                      "<h3>Specialty: " + specialtyParam + "</h3>";

    // Set the doctorName and specialty values for form submission
    document.getElementById("doctorName").value = doctorNameParam;
    document.getElementById("specialty").value = specialtyParam;
}

// Call the function to display the selected doctor's details on page load
displaySelectedDoctorDetails();
