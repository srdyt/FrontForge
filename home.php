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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jacquard+24&family=New+Rocker&display=swap" rel="stylesheet">
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
<?php if(isset($_SESSION["login_success"])): ?>
<script>
window.onload = () => showTick("Login successful ");
</script>
<?php unset($_SESSION["login_success"]); endif; ?>
<?php if(isset($_GET['success'])): ?>
<script>
window.onload = () => showTick("Feedback submitted");
</script>
<?php endif; ?>
 <section class="section hero">
    <p class="subtitle">A MODERN WEB TOOL</p>
    <h1 class="logo">Front<span>Forge</span></h1>
    <p class="tagline">Build. Preview. Deploy.</p>
  </section>

  <section class="section features">
    <div class="feature-grid">
      <div class="feature-card">
        <h3>HTML</h3>
        <p>Write clean structure with instant preview.</p>
      </div>

      <div class="feature-card">
        <h3>CSS</h3>
        <p>Style your UI in real-time.</p>
      </div>

      <div class="feature-card">
        <h3>JavaScript</h3>
        <p>Add logic and interactivity instantly.</p>
      </div>
    </div>

    <p class="desc">
      FrontForge is a lightweight live editor that lets you write, test,  
      and preview your web code in real-time — all in one place.
    </p>

    <button class="btn" onclick="window.location.href='editor.php'">
  OPEN EDITOR
</button>
  </section>

  <section class="section usecase">

    <div class="use-grid">
      <div class="use-card">
        <h4>Fast Preview</h4>
        <p>No refresh needed. See changes instantly.</p>
      </div>

      <div class="use-card">
        <h4>Beginner Friendly</h4>
        <p>Simple UI for learning HTML, CSS & JS.</p>
      </div>

      <div class="use-card">
        <h4>Project Ready</h4>
        <p>Test components before deploying.</p>
      </div>
    </div>
  </section>

  <section class="section contact">
    <div class="contact-left">
      <h2>CONTACT</h2>
      <p>Have suggestions or feature requests?</p>
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
<div id="tickToast" class="tick-toast">
    <svg class="toast-tick" viewBox="0 0 52 52">
        <circle cx="26" cy="26" r="24"/>
        <path d="M14 27 L22 35 L38 18"/>
    </svg>
    <span id="tickToastText">Logged in successfully</span>
</div>

<script src="script.js"></script>
<script>
function showTick(message){
    const toast = document.getElementById("tickToast");
    const text  = document.getElementById("tickToastText");

    text.innerText = message;

    toast.classList.remove("show");
    void toast.offsetWidth; // restart animation
    toast.classList.add("show");

    setTimeout(()=>toast.classList.remove("show"),2500);
}

</script>
</body>
</html>