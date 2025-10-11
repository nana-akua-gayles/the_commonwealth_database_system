<?php
session_start(); // Start the session

// Database configuration
$servername = "localhost"; // Change if necessary
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "acessregistry_db"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if (isset($_POST['signup'])) {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $conn->real_escape_string($_POST['role']);

    // SQL query to insert data into pending_users table
    $sql = "INSERT INTO pending_leadersaccess (fullname, username, email, phone, password, role) VALUES ('$fullname', '$username', '$email', '$phone', '$password', '$role')";

    // Execute the query and check if successful
    if ($conn->query($sql) === TRUE) {
        // Redirect to signup.php
        header("Location: signup.php");
        exit(); // Ensure no further code is executed
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>