<?php
session_start(); // Start the session

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}

$host = "localhost";
$user = "root";
$password = "";
$db = "the_commonwealth_members";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Collecting form data
$title = $_POST['title'] ?? '';
$fullName = $_POST['fullName'] ?? '';
$gender = $_POST['gender'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$profession = $_POST['profession'] ?? '';
$invite = $_POST['invite'];
$notes = $_POST['notes'];


// Prepare the SQL statement
$sql = "INSERT INTO firstimerstable (title, fullName, gender, phone, address, profession, invite, notes)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("ssssssss", $title, $fullName, $gender, $phone, $address, $profession, $invite, $notes);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Set the success message in session
        $_SESSION['message'] =  "<strong>THANK YOU BELOVED,</strong> for joining us for service today. We hope to see you next week!";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    $_SESSION['message'] = "Error preparing statement: " . $conn->error;
}

$conn->close(); 

// Redirect back to the form
header("Location: membershipform.php");
exit();
?>