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
        $_SESSION["name"] = $user["name"];

        $_SESSION["login_success"] = true;
        header("Location: home.php?login=success");
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

<h1 class="logo">Front<span>Forge</span></h1>
<div class="auth-container">


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
    <input name="username" placeholder="Username" required class="auth-input" autocomplete="off" >
    <input name="password" type="password" placeholder="Password" required class="auth-input" autocomplete="off">
    <button class="auth-button">Login</button>
</form>


</div>
<?php if(isset($_SESSION["logout_success"])): ?>
<script>
window.onload = () => showTick("Logout successful ");
</script>
<?php unset($_SESSION["logout_success"]); endif; ?>
<div class="auth-links">
    <a href="register.php" class="auth-link">
        Don't have an account? Register!
    </a>
<?php endif; ?>

</div>
<div id="tickToast" class="tick-toast">
    <svg class="toast-tick" viewBox="0 0 52 52">
        <circle cx="26" cy="26" r="24"/>
        <path d="M14 27 L22 35 L38 18"/>
    </svg>
    <span id="tickToastText">Logged out successfully</span>
</div>

<script src="script.js"></script>
<script>
function showTick(message){
    const toast = document.getElementById("tickToast");
    const text  = document.getElementById("tickToastText");

    text.innerText = message;

    toast.classList.remove("show");
    void toast.offsetWidth; // restart animation
    toast.classList.add("show");

    setTimeout(()=>toast.classList.remove("show"),2500);
}
</script>
</body>
</html>