<?php
session_start();
include "db.php";

$sessionExists = isset($_SESSION["user_id"]);
$error = "";

if ($sessionExists) {
    $error = "You are already logged in as " . htmlspecialchars($_SESSION["username"]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !$sessionExists) {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    if($user && password_verify($password,$user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["created_at"] = $user["created_at"];

        header("Location: home.php");
        exit();
    }
    else {
        $error = "Invalid Login";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <?php if ($sessionExists): ?>
        <meta http-equiv="refresh" content="3;url=home.php">
    <?php endif; ?>
</head>

<body class="auth-page">

<div class="auth-container">

<h1 class="auth-title">Login</h1>

<?php if ($sessionExists): ?>

    <p style="color:orange;">
        You are already logged in as
        <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
    </p>

<?php elseif ($error): ?>

    <p style="color:red;"><?php echo $error; ?></p>

<?php endif; ?>


<?php if (!$sessionExists): ?>

<form method="POST" class="auth-form">
    <input name="username" placeholder="Username" required class="auth-input">
    <input name="password" type="password" placeholder="Password" required class="auth-input">
    <button class="auth-button">Login</button>
</form>

<div class="auth-links">
    <a href="register.php" class="auth-link">
        Don't have an account? Register!
    </a>
</div>


<?php endif; ?>

</div>

</body>
</html>