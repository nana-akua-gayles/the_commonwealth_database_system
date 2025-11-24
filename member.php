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

// Handle file upload
$picture = "";
if (!empty($_FILES["picture"]["name"])) {
    $targetDir = "uploads/";
    
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $picture = $targetDir . basename($_FILES["picture"]["name"]);
    if (!move_uploaded_file($_FILES["picture"]["tmp_name"], $picture)) {
        die("Error uploading file.");
    }
}

// Collecting form data
$title = $_POST['title'] ?? '';
$fullName = $_POST['fullName'] ?? '';
$gender = $_POST['gender'] ?? '';
$dob = $_POST['dob'] ?? '';
$number = $_POST['number'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$maritalStatus = $_POST['maritalStatus'] ?? '';
$nationality = $_POST['nationality'] ?? '';
$education = $_POST['education'] ?? '';
$profession = $_POST['profession'] ?? '';
$emergencyContactName = $_POST['emergencyContactName'] ?? '';
$emergencyContact = $_POST['emergencyContact'] ?? '';
$network = $_POST['network'];
$fellowship = $_POST['fellowship'];
$t360s = $_POST['t360s'] ?? '';

// Handle stewardship groups & functions
$function = isset($_POST['function']) ? implode(", ", array: $_POST['function']) : "";   

$stewardshipGroups = isset($_POST['stewardshipGroups']) ? implode(", ", array: $_POST['stewardshipGroups']) : "";   

// Prepare the SQL statement
$sql = "INSERT INTO registry (title, fullName, picture, gender, dob, number, email, address, 
maritalStatus, nationality, education, profession, emergencyContactName, emergencyContact, network, 
fellowship, t360s, function, stewardshipGroups)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("sssssssssssssssssss", $title, $fullName, $picture, $gender, $dob, $number, $email, $address, $maritalStatus, $nationality, 
    $education, $profession, $emergencyContactName, $emergencyContact, $network, $fellowship, $t360s, $function, $stewardshipGroups);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Set the success message in session
        $_SESSION['message'] =  "<strong>CONGRATULATIONS!</strong> You have successfully been registered into The Commonwealth Fold!";
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