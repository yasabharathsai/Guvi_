<?php
// Database connection details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

// Get input from the login form
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and execute SQL statement
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verify password (assuming password stored as plaintext for this example, use secure hashing in real scenarios)
    if ($password === $row['password']) {
        $response = (array("status" => "success", "message" => "Login successful")); // Password matches
    } else {
        $response = (array("status" => "failure", "message" => "Incorrect password")); // Password does not match
    }
} else {
    echo json_encode(array("status" => "failure", "message" => "Email not found")); // Email not found in the database
}

$stmt->close();
$conn->close();
header('Content-Type: application/json');
    echo json_encode($response);
}
?>
