/* ===============================
   SAFE ELEMENT HELPER
================================ */
function get(id){
    return document.getElementById(id);
}

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
/* ===============================
   BOILERPLATE TRIGGERS
================================ */

const templates = {
html: `<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>FrontForge Project</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Hello FrontForge 🚀</h1>

<script src="script.js"></script>
</body>
</html>`,

css: `*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:system-ui;
background:#111;
color:white;
}`,

js: `document.addEventListener("DOMContentLoaded",()=>{
console.log("FrontForge Ready 🚀");
});`
};

function insertTemplate(textarea, template){
    textarea.value = template;
    textarea.focus();
    textarea.selectionStart = textarea.selectionEnd = textarea.value.length;
}

function setupEditor(id, trigger, template){
    const textarea = get(id);
    if (!textarea) return;

    textarea.addEventListener("input", function(){
        if(this.value.trim() === trigger){
            insertTemplate(this, template);
        }
    });

    textarea.addEventListener("keydown", function(e){
        if(e.key === "Tab" && this.value.trim() === trigger){
            e.preventDefault();
            insertTemplate(this, template);
        }
    });
}

setupEditor("htmlCode", "!html", templates.html);
setupEditor("cssCode", "!css", templates.css);
setupEditor("jsCode", "!js", templates.js);


/* ===============================
   COPY EMAIL
================================ */



function copyText(text){
    navigator.clipboard.writeText(text)
        .then(showCopiedToast)
        .catch(()=>{
            const temp = document.createElement("textarea");
            temp.value = text;
            document.body.appendChild(temp);
            temp.select();
            document.execCommand("copy");
            document.body.removeChild(temp);
            showCopiedToast();
        });
}




function toggleFollow(userId){
    fetch("follow.php",{
        method:"POST",
        headers:{ "Content-Type":"application/x-www-form-urlencoded"},
        body:"user_id="+userId
    })
    .then(()=>location.reload());
}

new QRCode(document.getElementById("qr"), {
    text: "<?= $profileURL ?>",
    width: 150,
    height: 150
});

function shareProfile(){

    const url = window.location.href;
    const text = "Check out this profile 👀";

    // Mobile native share
    if(navigator.share){
        navigator.share({
            title: document.title,
            text: text,
            url: url
        });
    }
    // Desktop fallback → copy link
    else{
        navigator.clipboard.writeText(url);
        alert("Profile link copied!");
    }
}


function showTick(message="Done"){

    const toast = document.getElementById("tickToast");
    const text  = document.getElementById("tickToastText");

    text.innerText = message;

    // restart animation
    toast.classList.remove("show");
    void toast.offsetWidth;

    toast.classList.add("show");

    setTimeout(()=>{
        toast.classList.remove("show");
    },2200);
}


window.onload = () => {
    const params = new URLSearchParams(window.location.search);

    if(params.get("login") === "success"){
        showTick("Login successful");
    }
};

