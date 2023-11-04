
<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        
        h1 {
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #333;
            color: #fff;
        }
        
        a {
            text-decoration: none;
        }
        
        .btn {
            display: inline-block;
            padding: 8px 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>User List</h1>

    <?php
    // Database connection setup (replace with your own credentials)
    $db = mysqli_connect("localhost", "root", "", "parthproject");

    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query to fetch user data from the database (adjust table and column names)
    $query = "SELECT username, password, email FROM users";
    $result = mysqli_query($db, $query);

    if ($result) {
        echo '<table border="1">';
        echo '<tr>';
        echo '<th>Username</th>';
        echo '<th>Password</th>';
        echo '<th>Email</th>';
        echo '<th>Action</th>';
        echo '</tr>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['username'] . '</td>';
            echo '<td>' . $row['password'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>';
        
            echo '<a href="edit.php?username=' . $row['username'] . '">Edit</a> | ';
            echo '<a href="delete.php?username=' . $row['username'] . '" onclick="return confirm(\'Are you sure you want to delete this user?\');">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '<input type="submit" class="btn" value="Save">'; // Add Save button
        echo 'form';

        // Free the result set
        mysqli_free_result($result);
    } else {
        echo "Error: " . mysqli_error($db);
    }

    // Close the database connection
    mysqli_close($db);
    ?>

    <br>
    <a href="register.php">Add New User</a>
    
</body>
</html>
