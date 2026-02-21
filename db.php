<?php
$conn = new mysqli("localhost","phpuser","FrontForge@123","frontforge");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>