<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Delete the appointment from the database
    $sql = "DELETE FROM appointment WHERE id=$id";
    if ($conn->exec($sql) === TRUE) {
        echo "<p style='color: green;'>Appointment deleted successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->errorInfo()[2] . "</p>";
    }

    header("Location: cu_profile.php");
    exit();
}
?>