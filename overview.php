<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OVERVIEW</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
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

    <a class="oLink" href="#" style="background-color: #e60b78; color: white; font-weight: bold; padding:10px;">Overview</a>
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

    <div class="bDiv">
        <div class="net" style="background-color: whitesmoke; padding: 25px;">
            <p><b> THE COMMONWEALTH NETWORKS</b></p>
            <div class="networkB" style="display: grid;">
                <b>Accra Network</b>
                <a href="#">Leaders</a>
                <a>Fellowships</a>
                <a>T-360s</a>
                <a>Stewards</a>
                <a href="aNetwork.php">Members</a>
            </div><br>

            <div class="networkB" style="display: grid;">
                <b>Kumasi Network</b>
                <a href="#">Leaders</a>
                <a>Fellowships</a>
                <a>T-360s</a>
                <a>Stewards</a>
                <a href="">Members</a>
            </div><br>

            <div class="networkB" style="display: grid;">
                <b>Ho Network</b>
                <a href="#">Leaders</a>
                <a>Fellowships</a>
                <a>T-360s</a>
                <a>Stewards</a>
                <a href="">Members</a>
            </div>    
            </div>       

        <div class="mainB"></div>


        <div class="notB"></div>

    
    
    
    
    
</div>






<footer>
    <p>&copy; 2024 Christ Commonwealth Community Membership Registration System</p>
</footer>

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






