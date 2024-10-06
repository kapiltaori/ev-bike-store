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
    if($isBooking) {
        echo json_encode(["message" => "We received your vehicle booking. Thanks for showing the intrest, we will get back to you shortly!"]);
    } else {
        echo json_encode(["message" => "We received your test drive request. Thanks for showing the intrest, we will get back to you shortly!"]);
    }
} else {
    echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>
