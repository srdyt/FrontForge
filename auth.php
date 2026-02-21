<?php
session_start();
$loggedIn = isset($_SESSION["user_id"]);
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>