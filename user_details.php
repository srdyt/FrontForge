<?php
session_start();
include "db.php";
$loggedIn = isset($_SESSION["user_id"]);

/* ================= LOGIN CHECK ================= */
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$currentUser = $_SESSION["user_id"];
$profileId = isset($_GET["id"]) ? (int)$_GET["id"] : $currentUser;

/* ================= GET USER ================= */
$stmt = $conn->prepare(
    "SELECT id,name,username,email,created_at FROM users WHERE id=?"
);
$stmt->bind_param("i", $profileId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$page = basename($_SERVER['PHP_SELF']);

if (!$user) {
    die("User not found");
}

/* ================= FOLLOW COUNT ================= */
$stmt = $conn->prepare("SELECT COUNT(*) FROM followers WHERE following_id=?");
$stmt->bind_param("i", $profileId);
$stmt->execute();
$stmt->bind_result($followers);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) FROM followers WHERE follower_id=?");
$stmt->bind_param("i", $profileId);
$stmt->execute();
$stmt->bind_result($following);
$stmt->fetch();
$stmt->close();

/* ================= FOLLOW STATUS ================= */
$stmt = $conn->prepare(
    "SELECT id FROM followers WHERE follower_id=? AND following_id=?"
);
$stmt->bind_param("ii", $currentUser, $profileId);
$stmt->execute();
$stmt->store_result();
$isFollowing = $stmt->num_rows > 0;
$stmt->close();

$profileURL = "http://localhost:8000/user_details.php?id=" . $user["id"];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= htmlspecialchars($user["username"])?> | FrontForge
    </title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

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
            <h1 class="topbar-logo">Front<span>Forge</span></h1>
        </div>
        <div class="actions">
            <span class="welcome">
                Hi,
                <?php echo htmlspecialchars($_SESSION["username"]); ?>
            </span>
        </div>
    </header>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content">

        <!-- ================= PROFILE CARD ================= -->

        <div class="profile-horizontal">

            <!-- LEFT SIDE -->
            <div class="profile-left">

                <div class="avatar-big">
                    <?= strtoupper(substr($user["username"], 0, 1))?>
                </div>

                <h2>
                    <?= htmlspecialchars($user["name"])?>
                </h2>
                <div class="username">@
                    <?= htmlspecialchars($user["username"])?>
                </div>

                <div class="stats-row">
                    <div>
                        <b>
                            <?= $followers?>
                        </b>
                        <span>Followers</span>
                    </div>

                    <div>
                        <b>
                            <?= $following?>
                        </b>
                        <span>Following</span>
                    </div>
                </div>

                <div class="profile-actions">
                    <?php if ($user["id"] != $currentUser): ?>
                    <button class="follow-modern" onclick="toggleFollow(<?= $user['id']?>)">
                        <?= $isFollowing ? "Following" : "Follow"?>
                    </button>
                    <button class="share-modern" onclick="shareProfile()">Share</button>
                    <?php
endif; ?>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="profile-right">

                <div class="info-block">
                    <div class="mail-block">
                        <small>Email</small>
                        <p id="emailText">
                            <?= htmlspecialchars($user["email"])?>
                        </p>
                    </div>
                    <div class="mail-btn">
                        <button class="copy-btn" id="copyEmailBtn"
                            onclick=" navigator.clipboard.writeText(emailText.innerText); showTick('Email copied');">Copy</button>
                    </div>
                </div>

                <div class="meta-row">
                    <div>
                        <small>User ID</small>
                        <p>#
                            <?= $user["id"]?>
                        </p>
                    </div>

                    <div>
                        <small>Joined</small>
                        <p>
                            <?= date("Y-m-d", strtotime($user["created_at"]))?>
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </main>

    <div id="tickToast" class="tick-toast">
        <svg class="toast-tick" viewBox="0 0 52 52">
            <circle cx="26" cy="26" r="24" />
            <path d="M14 27 L22 35 L38 18" />
        </svg>
        <span id="tickToastText">Done</span>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="script.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const btn = document.getElementById("copyEmailBtn");
            const toast = document.getElementById("copyToast");
            const emailEl = document.getElementById("emailText");

            if (!btn || !toast || !emailEl) {
                console.log("Missing elements");
                return;
            }

            btn.onclick = () => {

                navigator.clipboard.writeText(emailEl.innerText)
                    .then(() => {
                        toast.classList.add("show");
                        setTimeout(() => toast.classList.remove("show"), 2000);
                    })
                    .catch(err => {
                        alert("Clipboard blocked. Use localhost or HTTPS.");
                        console.log(err);
                    });

            };

        });
    </script>

</body>

</html>