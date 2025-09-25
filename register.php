<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "acessregistry_db";

// Create Connection
$conn = new mysqli($host, $user, $password, $db);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form Submission
if (isset($_POST['signup'])) {
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $role = htmlspecialchars(trim($_POST['role']));

    // Check for existing email
    $checkEmail = $conn->prepare("SELECT id FROM leadersaccess WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        echo "<script>alert('This Email is already registered. Please Login instead.');
        window.history.back();</script>";
    } else {
        // Insert into the pending registrations table
        $stmt = $conn->prepare("INSERT INTO pending_leadersaccess (fullname, email, phone, role) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $fullname, $email, $phone, $role);
            if ($stmt->execute()) {
                echo "<script>alert('Registration Successful! Your request is pending admin approval.');
                window.location.href='login.php';</script>";
            } else {
                error_log("Execution error: " . $stmt->error);
            }
            $stmt->close();
        } else {
            error_log("Statement preparation error: " . $conn->error);
        }
    }

    $checkEmail->close();
    $conn->close();
}
?>