<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}


require_once '../db.php';

$query = "SELECT * FROM users WHERE id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit;
}
$customerName = $user["first_name"] . " " . $user["last_name"]; // Get the admin's name

$profileImage = $user['profile_image'];

$profileImagePath = "../register/uploads/" . $profileImage;
if (!file_exists($profileImagePath)) {
    echo "Profile image not found: " . htmlspecialchars($profileImagePath);
    exit;
}
