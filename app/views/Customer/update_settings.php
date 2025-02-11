<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../db.php';

$user_id = $_SESSION['user_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$contact_number = $_POST['contact_number'];
$email = $_POST['email'];
$address = $_POST['address'];
$new_password = $_POST['new_password'];
$confirm_new_password = $_POST['confirm_new_password'];

// Handle profile image upload
$profile_image = $_FILES['profile_image']['name'];
$target_dir = "../register/uploads/";
$target_file = $target_dir . basename($profile_image);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if ($profile_image) {
    $check = getimagesize($_FILES['profile_image']['tmp_name']);
    if ($check === false) {
        echo "File is not an image.";
        exit;
    }

    // Check file size
    if ($_FILES['profile_image']['size'] > 5000000) {
        echo "Sorry, your file is too large.";
        exit;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        exit;
    }

    // Check if file already exists
    // if (file_exists($target_file)) {
    //     echo "Sorry, file already exists.";
    //     exit;
    // }

    if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
        echo "Sorry, there was an error uploading your file.";
        exit;
    }

    // Update profile image path in the database
    $query = "UPDATE users SET profile_image = :profile_image WHERE id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':profile_image', $profile_image);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}

// Update user information
$query = "UPDATE users SET first_name = :first_name, last_name = :last_name, contact_number = :contact_number, email = :email, address = :address WHERE id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':first_name', $first_name);
$stmt->bindParam(':last_name', $last_name);
$stmt->bindParam(':contact_number', $contact_number);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

// Update password if provided
if (!empty($new_password) && $new_password === $confirm_new_password) {
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $query = "UPDATE users SET password = :password WHERE id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}

header("Location: cu_profile.php");
exit;
?>