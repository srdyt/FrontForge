<?php
session_start();
$loggedIn = isset($_SESSION["user_id"]);
$page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Code Editor</title>

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet"  href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jacquard+24&family=New+Rocker&display=swap" rel="stylesheet">
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
        <span class="icon"><img src="offline/home.png" alt="Home"></span>
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
else: ?>
      <button class="primary">
        <a href="login.php">Login</a>
      </button>
      <button class="primary">
        <a href="register.php">Sign Up</a>
      </button>
      <?php
endif; ?>
    </div>
  </header>

  <!-- ===== MAIN CONTENT ===== -->
  <main class="main-content">

    <?php if (isset($_SESSION["login_success"])): ?>
    <script>
      window.onload = () => showTick("Login successful ");
    </script>
    <?php unset($_SESSION["login_success"]);
endif; ?>

    <?php if (isset($_GET['success'])): ?>
    <script>
      window.onload = () => showTick("Feedback submitted");
    </script>
    <?php
endif; ?>

    <section class="hero">
      <div class="hero-grid" style="--grid-rows:12" aria-hidden="true">
        <?php for ($i = 0; $i < 265; $i++)
  echo '<div class="grid-cell"></div>'; ?>
        <img src="offline/FrontForge.png" alt="FrontForge" class="hero-logo">
        <div class="hero-title">Front<span>Forge</span></div>
      </div>
    </section>

    <div class="hero-bottom-right">
      <button class="btn" onclick="window.location.href='editor.php'"> OPEN EDITOR</button>
      <button class="btn" onclick="window.location.href='register.php'"> REGISTER</button>
    </div>

    <section class="section contact">
      <div class="contact-left">
        <h2>CONTACT</h2>
        <p>Have suggestions or feature requests?</p>
        <h1 class="logo">Front<span>Forge</span></h1>
        <p><strong>Email:</strong> frontforgeinfo@gmail.com</p>
      </div>

      <div class="contact-right">
        <h2>FEEDBACK</h2>
        <form action="send_feedback.php" method="POST">
          <input type="text" name="name" placeholder="Your Name" autocomplete="off">
          <input type="email" name="email" placeholder="Your Email" autocomplete="off">
          <textarea name="message" placeholder="Your Message"></textarea>
          <button type="submit" class="btn">SEND</button>
        </form>
      </div>
    </section>

    <footer class="footer">
      Swarnava Vibhor Shayujyo
    </footer>

  </main>

  <div id="tickToast" class="tick-toast">
    <svg class="toast-tick" viewBox="0 0 52 52">
      <circle cx="26" cy="26" r="24" />
      <path d="M14 27 L22 35 L38 18" />
    </svg>
    <span id="tickToastText">Logged in successfully</span>
  </div>

  <script src="script.js"></script>
  <script>
    function showTick(message) {
      const toast = document.getElementById("tickToast");
      const text = document.getElementById("tickToastText");

      text.innerText = message;

      toast.classList.remove("show");
      void toast.offsetWidth;
      toast.classList.add("show");

      setTimeout(() => toast.classList.remove("show"), 2500);
    }
  </script>

</body>

</html>