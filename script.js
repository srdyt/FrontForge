/* ===============================
   SAFE ELEMENT HELPER
================================ */
function get(id) {
  return document.getElementById(id);
}

const htmlCode = document.getElementById("htmlCode");
const cssCode = document.getElementById("cssCode");
const jsCode = document.getElementById("jsCode");
const output = document.getElementById("output");

if (htmlCode && cssCode && jsCode && output) {

  function updatePreview() {
    const html = htmlCode.value;
    const css = `<style>${cssCode.value}</style>`;
    const js = `<script>${jsCode.value}<\/script>`;
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


  /* ===============================
     AUTOCOMPLETE SUGGESTIONS
  ================================ */

  const htmlKeywords = [
    "<div>", "<span>", "<section>", "<header>", "<footer>", "<nav>", "<main>", "<aside>",
    "<article>", "<h1>", "<h2>", "<h3>", "<h4>", "<h5>", "<h6>", "<p>", "<a>", "<img>",
    "<ul>", "<ol>", "<li>", "<table>", "<tr>", "<td>", "<th>", "<thead>", "<tbody>",
    "<form>", "<input>", "<button>", "<textarea>", "<select>", "<option>", "<label>",
    "<script>", "<style>", "<link>", "<meta>", "<title>", "<head>", "<body>", "<html>",
    "<br>", "<hr>", "<strong>", "<em>", "<b>", "<i>", "<u>", "<pre>", "<code>",
    "<iframe>", "<video>", "<audio>", "<source>", "<canvas>", "<svg>",
    "class", "id", "href", "src>", "alt", "type", "name", "value",
    "placeholder", "action", "method", "onclick", "onload",
    "<!DOCTYPE html>", "<charset>", "<viewport>"
  ];

  const cssKeywords = [
    "background", "background-color", "background-image", "background-size",
    "border", "border-radius", "border-color", "border-bottom", "border-top",
    "box-shadow", "box-sizing",
    "color", "cursor",
    "display", "flex", "grid", "block", "inline", "none",
    "flex-direction", "flex-wrap", "flex-grow",
    "font-family", "font-size", "font-weight", "font-style",
    "gap", "grid-template-columns", "grid-template-rows",
    "height", "width", "min-height", "max-height", "min-width", "max-width",
    "justify-content", "align-items", "align-self",
    "letter-spacing", "line-height",
    "margin", "margin-top", "margin-bottom", "margin-left", "margin-right",
    "opacity", "overflow", "overflow-x", "overflow-y",
    "padding", "padding-top", "padding-bottom", "padding-left", "padding-right",
    "position", "absolute", "relative", "fixed", "sticky",
    "text-align", "text-decoration", "text-transform",
    "top", "bottom", "left", "right",
    "transform", "transition", "animation",
    "z-index",
    "hover", "active", "focus", "visited",
    "@media", "@keyframes", "@import",
    "linear-gradient", "radial-gradient",
    "rgba(", "calc(", "var(", "clamp("
  ];

  const jsKeywords = [
    "document", "document.getElementById()", "document.querySelector()",
    "document.querySelectorAll()", "document.createElement()",
    "document.addEventListener()",
    "window", "window.onload", "window.location",
    "console.log()", "console.error()", "console.warn()",
    "function", "const", "let", "var", "return",
    "if", "else", "else if", "switch", "case", "break", "default",
    "for", "while", "do", "forEach", "map", "filter", "reduce",
    "addEventListener()", "removeEventListener()",
    "setTimeout()", "setInterval()", "clearTimeout()", "clearInterval()",
    "fetch()", "async", "await", "then()", "catch()",
    "JSON.parse()", "JSON.stringify()",
    "Math.random()", "Math.floor()", "Math.ceil()", "Math.round()",
    "Array.from()", "Object.keys()", "Object.values()",
    "classList.add()", "classList.remove()", "classList.toggle()",
    "innerHTML", "innerText", "textContent", "value",
    "style", "className", "setAttribute()",
    "parseInt()", "parseFloat()", "toString()",
    "true", "false", "null", "undefined",
    "try", "catch", "finally", "throw", "new", "this",
    "import", "export", "class", "extends", "constructor", "super",
    "=>"
  ];

  // Map each textarea to its keyword list and dropdown
  const editorMap = [
    { textarea: htmlCode, keywords: htmlKeywords, box: get("htmlSuggestions") },
    { textarea: cssCode, keywords: cssKeywords, box: get("cssSuggestions") },
    { textarea: jsCode, keywords: jsKeywords, box: get("jsSuggestions") }
  ];

  let activeIndex = -1;  // keyboard nav index
  let activeBox = null;
  let activeTextarea = null;
  let activeWord = "";

  function getLastWord(text) {
    // Get the last word/token being typed (supports letters, digits, -, _, ., <, !, $, @, ()
    const match = text.match(/[a-zA-Z0-9\-_.$!@<(]+$/);
    return match ? match[0] : "";
  }

  function highlightMatch(keyword, typed) {
    const lower = keyword.toLowerCase();
    const idx = lower.indexOf(typed.toLowerCase());
    if (idx === -1) return keyword;
    const before = keyword.substring(0, idx);
    const matched = keyword.substring(idx, idx + typed.length);
    const after = keyword.substring(idx + typed.length);
    return `${before}<span class="match">${matched}</span>${after}`;
  }

  function showSuggestions(textarea, keywords, box, typed) {
    if (typed.length < 1) {
      box.style.display = "none";
      return;
    }

    const matches = keywords.filter(k =>
      k.toLowerCase().includes(typed.toLowerCase())
    ).slice(0, 8);  // max 8 suggestions

    if (matches.length === 0) {
      box.style.display = "none";
      return;
    }

    activeBox = box;
    activeTextarea = textarea;
    activeWord = typed;
    activeIndex = -1;

    box.innerHTML = "";
    matches.forEach((word, i) => {
      const div = document.createElement("div");
      div.className = "suggestion-item";
      div.innerHTML = highlightMatch(word, typed);
      div.addEventListener("mousedown", (e) => {
        e.preventDefault();
        insertSuggestion(word);
      });
      box.appendChild(div);
    });

    box.style.display = "block";
  }

  function insertSuggestion(word) {
    if (!activeTextarea || !activeWord) return;

    const pos = activeTextarea.selectionStart;
    const text = activeTextarea.value;
    const before = text.substring(0, pos - activeWord.length);
    const after = text.substring(pos);

    activeTextarea.value = before + word + after;
    const newPos = before.length + word.length;
    activeTextarea.selectionStart = activeTextarea.selectionEnd = newPos;

    if (activeBox) activeBox.style.display = "none";
    activeTextarea.focus();
    updatePreview();
  }

  function hideAllSuggestions() {
    editorMap.forEach(e => { if (e.box) e.box.style.display = "none"; });
    activeBox = null;
    activeIndex = -1;
  }

  // Attach input listeners for suggestions
  editorMap.forEach(({ textarea, keywords, box }) => {
    if (!textarea || !box) return;

    textarea.addEventListener("input", () => {
      const text = textarea.value.substring(0, textarea.selectionStart);
      const lastWord = getLastWord(text);
      showSuggestions(textarea, keywords, box, lastWord);
    });

    textarea.addEventListener("blur", () => {
      setTimeout(() => { if (box) box.style.display = "none"; }, 150);
    });
  });

  // Keyboard navigation for suggestions
  document.addEventListener("keydown", (e) => {
    if (!activeBox || activeBox.style.display === "none") return;

    const items = activeBox.querySelectorAll(".suggestion-item");
    if (items.length === 0) return;

    if (e.key === "ArrowDown") {
      e.preventDefault();
      activeIndex = Math.min(activeIndex + 1, items.length - 1);
      items.forEach((el, i) => el.classList.toggle("active", i === activeIndex));
      items[activeIndex].scrollIntoView({ block: "nearest" });
    }

    else if (e.key === "ArrowUp") {
      e.preventDefault();
      activeIndex = Math.max(activeIndex - 1, 0);
      items.forEach((el, i) => el.classList.toggle("active", i === activeIndex));
      items[activeIndex].scrollIntoView({ block: "nearest" });
    }

    else if ((e.key === "Enter" || e.key === "Tab") && activeIndex >= 0) {
      e.preventDefault();
      const selected = items[activeIndex].textContent;
      insertSuggestion(selected);
    }

    else if (e.key === "Escape") {
      hideAllSuggestions();
    }
  });


  /* ===============================
     AUTO-CLOSE TAGS & BRACKETS
  ================================ */

  const selfClosingTags = ["img", "br", "hr", "input", "meta", "link", "source", "area", "base", "col", "embed", "track", "wbr"];

  const bracketPairs = {
    "{": "}",
    "(": ")",
    "[": "]"
  };

  const quotePairs = {
    '"': '"',
    "'": "'"
  };

  // Auto-close HTML tags on ">" typed in the HTML textarea
  htmlCode.addEventListener("input", function () {
    const pos = this.selectionStart;
    const text = this.value;
    const lastChar = text[pos - 1];

    if (lastChar !== ">") return;

    // Find the last opened tag before cursor
    const beforeCursor = text.substring(0, pos);
    const match = beforeCursor.match(/<([a-zA-Z][a-zA-Z0-9]*)([^>]*)>$/);

    if (!match) return;
    const tag = match[1].toLowerCase();

    // Skip self-closing tags
    if (selfClosingTags.includes(tag)) return;

    // Skip if it's a closing tag like </div>
    if (match[0].startsWith("</")) return;

    // Skip if closing tag already exists right after cursor
    const afterCursor = text.substring(pos);
    if (afterCursor.startsWith(`</${tag}>`)) return;

    const closingTag = `</${tag}>`;
    this.value = beforeCursor + closingTag + afterCursor;
    this.selectionStart = this.selectionEnd = pos;
    updatePreview();
  });

  // Auto-close brackets and quotes for ALL textareas
  [htmlCode, cssCode, jsCode].forEach(textarea => {

    textarea.addEventListener("keydown", function (e) {
      const start = this.selectionStart;
      const end = this.selectionEnd;
      const text = this.value;

      // Auto-close brackets
      if (bracketPairs[e.key]) {
        e.preventDefault();
        const open = e.key;
        const close = bracketPairs[open];
        this.value = text.substring(0, start) + open + close + text.substring(end);
        this.selectionStart = this.selectionEnd = start + 1;
        updatePreview();
        return;
      }

      // Auto-close quotes
      if (quotePairs[e.key]) {
        const quote = e.key;
        // If next char is already the same quote, just skip over it
        if (text[start] === quote) {
          e.preventDefault();
          this.selectionStart = this.selectionEnd = start + 1;
          return;
        }
        e.preventDefault();
        this.value = text.substring(0, start) + quote + quote + text.substring(end);
        this.selectionStart = this.selectionEnd = start + 1;
        updatePreview();
        return;
      }

      // Skip closing bracket if already there
      if (e.key === "}" || e.key === ")" || e.key === "]") {
        if (text[start] === e.key) {
          e.preventDefault();
          this.selectionStart = this.selectionEnd = start + 1;
          return;
        }
      }

      // Backspace: delete matching pair
      if (e.key === "Backspace" && start === end && start > 0) {
        const before = text[start - 1];
        const after = text[start];
        if (
          (before === "{" && after === "}") ||
          (before === "(" && after === ")") ||
          (before === "[" && after === "]") ||
          (before === '"' && after === '"') ||
          (before === "'" && after === "'")
        ) {
          e.preventDefault();
          this.value = text.substring(0, start - 1) + text.substring(start + 1);
          this.selectionStart = this.selectionEnd = start - 1;
          updatePreview();
          return;
        }
      }
    });
  });

}


/* Sidebar is now CSS-only (hover to expand) — no JS toggle needed */

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

function insertTemplate(textarea, template) {
  textarea.value = template;
  textarea.focus();
  textarea.selectionStart = textarea.selectionEnd = textarea.value.length;
}

function setupEditor(id, trigger, template) {
  const textarea = get(id);
  if (!textarea) return;

  textarea.addEventListener("input", function () {
    if (this.value.trim() === trigger) {
      insertTemplate(this, template);
    }
  });

  textarea.addEventListener("keydown", function (e) {
    if (e.key === "Tab" && this.value.trim() === trigger) {
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



function copyText(text) {
  navigator.clipboard.writeText(text)
    .then(showCopiedToast)
    .catch(() => {
      const temp = document.createElement("textarea");
      temp.value = text;
      document.body.appendChild(temp);
      temp.select();
      document.execCommand("copy");
      document.body.removeChild(temp);
      showCopiedToast();
    });
}




function toggleFollow(userId) {
  fetch("follow.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "user_id=" + userId
  })
    .then(() => location.reload());
}

new QRCode(document.getElementById("qr"), {
  text: "<?= $profileURL ?>",
  width: 150,
  height: 150
});

function shareProfile() {

  const url = window.location.href;
  const text = "Check out this profile 👀";

  // Mobile native share
  if (navigator.share) {
    navigator.share({
      title: document.title,
      text: text,
      url: url
    });
  }
  // Desktop fallback → copy link
  else {
    navigator.clipboard.writeText(url);
    alert("Profile link copied!");
  }
}


function showTick(message = "Done") {

  const toast = document.getElementById("tickToast");
  const text = document.getElementById("tickToastText");

  text.innerText = message;

  // restart animation
  toast.classList.remove("show");
  void toast.offsetWidth;

  toast.classList.add("show");

  setTimeout(() => {
    toast.classList.remove("show");
  }, 2200);
}


window.onload = () => {
  const params = new URLSearchParams(window.location.search);

  if (params.get("login") === "success") {
    showTick("Login successful");
  }
};

