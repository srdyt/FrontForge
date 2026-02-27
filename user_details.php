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
$profileId   = isset($_GET["id"]) ? (int)$_GET["id"] : $currentUser;

/* ================= GET USER ================= */
$stmt = $conn->prepare(
"SELECT id,name,username,email,created_at FROM users WHERE id=?"
);
$stmt->bind_param("i",$profileId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$page = basename($_SERVER['PHP_SELF']);

if(!$user){
    die("User not found");
}

/* ================= FOLLOW COUNT ================= */
$stmt = $conn->prepare("SELECT COUNT(*) FROM followers WHERE following_id=?");
$stmt->bind_param("i",$profileId);
$stmt->execute();
$stmt->bind_result($followers);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) FROM followers WHERE follower_id=?");
$stmt->bind_param("i",$profileId);
$stmt->execute();
$stmt->bind_result($following);
$stmt->fetch();
$stmt->close();

/* ================= FOLLOW STATUS ================= */
$stmt = $conn->prepare(
"SELECT id FROM followers WHERE follower_id=? AND following_id=?"
);
$stmt->bind_param("ii",$currentUser,$profileId);
$stmt->execute();
$stmt->store_result();
$isFollowing = $stmt->num_rows > 0;
$stmt->close();

$profileURL = "http://localhost:8000/user_details.php?id=".$user["id"];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($user["username"]) ?> | FrontForge</title>
<link rel="stylesheet" href="style.css">
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
<!-- ================= PROFILE CARD ================= -->

<div class="profile-horizontal">

    <!-- LEFT SIDE -->
    <div class="profile-left">

        <div class="avatar-big">
            <?= strtoupper(substr($user["username"],0,1)) ?>
        </div>

        <h2><?= htmlspecialchars($user["name"]) ?></h2>
        <div class="username">@<?= htmlspecialchars($user["username"]) ?></div>

        <div class="stats-row">
            <div>
                <b><?= $followers ?></b>
                <span>Followers</span>
            </div>

            <div>
                <b><?= $following ?></b>
                <span>Following</span>
            </div>
        </div>
        <div class="profile-actions">
        <?php if($user["id"] != $currentUser): ?>
        <button class="follow-modern"
            onclick="toggleFollow(<?= $user['id'] ?>)">
            <?= $isFollowing ? "Following" : "Follow" ?>
        </button>
        <button class="share-modern" onclick="shareProfile()">Share</button>
        <?php endif; ?>
        </div>
    </div>


    <!-- RIGHT SIDE -->
    <div class="profile-right">

        <div class="info-block">
            <div class="mail-block">
            <small>Email</small>
            <p id="emailText"><?= htmlspecialchars($user["email"]) ?></p>
             </div>
        <div class="mail-btn">
            <button class="copy-btn" id="copyEmailBtn" onclick=" navigator.clipboard.writeText(emailText.innerText); showTick('Email copied');">Copy</button>
        </div>
        </div>

        <div class="meta-row">
            <div>
                <small>User ID</small>
                <p>#<?= $user["id"] ?></p>
            </div>

            <div>
                <small>Joined</small>
                <p><?= date("Y-m-d", strtotime($user["created_at"])) ?></p>
            </div>
        </div>

       
    </div>

</div>


<div id="tickToast" class="tick-toast">
    <svg class="toast-tick" viewBox="0 0 52 52">
        <circle cx="26" cy="26" r="24"/>
        <path d="M14 27 L22 35 L38 18"/>
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

    if(!btn || !toast || !emailEl){
        console.log("Missing elements");
        return;
    }

    btn.onclick = () => {

        navigator.clipboard.writeText(emailEl.innerText)
        .then(() => {
            toast.classList.add("show");
            setTimeout(()=>toast.classList.remove("show"),2000);
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