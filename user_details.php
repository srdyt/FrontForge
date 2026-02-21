<?php include "auth.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>User Details</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

 <header class="topbar">
    <button id="hamburger" class="hamburger">☰</button>

  <nav id="sidebar" class="sidebar">
    <h2 class="sidebar-title">FrontForge</h2>
    <ul>
      <a href="home.php"></a><li class="active">Home</li></a>
      <a href="editor.php"><li>Editor</li></a>
    </ul>
  </nav>

      <div id="overlay" class="overlay"></div>
    <div class="actions">
      <div class="actions">

<?php if ($loggedIn): ?>

    <span class="welcome">
        Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?>
    </span>

    <button class="primary">
        <a href="logout.php">Logout</a>
    </button>

<?php else: ?>

    <button class="primary">
        <a href="login.php">Login</a>
    </button>

    <button class="primary">
        <a href="register.php">Sign Up</a>
    </button>

<?php endif; ?>

</div>
    </div>

</header>


<div class="profile-box">

    <h2>User Details</h2>

    <div class="profile-item">
        <strong>Username:</strong>
        <?php echo htmlspecialchars($_SESSION["username"]); ?>
    </div>

    <div class="profile-item">
        <strong>Email:</strong>
        <?php echo htmlspecialchars($_SESSION["email"]); ?>
    </div>

    <div class="profile-item">
        <strong>User ID:</strong>
        <?php echo htmlspecialchars($_SESSION["user_id"]); ?>
    </div>

    <div class="profile-item">
        <strong>Account Created:</strong>
        <?php echo htmlspecialchars($_SESSION["created_at"]); ?>
    </div>

</div>
  <script src="script.js"></script>

</body>
</html>