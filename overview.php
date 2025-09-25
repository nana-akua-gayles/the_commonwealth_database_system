<?php

session_start(); // Start the session

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

// Fetch pending registrations
$pending = $conn->query("SELECT * FROM pending_leadersaccess");
if (!$pending) {
    die("Query failed: " . $conn->error);
}

// Fetch approved registrations
$approved = $conn->query("SELECT * FROM leadersaccess");
if (!$approved) {
    die("Query failed: " . $conn->error);
}

// Fetch rejected registrations
$rejected = $conn->query("SELECT * FROM deniedaccess");
if (!$rejected) {
    die("Query failed: " . $conn->error);
}


// Check if user ID is available in the session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Get the user ID from session
} else {
    die("User not logged in.");
}

// Prepare and execute the SQL statement to fetch profile data
$profileStmt = $conn->prepare("SELECT fullname, email, phone, role, username FROM userProfiles WHERE id = ?");
$profileStmt->bind_param("i", $userId);
$profileStmt->execute();
$profileStmt->bind_result($profileFullname, $profileEmail, $profilePhone, $profileRole, $profileUsername);
$profileStmt->fetch();
$profileStmt->close();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OVERVIEW</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="adminHeader">
            <h2 class="ah1">Administrative View</h2>
            <input type="checkbox" id="menu-toggle" class="menu-toggle">
<label for="menu-toggle" class="hamburger">
    <span class="bar"></span>
    <span class="bar"></span>
    <span class="bar"></span>
</label>

<nav class="menu">
    <ul>
        <li style="text-decoration: underline;"><a href="overview.html">OVERVIEW</a></li>       
        <li><a href="members.html">MEMBERS</a></li>
        <li><a href="settings.html">SETTINGS</a></li>
        <li><a href="reports.html">REPORTS</a></li>
        <li><a href="help.html">HELP & SUPPORT </a></li>
    </ul>
</nav>

<nav class="nav-links">
    <ul>            
        <li style="text-decoration: underline;"><a href="overview.html">OVERVIEW</a></li>       
        <li><a href="members.html">MEMBERS</a></li>
        <li><a href="settings.html">SETTINGS</a></li>
        <li><a href="reports.html">REPORTS</a></li>
        <li><a href="help.html">HELP & SUPPORT</a></li>
    </ul>
</nav>
      

            <div class="profile-card">
                <div class="profile-photo" id="profilePhoto"></div>
            </div>
    </header>

    
    <div class="popup" id="popup">
        <div class="tProfile" style="display:relative; background: #35424a; height: 30px;
            border-radius: 8px 8px 0 0; padding: 30px; font-size: 1.2em;">
            <strong>Account Menu</strong></div>

        <div id="popupPhoto" class="profile-photo" style="margin:auto; margin-top:-9%; 
        width: 60px; height:60px; border:none;"></div>

        <div class="pDetails" style="margin-bottom:40%; padding:15px;">
                <p><strong>Name:</strong> <?= htmlspecialchars($profileFullname) ?></p>
                <p><strong>Name:</strong> <?= htmlspecialchars($profileFullname) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($profileEmail) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($profilePhone) ?></p>
                <p><strong>Role:</strong> <?= htmlspecialchars($profileRole) ?></p>
                    <a href="logout.php">Logout</a>
        </div>
        <hr> 

        <div style="margin-top:10%; text-align:left; margin-left:20px"><strong>Logout</strong></div>
    </div>

                <a href="membershipForm.html" class="addNewMember">ADD A NEW MEMBER</a>



