<?php
include "auth.php";
include "db.php";
$page = basename($_SERVER['PHP_SELF']);

$results = null;
$query = "";

if(isset($_GET["q"]) && trim($_GET["q"]) !== ""){

    $query = trim($_GET["q"]);
    $search = "%" . $query . "%";

    $stmt = $conn->prepare(
        "SELECT id,name,username,email,created_at
         FROM users
         WHERE username LIKE ?
         ORDER BY username"
    );
    $stmt->bind_param("s",$search);
    $stmt->execute();
    $results = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Search Users</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
   <header class="topbar">
    <button id="hamburger" class="hamburger">☰</button>

<div class="sidebar" id="sidebar">
    <div>
        <h3 class="sidebar-title">FrontForge</h3>
       <ul>
<?php if ($loggedIn): ?>
    <a href="home.php"><li class="<?= $page=='home.php'?'active':'' ?>">Home</li></a>
    <a href="editor.php"><li class="<?= $page=='editor.php'?'active':'' ?>">Editor</li></a>
    <a href="user_search.php"><li class="<?= $page=='user_search.php'?'active':'' ?>">Search Users</li></a>
<?php else: ?>
    <a href="home.php"><li class="<?= $page=='home.php'?'active':'' ?>">Home</li></a>
    <a href="login.php"><li class="<?= $page=='login.php'?'active':'' ?>">Login</li></a>
    <a href="register.php"><li class="<?= $page=='register.php'?'active':'' ?>">Register</li></a>
<?php endif; ?>
</ul>
    </div>

   <div class="sidebar-bottom">
<?php if ($loggedIn): ?>
    <a href="user_details.php">
        <ul><?= htmlspecialchars($_SESSION["username"]) ?></ul>
    </a>
<?php endif; ?>
</div>
</div>

      <div id="overlay" class="overlay"></div>
       <?php if ($loggedIn): ?>
<div class="topbar-center">
    <a href="home.php" class="quick-icon <?= $page=='home.php' ? 'active' : '' ?>"><img src="offline/home.png"></a>
    <a href="projects.php" class="quick-icon <?= $page=='projects.php' ? 'active' : '' ?>"><img src="offline/files.png"></a>
    <a href="teams.php" class="quick-icon <?= $page=='teams.php' ? 'active' : '' ?>"><img src="offline/group.png"></a>
    <a href="editor.php" class="quick-icon <?= $page=='editor.php' ? 'active' : '' ?>"><img src="offline/code.png"></a>
    <a href="user_details.php" class="quick-icon <?= $page=='user_details.php' ? 'active' : '' ?>"><img src="offline/person.png"></a>
</div>
<?php endif; ?>
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
<div  class="auth-page">
<h1 class="logo">Front<span>Forge</span></h1>

<div class="auth-container">

<!-- SEARCH BAR -->
<form method="GET" class="auth-form">
    <input
        type="text"
        name="q"
        placeholder="Search username..."
        class="auth-input"
        value="<?= htmlspecialchars($query) ?>"
    >
    <button class="auth-button">Search</button>
</form>


<!-- RESULTS -->
<?php if($query !== ""): ?>

<h3 style="margin-top:25px;">Results</h3>

<div class="search-results">

<?php if($results && $results->num_rows > 0): ?>

<?php while($u = $results->fetch_assoc()): ?>

<a class="user-card" href="user_details.php?id=<?= $u['id'] ?>">

    <div class="avatar">
        <?= strtoupper(substr($u['username'],0,1)) ?>
    </div>

    <div class="user-info">
        <div class="user-info-username">
            <?= htmlspecialchars($u['username']) ?>
        </div>

        <div class="email">
            <?= htmlspecialchars($u['email']) ?>
        </div>

        <div class="meta">
            Joined: <?= htmlspecialchars($u['created_at']) ?>
        </div>
    </div>

    <div class="arrow">→</div>

</a>

<?php endwhile; ?>

<?php else: ?>

<p style="margin-top:15px;">No users found</p>

<?php endif; ?>

</div>
<?php endif; ?>

</div>
</div>
<script src="script.js"></script>
</body>
</html>