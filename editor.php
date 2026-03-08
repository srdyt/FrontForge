<?php include "auth.php";
$page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Code Editor</title>

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=fullscreen" />
</head>

<body class="editor-page">

  <!-- ===== SIDEBAR ===== -->
  <nav class="sidebar" id="sidebar">
    <div class="sidebar-top">
      <img src="offline/FrontForge.png" alt="FrontForge" class="sidebar-logo">
    </div>

    <div class="sidebar-nav">
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
      <span class="panel-title">Code Editor</span>
    </div>

    <div class="actions">
      <span>Download: </span>
      <button class="primary" id="downloadHtml" onclick="showTick('HTML code downloaded');">HTML</button>
      <button class="primary" id="downloadCss" onclick="showTick('CSS code downloaded');">CSS</button>
      <button class="primary" id="downloadJs" onclick="showTick('JS code downloaded');">JS</button>
      <button class="primary" id="downloadProject" onclick="showTick('Project downloaded');">Project</button>
    </div>
  </header>

  <!-- ===== WORKSPACE ===== -->
  <main class="workspace">

    <section class="editor-panel">
      <div class="panel-header">Code Editor</div>

      <div class="editor-section">
        <span class="label"><span class="editor-html">HTML</span></span>
        <textarea id="htmlCode" placeholder="Write your HTML code here !html for boilerplate"></textarea>
        <div class="suggestions-box" id="htmlSuggestions"></div>
      </div>

      <div class="editor-section">
        <span class="label"><span class="editor-css">CSS</span></span>
        <textarea id="cssCode" placeholder="Write your CSS code here !css for boilerplate"></textarea>
        <div class="suggestions-box" id="cssSuggestions"></div>
      </div>

      <div class="editor-section">
        <span class="label"><span class="editor-js">JS</span></span>
        <textarea id="jsCode" placeholder="Write your JavaScript code here !js for"></textarea>
        <div class="suggestions-box" id="jsSuggestions"></div>
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
      <circle cx="26" cy="26" r="24" />
      <path d="M14 27 L22 35 L38 18" />
    </svg>
    <span id="tickToastText">Done</span>
  </div>

</body>

</html>