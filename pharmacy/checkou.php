<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $totalPrice = $_POST['total'];

    // You can perform further validation and sanitization of the form data here.

    // Process the cart items
    $cartItems = isset($_POST['cartItems']) ? json_decode($_POST['cartItems'], true) : [];

    // Perform the checkout process or store the order in the database
    // For demonstration purposes, let's just print the details.
    echo "<h1>Order Details:</h1>";
    echo "<p>Name: $name</p>";
    echo "<p>Email: $email</p>";
    echo "<p>Phone: $phone</p>";
    echo "<p>Address: $address</p>";
    echo "<p>Total Price: $totalPrice</p>";

    echo "<h2>Cart Items:</h2>";
    echo "<ul>";
    foreach ($cartItems as $item) {
        echo "<li>Name: {$item['name']}, Strength: {$item['strength']}, Price: {$item['price']}</li>";
        // You can store these cart items in the database or perform other actions as needed.
    }
    echo "</ul>";
} else {
    // If the form is not submitted via POST method, redirect the user to the cart page.
    header('Location: cart.html');
    exit;
}
?>
