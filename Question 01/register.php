<?php
// Simple connection
$conn = new mysqli("localhost", "root", "", "q1");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data safely
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);

// Server-side validation
if (empty($name) || empty($email) || empty($password)) {
    die("All fields are required!");
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format!");
}

// Save password securely 
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert into database
$sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $hashedPassword);

if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
