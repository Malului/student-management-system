<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Management System.</title>
 <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="javascipt.js"></script>
</head>

<body>
    <h1>BSCS RECORD MANAGEMENT SYSTEM.</h1>

    <div class="container">
        <div class="cont1">Add Record</div>
        <div class="cont2">
            <form action="dashboard.php" method="post">
                Name : <input type="text" name="name" required><br>
                Class: <input type="text" name="class" required><br>
                Gender: <select name="gender">
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select><br>
                Date of Birth: <input type="date" name="dob" required><br>
                <input type="submit" name="add_record" value="Add Record">
            </form>
        </div>
    </div>

 <div class="container">
        <div class="cont1">Edit Student</div>
            <div class="cont2">
              <form action="dashboard.php" method="POST">
            <input type="text" name="id" id="id" placeholder="Enter Student ID">
            <input type="text" name="name" id="name" placeholder="Name" required><br>
            <input type="text" name="class" id="class" placeholder="Class" required><br>
            <select name="gender" id="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                
            </select><br>
            <input type="date" name="dob" id="dob" required><br>
            <input type="submit" name="edit_record" value="Update Record">
        </form>  
            </div>
        
    </div>

    <div class="container">
        <div class="cont1">Delete Student</div>
            <div class="cont2">
              <form action="dashboard.php" method="POST">
            <label for="id">Student ID:</label>
            <input type="text" id="id" name="id" placeholder="Enter Student ID" required><br>
            <input type="submit" name="delete_record" value="Delete Record">
        </form>  
            </div>
        
    </div>
   
    <div class="container">
        <div class="cont1">Records</div>
        <div class="cont2">
            
            <?php
            session_start();
            include("dbconnection.php");


            // Fetch student records from the 'students' table
            $sql = "SELECT * FROM students";
            $result = $conn->query($sql);

            // Check if records exist
            if ($result->num_rows > 0) {
                // Output table headers
                echo "<table>";
                echo "<tr><th>ID</th><th>Name</th><th>Class</th><th>Gender</th><th>Date of Birth</th></tr>";
                
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["class"] . "</td>";
                    echo "<td>" . $row["gender"] . "</td>";
                    echo "<td>" . $row["dob"] . "</td>";
                    echo "</tr>";
                }
                
                echo "</table>";
            } else {
                display_feedback("No student records found");
            }
            ?>
            </div>

        </div>



    
    <div class="container">
            <form method="post" action="">
        <input type="submit" name="log_out" value="Log Out" class="logout-btn">
        </form>
    </div>
    

 <div id="toastContainer" class="toast"></div>

  <script>
        // Function to populate form fields with student data
        function populateForm(id, name, cls, gender, dob) {
            document.getElementById('id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('class').value = cls;
            document.getElementById('gender').value = gender;
            document.getElementById('dob').value = dob;
        }
    </script>
    <?php
        
        include_once('dbconnection.php');




        if(!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }

        if (isset($_GET['message'])) {
            $message = $_GET['message'];
            echo "<div style='color:green;'>$message</div>";
        }

        //add records
                 
        if (isset($_POST['add_record'])) {
            $name = sanitize_input($_POST['name']);
            $class = sanitize_input($_POST['class']);
            $gender = sanitize_input($_POST['gender']);
            $dob = sanitize_input($_POST['dob']);


            // Inserting student data into 'students' table
            $sql = "INSERT INTO students (name, class, gender, dob) VALUES ('$name', '$class', '$gender', '$dob')";

            if ($conn->query($sql) === TRUE) {
                display_feedback("Registration successful.");
                   // Check if the page has not been reloaded already
                if (!isset($_SESSION['page_reloaded'])) {
                    // Echo JavaScript code to reload the page
                    echo '<script>window.location.reload();</script>';

                    // Set a session variable to indicate that the page has been reloaded
                    $_SESSION['page_reloaded'] = true;
                }
                exit(); // Ensure no further code execution
            } else {
                display_feedback("Error: " . $sql . "<br>" . $conn->error, false);
            }
        }


        //edit and update record
        if (isset($_POST['edit_record'])) {
            // Sanitize input data
            $id = sanitize_input($_POST['id']);
            $name = sanitize_input($_POST['name']);
            $class = sanitize_input($_POST['class']);
            $gender = sanitize_input($_POST['gender']);
            $dob = sanitize_input($_POST['dob']);

           // Update the student record in the 'students' table
            $sql = "UPDATE students SET name='$name', class='$class', gender='$gender', dob='$dob' WHERE id='$id'";

            if ($conn->query($sql) === TRUE) {
                display_feedback("Student record updated successfully");
                    // Check if the page has not been reloaded already
                if (!isset($_SESSION['page_reloaded'])) {
                    // Echo JavaScript code to reload the page
                    echo '<script>window.location.reload();</script>';

                    // Set a session variable to indicate that the page has been reloaded
                    $_SESSION['page_reloaded'] = true;
                }
                exit();
            } else {
                display_feedback("Error updating record: " . $conn->error);
            }
        }


        //Delete record
                
            if (isset($_POST['delete_record'])) {
            $id = sanitize_input($_POST['id']);

            // Check if the student record exists
            $sql_check = "SELECT * FROM students WHERE id='$id'";
            $result_check = $conn->query($sql_check);

            if ($result_check->num_rows > 0) {
                // If the student record exists, delete it
                $delete_sql = "DELETE FROM students WHERE id='$id'";
                if ($conn->query($delete_sql) === TRUE) {
                    display_feedback("Student record with ID $id deleted successfully");
                      // Check if the page has not been reloaded already
            if (!isset($_SESSION['page_reloaded'])) {
                // Echo JavaScript code to reload the page
                echo '<script>window.location.reload();</script>';

                // Set a session variable to indicate that the page has been reloaded
                $_SESSION['page_reloaded'] = true;
            }
            exit();
                } else {
                    display_feedback("Error deleting record: " . $conn->error);
                }
            } else {
                // If the student record does not exist, display an error message
                display_feedback("No student record found for ID $id") ;
            }
        }



        if (isset($_POST["log_out"])) {
        header("Location: login.php");
        exit();
        }


        $conn->close();
    ?>


</body>
</html>