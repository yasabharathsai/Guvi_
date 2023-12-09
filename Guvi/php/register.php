<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "user";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password']; // Note: This is not secure, consider using password hashing

    // Check if email already exists in the database
    $check_stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $response = array("status" => "exists"); // Email already exists
    } else {
        // Prepare and bind the statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            $response = array("status" => "success"); // Registration successful
        } else {
            $response = array("status" => "failure"); // Registration failed
        }

        // Close statement
        $stmt->close();
    }

    // Close connections
    $check_stmt->close();
    $conn->close();

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
