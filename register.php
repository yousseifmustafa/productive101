<?php
include 'connect.php';

// Set the content type to application/json
header("Content-Type: application/json");

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

// Check if the required fields are present
if (isset($data['fName'], $data['lName'], $data['email'], $data['password'])) {
    $firstName = $data['fName'];
    $lastName = $data['lName'];
    $email = $data['email'];
    $password = md5($data['password']); // Use stronger hashing in production

    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email Address Already Exists!"]);
    } else {
        $insertQuery = "INSERT INTO users (firstName, lastName, email, password) VALUES ('$firstName', '$lastName', '$email', '$password')";
        
        if ($conn->query($insertQuery) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Registration successful!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
}
?>
