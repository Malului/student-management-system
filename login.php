<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG IN</title>
     <link rel="stylesheet" href="style.css"></head>

</head>
<body>
<h1>BSCS RECORD MANAGEMENT SYSTEM.</h1>

<div class="cont">
        <div class="container1">Login</div>
        <div class="container1">
            <form action="login.php" method="post">
            Username: <input type="email" name="username" required><br>
            Password: <input type="password" name="password" required><br>
            <input type="submit" name="login" value="Login" class="register-btn">
            </form>
        </div>

        <div class="container1">New here? <a href="index.php">Register</a></div>
</div>
    
<?php
		session_start();
		include_once('dbconnection.php');


		if (isset($_GET['message'])) {
		    $message = $_GET['message'];
		    echo "<div style='color:green;'>$message</div>";
		}

		// Login user
		if (isset($_POST['login'])) {
	    $username = sanitize_input($_POST['username']);
	    $password = sanitize_input($_POST['password']);

	    $sql = "SELECT * FROM users WHERE username='$username'";
	    $result = $conn->query($sql);

			    
		if ($result->num_rows > 0) { // Check if at least one row is returned
		    $row = $result->fetch_assoc();
		    if (password_verify($password, $row['password'])) {
		        // Create a session
		        $_SESSION['username'] = $username;
		        header("Location: dashboard.php");
		        exit();
		    } else {
		        // Incorrect password
		        display_feedback("Incorrect username or password", false);
		    }
		} else {
		    // No user found with the provided username
		    display_feedback("User not found", false);
		}
	}


?>
</body>
</html>