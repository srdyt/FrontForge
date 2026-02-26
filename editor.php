<?php include "auth.php"; 
$page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Code Editor</title>

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=fullscreen" />
</head>

<body>
  
  <header class="topbar">
    <button id="hamburger" class="hamburger">☰</button>

  <div class="sidebar" id="sidebar">
    <div>
        <h3 class="sidebar-title">FrontForge</h3>
        <ul>
            <a href="home.php"><li>Home</li></a>
            <a href="editor.php"><li class="active">Editor</li></a>
            <a href="user_search.php"><li>Search Users</li></a>
        </ul>
    </div>

    <div class="sidebar-bottom">
        <a href="user_details.php">
            <ul class="active"><?= htmlspecialchars($_SESSION["username"]) ?></ul>
        </a>
    </div>
</div>

  <div id="overlay" class="overlay"></div>
   <div class="topbar-center">
        <a href="home.php" class="quick-icon <?= $page=='home.php' ? 'active' : '' ?>"><img src="offline/home.png"></a>
        <a href="projects.php" class="quick-icon <?= $page=='projects.php' ? 'active' : '' ?>"><img src="offline/files.png"></a>
        <a href="teams.php" class="quick-icon <?= $page=='teams.php' ? 'active' : '' ?>"><img src="offline/group.png"></a>
        <a href="editor.php" class="quick-icon <?= $page=='editor.php' ? 'active' : '' ?>"><img src="offline/code.png"></a>
        <a href="user_details.php" class="quick-icon <?= $page=='user_details.php' ? 'active' : '' ?>"><img src="offline/person.png"></a>
    </div>
    <div class="actions">
      <span>Download: </span>
      <button class="primary" id="downloadHtml" onclick="showTick('HTML code downloaded');">HTML</button>
      <button class="primary" id="downloadCss" onclick="showTick('CSS code downloaded');">CSS</button>
      <button class="primary" id="downloadJs" onclick="showTick('JS code downloaded');">JS</button>
      <button class="primary" id="downloadProject" onclick="showTick('Project downloaded');">Project</button>
      <button class="primary" id="Logout"><a href="logout.php">Logout</a></button>
    </div>
  </header>

  <main class="workspace">

    <section class="editor-panel">
      <div class="panel-header">Code Editor</div>

      <div class="editor-section">
        <span class="label"><span class="editor-html">HTML</span></span>
        <textarea id="htmlCode" placeholder="Write your HTML code here !html for boilerplate"></textarea>
      </div>

      <div class="editor-section">
        <span class="label"><span class="editor-css">CSS</span></span>
        <textarea  id="cssCode" placeholder="Write your CSS code here !css for boilerplate"></textarea>
      </div>

      <div class="editor-section">
        <span class="label"><span class="editor-js">JS</span></span>
        <textarea id="jsCode" placeholder="Write your JavaScript code here !js for"></textarea>
      </div>
    </section>

    <section class="preview-panel">
  <header class="panel-header">
    <span class="panel-title">Live Preview</span>

    <div class="panel-actions">
      <div class="view-toggle hidden" id="viewToggle">
  <input type="range" min="0" max="1" step="1" value="1" id="viewSlider">
  <span class="toggle-label">Output</span>
      </div>
      <button class="fullscreen-button" aria-label="Fullscreen preview">
        <span class="material-symbols-outlined">fullscreen</span>
      </button>
    </div>
  </header>
    <iframe id="output"></iframe>
</section>


  </main>
  <script src="script.js"></script>
<div id="tickToast" class="tick-toast">
    <svg class="toast-tick" viewBox="0 0 52 52">
        <circle cx="26" cy="26" r="24"/>
        <path d="M14 27 L22 35 L38 18"/>
    </svg>

    <span id="tickToastText">Done</span>
</div>
</body>
</html>