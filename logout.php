<?php
session_start(); // Start the session

// Destroy the session
session_destroy();

// Set the content type to application/json
header("Content-Type: application/json");

// Return a JSON response
echo json_encode(["status" => "success", "message" => "Logged out successfully."]);
?>
