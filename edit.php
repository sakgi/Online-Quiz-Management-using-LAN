<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Include database connection code
include('server.php');

// Initialize variables for form input and errors
$newUsername = "";
$newEmail = "";
$newPassword = "";
$errors = array();

// Get the username of the currently logged-in user
$currentUsername = $_SESSION['username'];

// Check if the form is submitted for editing
if (isset($_POST['edit_user'])) {
    // Get user inputs
    $newUsername = mysqli_real_escape_string($db, $_POST['new_username']);
    $newEmail = mysqli_real_escape_string($db, $_POST['new_email']);
    $newPassword = $_POST['new_password']; // Password is unencrypted

    // Validate user inputs
    if (empty($newUsername)) {
        array_push($errors, "New username is required");
    }
    if (empty($newEmail)) {
        array_push($errors, "New email is required");
    }
    if (empty($newPassword)) {
        array_push($errors, "New password is required");
    }

    // Check if there are any errors
    if (count($errors) == 0) {
        // Update user information for the current user
        $query = "UPDATE users SET username = '$newUsername', email = '$newEmail', password = '$newPassword' WHERE username = '$currentUsername'";
        mysqli_query($db, $query);

        // Redirect to a success page or back to the profile page
        header("Location: login.php");
        exit;
    }
}

// Retrieve the current user's information
$query = "SELECT username, email FROM users WHERE username = '$currentUsername'";
$result = mysqli_query($db, $query);
$userInfo = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($db);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Edit Profile</h1>
    <?php if (count($errors) > 0) : ?>
        <div class="error">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo $error; ?></p>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    <form method="post" action="edit.php">
        <div class="form-group">
            <label>New Username:</label>
            <input type="text" name="new_username" value="<?php echo $userInfo['username']; ?>">
        </div>

        <div class="form-group">
            <label>New Email:</label>
            <input type="email" name="new_email" value="<?php echo $userInfo['email']; ?>">
        </div>

        <div class="form-group">
            <label>New Password:</label>
            <input type="password" name="new_password" placeholder="Enter New Password">
        </div>

        <input type="submit" name="edit_user" value="Save Changes">
    </form>
</body>
</html>