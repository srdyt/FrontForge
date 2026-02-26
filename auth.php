<?php
session_start();

/* Check login */
$loggedIn = isset($_SESSION["user_id"]);

/* Redirect if not logged in */
if (!$loggedIn) {
    header("Location: login.php");
    exit();
}

/* Safety checks (avoid undefined errors) */
$_SESSION["name"]   = $_SESSION["name"]   ?? "Unknown";
$_SESSION["email"]      = $_SESSION["email"]      ?? "Not set";
$_SESSION["created_at"] = $_SESSION["created_at"] ?? "Unknown";
$_SESSION["username"]   = $_SESSION["username"]   ?? "Unknown";
?>