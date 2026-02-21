<?php
// Default values
$code = $_GET['code'] ?? "Error";
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
    <a href="login.html" class="error-button">Go to Login</a>
    <br><br>
    <a href="register.php" class="error-button">Try Register Again</a>
</div>
</div>

</body>
</html>