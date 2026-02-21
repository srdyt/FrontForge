<?php include "auth.php"; ?>
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

  <nav id="sidebar" class="sidebar">
    <h2 class="sidebar-title">FrontForge</h2>
    <ul>
    <a href="home.php"><li>Home</li></a>
    <a href="editor.php"><li class="active">Editor</li></a>
    </ul>
  </nav>

  <div id="overlay" class="overlay"></div>
    <div class="actions">
      <span>Download: </span>
      <button class="primary" id="downloadHtml">HTML</button>
      <button class="primary" id="downloadCss">CSS</button>
      <button class="primary" id="downloadJs">JS</button>
      <button class="primary" id="downloadProject">Project</button>
      <button class="primary" id="Logout"><a href="logout.php">Logout</a></button>
    </div>
  </header>

  <main class="workspace">

    <section class="editor-panel">
      <div class="panel-header">Code Editor</div>

      <div class="editor-section">
        <span class="label"><span class="editor-html">HTML</span></span>
        <textarea id="htmlCode" placeholder="Write your HTML code here "></textarea>
      </div>

      <div class="editor-section">
        <span class="label"><span class="editor-css">CSS</span></span>
        <textarea  id="cssCode" placeholder="Write your CSS code here"></textarea>
      </div>

      <div class="editor-section">
        <span class="label"><span class="editor-js">JS</span></span>
        <textarea id="jsCode" placeholder="Write your JavaScript code here"></textarea>
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

</body>
</html>