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
    if ($stmt->execute()) {
    header("Location: home.php?success=feedback");
    exit();
} else {
    header("Location: home.php?error=feedback");
    exit();
}
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>