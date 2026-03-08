<?php
$host = "sql305.infinityfree.com";
$username = "if0_41253895";
$password = "NOPE";
$database = "if0_41253895_frontforge";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed");
}

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$user_id = $_SESSION['user_id'] ?? null;

$stmt = $conn->prepare(
    "INSERT INTO feedback (user_id, name, email, message)
     VALUES (?, ?, ?, ?)"
);

$stmt->bind_param("isss", $user_id, $name, $email, $message);

if ($stmt->execute()) {
    $msg = urlencode("We got your feedback");
    if ($stmt->execute()) {
        header("Location: home.php?success=feedback");
        exit();
    }
    else {
        header("Location: home.php?error=feedback");
        exit();
    }
}
else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>