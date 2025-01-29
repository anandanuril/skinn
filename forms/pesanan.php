<?php
// Database configuration
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "skincare";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input values
    $name = $_POST['name'];
    $email = $_POST['email'];
    $product = $_POST['product'];
    $message = $_POST['message'];

    // Prepare SQL query to insert form data into the database
    $stmt = $conn->prepare("INSERT INTO form_submissions (name, email, product, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $product, $message);

    // Execute the query
    if ($stmt->execute()) {
        // Show success message and refresh the page
        echo "<div class='sent-message'>Your message has been sent. Thank you!</div>";
        echo "<script>
                setTimeout(function() {
                    document.querySelector('form').reset(); // Reset the form fields
                    window.location.reload(); // Reload the page
                }, 2000); // 2-second delay before reload
              </script>";
    } else {
        echo "<div class='error-message'>Error: " . $stmt->error . "</div>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
