<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Include database connection code
include('server.php');

// Check if the form is submitted for account deletion
if (isset($_POST['delete_user'])) {
    // Get the username of the currently logged-in user
    $currentUsername = $_SESSION['username'];

    // Delete the user's account
    $query = "DELETE FROM users WHERE username = '$currentUsername'";
    mysqli_query($db, $query);

    // Destroy the session and redirect to a success or login page
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <h1>Delete Account</h1>
    <p>Are you sure you want to delete your account?</p>
    <form method="post" action="delete.php">
        <input type="submit" name="delete_user" value="Yes, Delete My Account">
    </form>
</body>
</html>
