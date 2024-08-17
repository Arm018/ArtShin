<?php
// Database connection settings
$host = 'localhost';
$dbname = 'contact_form';
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['msg']);

    // Validate form data (basic validation)
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect back to the form page with a success status
            header("Location: index.html?status=success");
            exit();
        } else {
            // Redirect back to the form page with an error status
            header("Location: index.html?status=error");
            exit();
        }

        // Close statement
        $stmt->close();
    } else {
        // Redirect back to the form page with a validation error status
        header("Location: index.html?status=validation_error");
        exit();
    }
}

// Close connection
$conn->close();
?>
