<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $notes = $_POST['notes'];

    // Sanitize input to prevent SQL injection
    $date = $conn->quote($date);
    $time = $conn->quote($time);
    $notes = $conn->quote($notes);

    // Update the appointment in the database
    $sql = "UPDATE appointment SET date=$date, time=$time, notes=$notes WHERE id=$id";
    if ($conn->exec($sql) === TRUE) {
        echo "<p style='color: green;'>Appointment updated successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->errorInfo()[2] . "</p>";
    }

    header("Location: cu_profile.php");
    exit();
}
?>