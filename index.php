<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registration</title>
	 <link rel="stylesheet" href="style.css"></head>

</head>
<body>

<h1>BSCS RECORD MANAGEMENT SYSTEM.</h1>

<div class="cont">
	<div class="container1">NEW HERE? REGISTER</div>
	<div class = "container1">
		<form action = "index.php" method="post">
			Username: <input type="email" name="username" required><br>
			Password: <input type="password" name="password" required><br>
			<input type="submit" name="register" value="Register" class="register-btn">
		</form>
	</div>
	<div class = "container1">Alredy have an account?<a href="login.php">Log In</a></div>
</div>





<?php

		session_start();
		include_once('dbconnection.php');


		

		if (isset($_GET['message'])) {
		    $message = $_GET['message'];
		    echo "<div style='color:green;'>$message</div>";
		}

		// Register user
	if (isset($_POST['register'])) {
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Check if the username already exists
    $check_sql = "SELECT * FROM users WHERE username='$username'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        display_feedback("Username already exists. Please choose a different username.", false);
    } else {
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            display_feedback("Registration successful.");
            header("Refresh:2; url=login.php");

            exit();
        } else {
            display_feedback("Error: " . $sql . "<br>" . $conn->error, false);
        }
    }
}


	
?>



</body>
</html>