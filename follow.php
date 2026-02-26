<?php
session_start();
include "db.php";

if(!isset($_SESSION["user_id"])) exit();

$follower = $_SESSION["user_id"];
$following = $_POST["user_id"];

if($follower == $following) exit(); // can't follow yourself

// check if already following
$stmt = $conn->prepare("SELECT id FROM followers WHERE follower_id=? AND following_id=?");
$stmt->bind_param("ii", $follower, $following);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows > 0){
    // UNFOLLOW
    $del = $conn->prepare("DELETE FROM followers WHERE follower_id=? AND following_id=?");
    $del->bind_param("ii", $follower, $following);
    $del->execute();
    echo "unfollowed";
}else{
    // FOLLOW
    $ins = $conn->prepare("INSERT INTO followers(follower_id, following_id) VALUES(?,?)");
    $ins->bind_param("ii", $follower, $following);
    $ins->execute();
    echo "followed";
}
?>