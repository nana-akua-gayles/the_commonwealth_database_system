<?php
session_start(); // Start the session

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'the_commonwealth_members';

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch members from the Accra network & group by fellowship
$sql = "SELECT * FROM registry WHERE network = 'Accra' ORDER BY fellowship";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CC - ACCRA NETWORK </title>
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
</head>


<body>
        <header class="adminHeader">
        <img src="coloredLogo.PNG" class="aLogo" style="    width: 120px;
    height: auto;">

    <div class="dropdown">
    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown">Leadership</button>
     <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Lead Presbyter</a></li>
        <li><a class="dropdown-item" href="#">Pastors</a></li>
        <li><a class="dropdown-item" href="#">Deacons & Deaconesses</a></li>
    </ul>
    </div>

    <a class="oLink" href="#">First Timers</a>
    <a class="oLink" href="allMembers.php">Members</a>
    <a class="oLink" href="#">Administrative Access</a>
    
    <div class="search-wrapper" style="position: relative;">
    <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
    <i class="fas fa-search"></i>
    </div>

    <a class="oLink" href="#">Overview</a>
    <a class="oLink" href="#">Settings</a>
    <a class="oLink" href="#">Help & Support</a>
    <a class="oLink" href="#">Notifications</a>    

    <div class="profile">
        <i class="fas fa-user-circle profile-icon" id="profileIcon" style="font-size: 35px;
         cursor: pointer; color: rgba(105, 99, 121, 1);"></i>
        
        <div class="profile-card" id="profileCard">
            <div class="usD">
        <i class="fas fa-user-circle profile-icon" id="profileIcon" style="font-size: 50px;
         color: rgba(105, 99, 121, 1); padding: 10px;"></i>            
         <h6>ABIGAIL AKUA NINSIN</h6>
            <h6 class="text-muted">General Administrator</h6>
            <p>abigailakuaninsin@gmail.com</p>
            <p>@queenie_gayles</hp>
            <p>0596355972</p>
            </div><br>
            <div class="d-grid">
            <button type="button" class="btn btn-primary btn-block" id="logoutBtn" 
            style="background-color: #bf72ce; border: none;">Logout</button>
            </div>

        </div>
    </div>
</header>

        <p class="accH" style="padding: 15px; text-align: center; color: white; font-weight: bold; font-size: 1.4em;
         background-color: #da3788; margin-bottom: 0;">REGISTERED COMMONWEALTH MEMBERS (ACCRA)</p>

    <div class="bDiv">

        <div class="net" style="background-color: #d6d1d2c0; padding: 25px; max-height: 600px; overflow-y: auto;">
            <p style="font-weight: bold; padding: 5px; font-size: 1.25em;">THE COMMONWEALTH NETWORKS</p>
            <div class="networkB" style="display: grid;">
                <b>Accra Network</b>
                <a class="netLinks" href="#">Leaders</a>
                <a class="netLinks">Fellowships</a>
                <a class="netLinks">T-360s</a>
                <a class="netLinks">Stewards</a>
                <a class="netLinks" href="aNetwork.php" style="color: #da3788; font-weight: bold; text-decoration: underline; font-size: 1.15em;">Members</a>
            </div><br>

            <div class="networkB" style="display: grid;">
                <b>Kumasi Network</b>
                <a class="netLinks" href="#">Leaders</a>
                <a class="netLinks">Fellowships</a>
                <a class="netLinks">T-360s</a>
                <a class="netLinks">Stewards</a>
                <a class="netLinks" href="">Members</a>
            </div><br>

            <div class="networkB" style="display: grid;">
                <b>Ho Network</b>
                <a class="netLinks" href="#">Leaders</a>
                <a class="netLinks">Fellowships</a>
                <a class="netLinks">T-360s</a>
                <a class="netLinks">Stewards</a>
                <a class="netLinks" href="">Members</a>
            </div>    
            </div>    
            

        <div class="mainB">
            <div class="memContainer" style="width: 950px;">

                <?php
                if (isset($_SESSION['message'])) {
                    echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message']); 
                }

                // Check if there are any members
                if ($result->num_rows > 0) {
                    // Initialize an array to group members by fellowship
                    $membersByFellowship = [];

                    while ($row = $result->fetch_assoc()) {
                        $fellowship = $row['fellowship'];
                        if (!isset($membersByFellowship[$fellowship])) {
                            $membersByFellowship[$fellowship] = [];
                        }
                        $membersByFellowship[$fellowship][] = $row;
                    }

                    // Display members grouped by fellowship
                    foreach ($membersByFellowship as $fellowship => $members) {
                        echo "<div class='table-responsive-md'>";
                        echo "<p style='font-weight:bold; margin-top: 30px; font-size: 2.2em;'>$fellowship</p>";
                        echo "<table class='table table-bordered table-striped'>";
                        echo "<thead class='thead-light'><tr><th>Title</th><th>Full Name</th><th>Gender</th><th>DoB</th>
                        <th>Contact</th><th>Email</th><th>Address</th><th>Marital Status</th><th>Nationality</th>
                        <th>Level of Education</th><th>Profession</th><th>Next of Kin</th><th>Contact of Next of kin</th>
                        <th>Network</th><th>Fellowship</th><th>T360</th><th>Role</th><th>Stewardship Groups</th></tr></thead><tbody>";
                        
                        foreach ($members as $member) {
                            echo "<tr>";
                            echo "<td>{$member['title']}</td>";
                            echo "<td>{$member['fullName']}</td>";
                            echo "<td>{$member['gender']}</td>";
                            echo "<td>{$member['dob']}</td>";
                            echo "<td>{$member['number']}</td>";
                            echo "<td>{$member['email']}</td>";
                            echo "<td>{$member['address']}</td>";
                            echo "<td>{$member['maritalStatus']}</td>";
                            echo "<td>{$member['nationality']}</td>";
                            echo "<td>{$member['education']}</td>";
                            echo "<td>{$member['profession']}</td>";
                            echo "<td>{$member['emergencyContactName']}</td>";
                            echo "<td>{$member['emergencyContact']}</td>";
                            echo "<td>{$member['network']}</td>";
                            echo "<td>{$member['fellowship']}</td>";
                            echo "<td>{$member['t360s']}</td>";
                            echo "<td>{$member['function']}</td>";
                            echo "<td>{$member['stewardshipGroups']}</td>";
                            echo "</tr>";
                        }
                        echo "</tbody></table></div>";
                    }
                } else {
                    echo "<div class='alert alert-warning'>No members registered in the Accra network.</div>";
                }

                $conn->close();
                ?>
            </div>
        </div>

        <div class="notB"></div>

    
    
    
    
    
</div>
<script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('profileIcon').onclick = function() {
    var card = document.getElementById('profileCard');
    card.style.display = card.style.display === 'none' || card.style.display === '' ? 'block' : 'none';
};

// Close the card when clicking outside of it
window.onclick = function(event) {
    if (!event.target.matches('#profileIcon') && !event.target.matches('#editProfileBtn')) {
        var card = document.getElementById('profileCard');
        card.style.display = 'none';
    }
};
    // The code for logging out
    document.getElementById('logoutBtn').onclick = function() {

    // Redirecting to the login Form
    window.location.href = 'logout.php'; 
};
</script>   
</body>
</html>