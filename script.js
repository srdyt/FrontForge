const htmlCode = document.getElementById("htmlCode");
const cssCode  = document.getElementById("cssCode");
const jsCode   = document.getElementById("jsCode");
const output   = document.getElementById("output");

if (htmlCode && cssCode && jsCode && output) {

  function updatePreview() {
    const html = htmlCode.value;
    const css  = `<style>${cssCode.value}</style>`;
    const js   = `<script>${jsCode.value}<\/script>`;
    output.srcdoc = html + css + js;
  }

  htmlCode.addEventListener("input", updatePreview);
  cssCode.addEventListener("input", updatePreview);
  jsCode.addEventListener("input", updatePreview);

  updatePreview();

  function downloadFile(filename, content) {
    const blob = new Blob([content], { type: "text/plain" });
    const url = URL.createObjectURL(blob);
    const link = document.createElement("a");
    link.href = url;
    link.download = filename;
    link.click();
    URL.revokeObjectURL(url);
  }

  document.getElementById("downloadHtml")?.addEventListener("click", () =>
    downloadFile("index.html", htmlCode.value)
  );
  document.getElementById("downloadCss")?.addEventListener("click", () =>
    downloadFile("style.css", cssCode.value)
  );
  document.getElementById("downloadJs")?.addEventListener("click", () =>
    downloadFile("script.js", jsCode.value)
  );
  document.getElementById("downloadProject")?.addEventListener("click", () => {
    downloadFile("index.html", htmlCode.value);
    downloadFile("style.css", cssCode.value);
    downloadFile("script.js", jsCode.value);
  });
}

const hamburger = document.getElementById("hamburger");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");

if (hamburger && sidebar && overlay) {
  hamburger.addEventListener("click", () => {
    sidebar.classList.toggle("open");
    overlay.classList.toggle("show");
  });

  overlay.addEventListener("click", () => {
    sidebar.classList.remove("open");
    overlay.classList.remove("show");
  });

  
}

const fullscreenBtn = document.querySelector('.fullscreen-button');
const workspace = document.querySelector('.workspace');
const slider = document.getElementById('viewSlider');
const toggle = document.getElementById('viewToggle');
const label = document.querySelector('.toggle-label');

let isFullscreen = false;

fullscreenBtn.addEventListener('click', () => {
  isFullscreen = !isFullscreen;

  workspace.classList.toggle('fullscreen', isFullscreen);
  toggle.classList.toggle('hidden', !isFullscreen);

  // Default to output view
  workspace.classList.add('show-output');
  workspace.classList.remove('show-code');

  slider.value = 1;
  label.textContent = 'Output';
});

slider.addEventListener('input', () => {
  if (slider.value === "0") {
    workspace.classList.add('show-code');
    workspace.classList.remove('show-output');
    label.textContent = 'Code';
  } else {
    workspace.classList.add('show-output');
    workspace.classList.remove('show-code');
    label.textContent = 'Output';
  }
});


