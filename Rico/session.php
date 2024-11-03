<?php
session_start();

// Check if the user is logged in by checking for email and user ID
if (!isset($_SESSION['email']) || !isset($_SESSION['regID'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details from the session
$email = htmlspecialchars($_SESSION['email']);
$Fname = htmlspecialchars($_SESSION['Fname']);
$Midname = htmlspecialchars($_SESSION['Midname']);
$Lname = htmlspecialchars($_SESSION['Lname']);
$userId = htmlspecialchars($_SESSION['regID']);
$facultyID = htmlspecialchars($_SESSION['facultyID']);



// Proceed with the rest of your logic
// Example: Fetching user data from the database, etc.
?>
