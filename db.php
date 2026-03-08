<?php
$host = "sql305.infinityfree.com";
$username = "if0_41253895";
$password = "NOPE";
$database = "if0_41253895_frontforge";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>