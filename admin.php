<?php
$host = "sql305.infinityfree.com";
$username = "if0_41253895";
$password = "NOPE";
$database = "if0_41253895_frontforge";

$conn = new mysqli($host, $username, $password, $database);
$username = "admin";
$password = password_hash("admin123", PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admins (username,password) VALUES (?,?)");
$stmt->bind_param("ss",$username,$password);
$stmt->execute();

echo "Admin created!";
?>