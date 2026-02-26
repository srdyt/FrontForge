<?php
require 'admin_auth.php';   // protects page

$conn = new mysqli("localhost","phpuser","FrontForge@123","frontforge");

if ($conn->connect_error) {
    die("DB Connection Failed");
}

/* ===== FETCH DATA ===== */

$feedbacks = $conn->query("SELECT id,name,email,message,created_at FROM feedback ORDER BY id DESC");
$admins    = $conn->query("SELECT id,username,created_at FROM admins ORDER BY id DESC");
$users     = $conn->query("SELECT id,username,email,created_at FROM users ORDER BY id DESC");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">

<h1 class="logo">Front<span>Forge</span> Admin</h1>

<div class="auth-container dashboard">

<h2> Feedback</h2>
<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Message</th>
    <th>Date</th>
</tr>

<?php while($row = $feedbacks->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['id']) ?></td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['message']) ?></td>
    <td><?= htmlspecialchars($row['created_at']) ?></td>
</tr>
<?php endwhile; ?>
</table>


<br><br>

<h2> Admins</h2>
<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Created</th>
</tr>

<?php while($row = $admins->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['id']) ?></td>
    <td><?= htmlspecialchars($row['username']) ?></td>
    <td><?= htmlspecialchars($row['created_at']) ?></td>
</tr>
<?php endwhile; ?>
</table>


<br><br>

<h2> Users</h2>
<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Email</th>
    <th>Joined</th>
</tr>

<?php while($row = $users->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['id']) ?></td>
    <td><?= htmlspecialchars($row['username']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['created_at']) ?></td>
</tr>
<?php endwhile; ?>
</table>

<br>
<a href="logout.php" class="auth-button">Logout</a>

</div>
</body>
</html>