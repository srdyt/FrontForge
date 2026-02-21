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
    <a href="home.html" class="error-button">Home</a>
    <br><br>
    <a href="login.html" class="error-button">Login</a>
</div>
</div>

</body>
</html>