<?php
session_start();
session_destroy();
$_SESSION["logout_success"] = true;
header("Location: login.php");
?>