<?php
session_start();

$conn = new mysqli("localhost","phpuser","FrontForge@123","frontforge");

$sessionExists = isset($_SESSION['admin']);
$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && !$sessionExists){

    $username = $_POST['username'] ?? "";
    $password = $_POST['password'] ?? "";

    $stmt = $conn->prepare("SELECT password FROM admins WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        $stmt->bind_result($hash);
        $stmt->fetch();

        if(password_verify($password,$hash)){
            $_SESSION['admin'] = $username;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Wrong password";
        }
    } else {
        $error = "Admin not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">

    <?php if ($sessionExists): ?>
        <meta http-equiv="refresh" content="2;url=admin_dashboard.php">
    <?php endif; ?>
</head>

<body class="auth-page">

<h1 class="logo">Front<span>Forge</span></h1>

<div class="auth-container">

<?php if ($sessionExists): ?>

    <p style="color:orange;">
        You are already logged in as
        <b><?php echo htmlspecialchars($_SESSION["admin"]); ?></b>
    </p>

<?php elseif ($error): ?>

    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>

<?php endif; ?>


<?php if (!$sessionExists): ?>

<form method="POST" class="auth-form">
    <input name="username" placeholder="Username" required class="auth-input" autocomplete="off">
    <input name="password" type="password" placeholder="Password" required class="auth-input" autocomplete="off">
    <button class="auth-button">Login</button>
</form>

<?php endif; ?>

</div>

</body>
</html>