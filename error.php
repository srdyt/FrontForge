<?php
$code = $_GET['code'] ?? "404";
$message = $_GET['message'] ?? "Something went wrong. Please try again.";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">

<div class="error-box">

    <div class="error-code"><?php echo htmlspecialchars($code); ?></div>

    <div class="error-message">
        <?php echo htmlspecialchars($message); ?>
    </div>

<div class="error-buttons">
    <a href="home.php" class="error-button">Home</a>
    <br><br>
    <a href="login.php" class="error-button">Login</a>
</div>
</div>

</body>
</html>