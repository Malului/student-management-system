<?php


		// Database connection
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "bscsdb";

		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		// Function to sanitize user input
			function sanitize_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}

		

//Feedback message as toast message
		
	function display_feedback($message, $is_success = true) {
    // Escape special characters in the message
    $escaped_message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    
    // Output JavaScript code to show the toast message
    echo "<script>
            // Create a function to show the toast message
            function showToast(message, isSuccess) {
                var toast = document.createElement('div');
                toast.textContent = message;
                toast.style.backgroundColor = isSuccess ? '#4caf50' : '#f44336'; // Green for success, red for error
                toast.style.color = 'white';
                toast.style.padding = '15px 20px';
                toast.style.borderRadius = '5px';
                toast.style.boxShadow = '0 4px 10px rgba(0, 0, 0, 0.2)';
                toast.style.position = 'fixed';
                toast.style.bottom = '30px'; 
                toast.style.left = '50%';
                toast.style.transform = 'translateX(-50%)';
                toast.style.zIndex = '1000';
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease-in-out';
                document.body.appendChild(toast);
                setTimeout(function(){
                    toast.style.opacity = '1';
                    setTimeout(function() {
                        toast.style.opacity = '0';
                        setTimeout(function() {
                            toast.remove();
                        }, 300);
                    }, 3000);
                }, 100);
            }
            // Call the showToast function with the escaped message
            showToast('$escaped_message', $is_success);
          </script>";
}
?>