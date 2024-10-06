<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Get the request data
$name = $_POST['name'];
$email = $_POST['email'];
$mobileNumber = $_POST['mobile'];
$date = $_POST['date'];
$address = $_POST['address'];
$isBooking = $_POST['isBooking'] === 'true' ? 1 : 0;

// Save to database
$sql = "INSERT INTO requests (name, email, mobileNumber, date, address, isBooking) 
VALUES ('$name', '$email', '$mobileNumber', '$date', '$address', $isBooking)";

if ($conn->query($sql) === TRUE) {
    // Send email
    $to = "youremail@example.com"; // Change to your email address
    $subject = $isBooking ? "New Booking Request" : "New Test Drive Request";
    $message = "
    Name: $name\n
    Email: $email\n
    Mobile Number: $mobileNumber\n
    Date: $date\n
    Address: $address\n
    Request Type: " . ($isBooking ? "Booking" : "Test Drive") . "\n
    ";
    $headers = "From: noreply@example.com"; // Change to your desired sender email

    mail($to, $subject, $message, $headers);

    echo json_encode(["message" => "Request saved and email sent successfully."]);
} else {
    echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>
