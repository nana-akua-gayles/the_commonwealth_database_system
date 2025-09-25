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

// Approve registration
if (isset($_POST['approve'])) {
    $id = $_POST['id'];
    
    // Fetch registration details
    $stmt = $conn->prepare("SELECT fullname, email, phone, role FROM pending_leadersaccess WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($fullname, $email, $phone, $role);
    $stmt->fetch();
    $stmt->close();

    // Generate username and password
    $username = uniqid('user_');
    $password = bin2hex(random_bytes(4)); // Temporary password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into leadersaccess table
    $insertStmt = $conn->prepare("INSERT INTO leadersaccess (fullname, email, phone, role, username, password) VALUES (?, ?, ?, ?, ?, ?)");
    if ($insertStmt) {
        $insertStmt->bind_param("ssssss", $fullname, $email, $phone, $role, $username, $hashedPassword);
        if ($insertStmt->execute()) {

            // Insert or update profile information
            $profileStmt = $conn->prepare("INSERT INTO userProfiles (fullname, email, phone, role, username) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE fullname = ?, phone = ?, role = ?");
            $profileStmt->bind_param("ssssss", $fullname, $email, $phone, $role, $username);
            $profileStmt->execute();
            $profileStmt->close();


            // Send Email for approval
            $subject = "Your Registration Has Been Approved";
            $message = "Hello $fullname,\n\nYour registration has been approved!\nYour username: $username\nYour password: $password\n\nPlease change your password after logging in.";
            mail($email, $subject, $message); // Consider using a library for better reliability

            // Remove from pending registrations
            $deleteStmt = $conn->prepare("DELETE FROM pending_leadersaccess WHERE id = ?");
            $deleteStmt->bind_param("i", $id);
            $deleteStmt->execute();
            $deleteStmt->close();

            echo "Registration approved and credentials sent!";
        } else {
            error_log("Execution error: " . $insertStmt->error);
        }
        $insertStmt->close();
    }
}

// Reject registration
if (isset($_POST['reject'])) {
    $id = $_POST['id'];

    // Fetch registration details
    $stmt = $conn->prepare("SELECT fullname, email, phone, role FROM pending_leadersaccess WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($fullname, $email, $phone, $role);
    $stmt->fetch();
    $stmt->close();

    // Store in rejected_registrations table
    $insertRejectedStmt = $conn->prepare("INSERT INTO deniedaccess (fullname, email, phone, role) VALUES (?, ?, ?, ?)");
    if ($insertRejectedStmt) {
        $insertRejectedStmt->bind_param("ssss", $fullname, $email, $phone, $role);
        $insertRejectedStmt->execute();
        $insertRejectedStmt->close();
    }

    // Send Email for rejection
    $subject = "Your Registration Has Been Rejected";
    $message = "Hello $fullname,\n\nWe regret to inform you that your registration has been rejected. Please contact support for more information.";
    mail($email, $subject, $message); // Consider using a library for better reliability

    // Remove from pending registrations
    $deleteStmt = $conn->prepare("DELETE FROM pending_leadersaccess WHERE id = ?");
    $deleteStmt->bind_param("i", $id);
    $deleteStmt->execute();
    $deleteStmt->close();

    echo "Registration rejected and removed from pending requests.";
}

$conn->close();
?>