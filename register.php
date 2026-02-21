<?php
require "db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];

    if ($password !== $confirm) {
        $error = "Passwords do not match";
    } else {

        // check duplicate username/email
        $stmt = $conn->prepare(
            "SELECT id FROM users WHERE username=? OR email=?"
        );
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username or Email already exists";
        } else {

            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO users (name, username, email, password)
                 VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("ssss", $name, $username, $email, $hashed);

            if ($stmt->execute()) {
                $success = "Registration successful! You can login now.";
            } else {
                $error = "Database error: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">

<div class="auth-container">

<h1 class="auth-title">Register</h1>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:lime;"><?php echo $success; ?></p>
<?php endif; ?>

<form method="POST" class="auth-form">

<input name="name" placeholder="Full Name"
       value="<?php echo $_POST['name'] ?? ''; ?>"
       required class="auth-input">

<input name="username" placeholder="Username"
       value="<?php echo $_POST['username'] ?? ''; ?>"
       required class="auth-input">

<input name="email" placeholder="Email"
       value="<?php echo $_POST['email'] ?? ''; ?>"
       required class="auth-input">

<input name="password" type="password"
       placeholder="Password" required class="auth-input">

<input name="confirm_password" type="password"
       placeholder="Confirm Password" required class="auth-input">

<button class="auth-button">Register</button>

</form>

<div class="auth-links">
<a href="login.php" class="auth-link">
Already have an account? Login!
</a>
</div>

</div>
</body>
</html>