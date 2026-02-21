<?php
session_start();
include "db.php";

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s",$username);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if($user && password_verify($password,$user["password"])) {
    $_SESSION["user_id"] = $user["id"];
    header("Location: editor.php");
}
else {
    header("Location: error.php?code=409&message=Invalid+Login");
    exit();
}
?>