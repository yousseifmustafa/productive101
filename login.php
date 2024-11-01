<?php
include 'connect.php';

// Set the content type to application/json
header("Content-Type: application/json");

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

// Check if the required fields are present
if (isset($data['email'], $data['password'])) {
    $email = $data['email'];
    $password = md5($data['password']); // Use stronger hashing in production

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Login successful
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        
        echo json_encode(["status" => "success", "message" => "User logged in successfully", "token" => bin2hex(random_bytes(16))]); // Generate a unique token
    } else {
        // Invalid credentials
        echo json_encode(["status" => "error", "message" => "Incorrect Email or Password"]);
    }
} else {
    // Required fields are missing
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
}
?>
