<?php
session_start(); 

$host = "localhost";
$user = "root"; 
$password = ""; 
$db = "acessregistry_db";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement to fetch user details
    $stmt = $conn->prepare("SELECT id, password FROM leadersaccess WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verify the password using password_verify
    if (isset($hashedPassword) && password_verify($password, $hashedPassword)) {
        // Successful login
        $_SESSION['user_id'] = $userId;
        header("Location: overview.php"); // Redirect to overview.php
        exit();
    } else {
        // Invalid login
        $_SESSION['message'] = "Invalid username or password.";
        header("Location: signup.php"); // Redirect back to login page
        exit();
    }
}

$conn->close();
?>