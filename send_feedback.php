<?php
$conn = new mysqli("localhost","phpuser","FrontForge@123","frontforge");

if ($conn->connect_error) {
    die("Connection failed");
}

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    $msg = urlencode("We got your feedback");
    header("Location: error.php?code=505&message=$msg");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>