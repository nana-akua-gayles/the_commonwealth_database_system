<?php
$host = "localhost";
$user = "root"; 
$password = ""; 
$db = "acessregistry_db";

$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users with plain text passwords
$result = $conn->query("SELECT id, password FROM leadersaccess");

while ($row = $result->fetch_assoc()) {
    $userId = $row['id'];
    $plainPassword = $row['password'];

    // Hash the password
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // Update the database with the hashed password
    $updateStmt = $conn->prepare("UPDATE leadersaccess SET password = ? WHERE id = ?");
    $updateStmt->bind_param("si", $hashedPassword, $userId);
    $updateStmt->execute();
    $updateStmt->close();
}

$conn->close();
echo "Password hashing completed for all users.";
?>