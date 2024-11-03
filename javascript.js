 $(document).ready(function(){
            function refreshTable() {
                $.ajax({
                    url: 'dashboard.php',
                    type: 'GET',
                    success: function(response) {
                        $('#records').html(response);
                    }
                });
            }
            
            // Call refreshTable on page load
            refreshTable();
            
            // Set up event listener for the delete button
            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                
                // Send AJAX request to delete_student_process.php
                $.ajax({
                    url: 'dashboard.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        // Display the feedback message
                        alert(response);
                        
                        // Refresh the table
                        refreshTable();
                    }
                });
            });
        });

  document.getElementById("usernameField").addEventListener("input", function() {
            var username = this.value.trim();
            var hiddenFields = document.getElementById("hiddenFields");

            if (username !== "") {
                hiddenFields.classList.remove("hidden");
            } else {
                hiddenFields.classList.add("hidden");
            }
        });