<div class="container">
    <div class="adminnav" id="myTab" role="tablist">
        <div class="adminnav-item">
            <a class="adminnav-link active" href="#pending" onclick="showTab('pending')">Pending Requests</a>
        </div>
        <div class="adminnav-item">
            <a class="adminnav-link" href="#approved" onclick="showTab('approved')">Approved Requests</a>
        </div>
        <div class="adminnav-item">
            <a class="adminnav-link" href="#rejected" onclick="showTab('rejected')">Rejected Requests</a>
        </div>
    </div>

    <div id="pending" class="admincard">
        <div class="admincard-header bg-warning">📌 Pending Requests</div>
        <div class="admincard-body">
            <table class="request-table">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Access</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php if ($pending->num_rows > 0): ?>
                    <?php while ($row = $pending->fetch_assoc()): ?>
                    <tr>
                        <td class="request-name"><?= htmlspecialchars($row['fullname']) ?></td>
                        <td class="request-email"><?= htmlspecialchars($row['email']) ?></td>
                        <td class="request-phone"><?= htmlspecialchars($row['phone']) ?></td>
                        <td class="request-access"><?= htmlspecialchars($row['role']) ?></td>
                        <td class="request-status"><span class="badge bg-secondary">pending</span></td>
                        <td>
                            <form method="POST" action="approve_request.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="approve" class="btn adminbtn-success">Approve</button>
                                <button type="submit" name="reject" class="btn adminbtn-danger">Reject</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No pending requests found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <div id="approved" class="admincard" style="display:none;">
        <div class="admincard-header bg-success">✅ Approved Admins</div>
        <div class="admincard-body">
            <table class="request-table">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Access</th>
                    <th>Status</th>
                </tr>
                <?php if ($approved->num_rows > 0): ?>
                    <?php while ($row = $approved->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['fullname']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['role']) ?></td>
                        <td><span class="badge bg-success">approved</span></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No approved requests found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <div id="rejected" class="admincard" style="display:none;">
        <div class="admincard-header bg-danger">❌ Rejected Requests</div>
        <div class="admincard-body">
            <table class="request-table">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Access</th>
                    <th>Status</th>
                </tr>
                <?php if ($rejected->num_rows > 0): ?>
                    <?php while ($row = $rejected->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['fullname']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['role']) ?></td>
                        <td><span class="badge bg-danger">rejected</span></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No rejected requests found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>



                
    <footer>
        <p>&copy; 2024 Christ Commonwealth Community Membership Registration System</p>
    </footer>




    <script>

//Profile Photo
    const user = {
        fullName:"General Admin",
        email:"generaladmin@gmail.com",
        username:"GENERALADMIN"
    };

    const profilePhoto =document.getElementById("profilePhoto");
    const initials =user.fullName.split(" ").map(name => name.charAt(0)).join("");
    profilePhoto.textContent =initials.toUpperCase();

//Popup Functionality for the Profile Picture
    const popup =document.getElementById('popup');
    const popupPhoto =document.getElementById('popupPhoto');

    profilePhoto.onclick = function() {
        popup.style.display = 'block';
        popupPhoto.textContent =initials.toUpperCase();
    };

    const fileInput =document.createElement('input');
    fileInput.type ='file';
    fileInput.accept = 'image/*';
    fileInput.style.display = 'none';

    popupPhoto.onclick =function() {
        fileInput.click();
    };

    fileInput.onchange =function(event) {
        const file =event.target.files[0];
        if (file) {
            const reader = new FileReader ();
            reader.onload =function(e) {
popupPhoto.style.backgroundImage = `url(${e.target.result})`;

popupPhoto.style.backgroundSize = `cover`;
                popupPhoto.style.color = 'transparent';
            };
            reader.readAsDataURL(file);
        }
    };

    document.addEventListener('click', function(event) {
        if (popup.style.display === 'block' && !popup.contains(event.target) && !
profilePhoto.contains(event.target)) {
        popup.style.display = 'none';
        }
    });


    createMobileMenu();
    createDesktopMenu();

//Script for the active tabs in the approval status.

    function showTab(tabId) {
    document.getElementById('pending').style.display = 'none';
    document.getElementById('approved').style.display = 'none';
    document.getElementById('rejected').style.display = 'none';
    
    document.getElementById(tabId).style.display = 'block';
    
    const links = document.querySelectorAll('.adminnav-link');
    links.forEach(link => {
        link.classList.remove('active');
        link.style.backgroundColor = 'transparent';
        link.style.color = '#007bff'; 
    });

    // Highlight active tab
    let activeColor;
    if (tabId === 'approved') {
        activeColor = '#28a745'; 
    } else if (tabId === 'rejected') {
        activeColor = '#dc3545'; 
    } else {
        activeColor = '#0056b3'; 
    }
    const activeLink = document.querySelector(`.adminnav-link[href="#${tabId}"]`);
    activeLink.classList.add('active');
    activeLink.style.backgroundColor = activeColor; 
    activeLink.style.color = 'white'; 
}


    </script>
</body>
</html>
    <?php
$conn->close();
?>