<?php
include "auth.php";
include "db.php";
$page = basename($_SERVER['PHP_SELF']);

$results = null;
$query = "";

if (isset($_GET["q"]) && trim($_GET["q"]) !== "") {

    $query = trim($_GET["q"]);
    $search = "%" . $query . "%";

    $stmt = $conn->prepare(
        "SELECT id,name,username,email,created_at
         FROM users
         WHERE username LIKE ?
         ORDER BY username"
    );
    $stmt->bind_param("s", $search);
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

    <!-- ===== SIDEBAR ===== -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-top">
            <img src="offline/FrontForge.png" alt="FrontForge" class="sidebar-logo">
        </div>

        <div class="sidebar-nav">
            <?php if ($loggedIn): ?>
            <a href="home.php" class="menu-item <?= $page == 'home.php' ? 'active' : ''?>">
                <span class="icon"><img src="offline/home.png" alt="Home"></span>
                <span class="text">Home</span>
            </a>
            <a href="editor.php" class="menu-item <?= $page == 'editor.php' ? 'active' : ''?>">
                <span class="icon"><img src="offline/code.png" alt="Editor"></span>
                <span class="text">Editor</span>
            </a>
            <a href="projects.php" class="menu-item <?= $page == 'projects.php' ? 'active' : ''?>">
                <span class="icon"><img src="offline/files.png" alt="Projects"></span>
                <span class="text">Projects</span>
            </a>
            <a href="teams.php" class="menu-item <?= $page == 'teams.php' ? 'active' : ''?>">
                <span class="icon"><img src="offline/group.png" alt="Teams"></span>
                <span class="text">Teams</span>
            </a>
            <a href="user_search.php" class="menu-item <?= $page == 'user_search.php' ? 'active' : ''?>">
                <span class="icon"><img src="offline/search.png" alt="Search"></span>
                <span class="text">Search</span>
            </a>
            <?php
else: ?>
            <a href="home.php" class="menu-item <?= $page == 'home.php' ? 'active' : ''?>">
                <span class="icon">🏠</span>
                <span class="text">Home</span>
            </a>
            <a href="login.php" class="menu-item <?= $page == 'login.php' ? 'active' : ''?>">
                <span class="icon"><img src="offline/person.png" alt="Login"></span>
                <span class="text">Login</span>
            </a>
            <a href="register.php" class="menu-item <?= $page == 'register.php' ? 'active' : ''?>">
                <span class="icon"><img src="offline/person.png" alt="Register"></span>
                <span class="text">Register</span>
            </a>
            <?php
endif; ?>
        </div>

        <div class="sidebar-bottom">
            <?php if ($loggedIn): ?>
            <a href="user_details.php" class="menu-item <?= $page == 'user_details.php' ? 'active' : ''?>">
                <span class="icon"><img src="offline/person.png" alt="Profile"></span>
                <span class="text">
                    <?= htmlspecialchars($_SESSION["username"])?>
                </span>
            </a>
            <a href="logout.php" class="menu-item">
                <span class="icon"><img src="offline/person.png" alt="Logout"></span>
                <span class="text">Logout</span>
            </a>
            <?php
endif; ?>
        </div>
    </nav>

    <!-- ===== TOPBAR ===== -->
    <header class="topbar">
        <div class="topbar-left">
            <h1 class="topbar-logo">Front<span>Forge</span></h1>
        </div>
        <div class="actions">
            <?php if ($loggedIn): ?>
            <span class="welcome">
                Hi,
                <?php echo htmlspecialchars($_SESSION["username"]); ?>
            </span>
            <?php
endif; ?>
        </div>
    </header>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content">

        <div class="auth-page">
            <h1 class="logo">Front<span>Forge</span></h1>

            <div class="auth-container">

                <!-- SEARCH BAR -->
                <form method="GET" class="auth-form">
                    <input type="text" name="q" placeholder="Search username..." class="auth-input"
                        value="<?= htmlspecialchars($query)?>">
                    <button class="auth-button">Search</button>
                </form>

                <!-- RESULTS -->
                <?php if ($query !== ""): ?>

                <h3 style="margin-top:25px;">Results</h3>

                <div class="search-results">

                    <?php if ($results && $results->num_rows > 0): ?>

                    <?php while ($u = $results->fetch_assoc()): ?>

                    <a class="user-card" href="user_details.php?id=<?= $u['id']?>">

                        <div class="avatar">
                            <?= strtoupper(substr($u['username'], 0, 1))?>
                        </div>

                        <div class="user-info">
                            <div class="user-info-username">
                                <?= htmlspecialchars($u['username'])?>
                            </div>

                            <div class="email">
                                <?= htmlspecialchars($u['email'])?>
                            </div>

                            <div class="meta">
                                Joined:
                                <?= htmlspecialchars($u['created_at'])?>
                            </div>
                        </div>

                        <div class="arrow">→</div>

                    </a>

                    <?php
        endwhile; ?>

                    <?php
    else: ?>

                    <p style="margin-top:15px;">No users found</p>

                    <?php
    endif; ?>

                </div>
                <?php
endif; ?>

            </div>
        </div>

    </main>

    <script src="script.js"></script>

</body>