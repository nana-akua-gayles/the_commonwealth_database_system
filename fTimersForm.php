<?php
session_start(); 

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMMONWEALTH FIRST TIMERS FORM</title>
    
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>


        <button class="notice">THIS IS A REGISTRATION FORM FOR ONLY FIRST TIMERS !
        <a class="fTimers" href="membershipform.php">Click here for the Commonwealth Members Form </a>
        </button>

    <div class="membershipGrouping">

        <div class="fHeadings text-center">
            <img src="coloredLogo.PNG" class="cLogo" alt="Logo">
            <br><br><h2><b>THE COMMONWEALTH</b></h2>
            <h3><span style="font-size: 1em;"><b>First Timers Registration Form</b></span></h3>
        </div>


    <form id="memberform" action="newmembers.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" id="memberId">


            <div class="fDetail mb-3">
                <label for="title" id="lbl">Title:</label>
                <select class="form-select" name="title" id="title">
                    <option value="">-- Choose a Title --</option>
                    <option value="Mr">Mr.</option>
                    <option value="Mrs">Mrs.</option>
                    <option value="Miss">Miss</option>
                </select>  
            </div>

            <div class="fDetail mb-3">
                <label for="fullname" id="lbl">Your Full Name: <span style="color: red;">*</span></label> 
                <div class="input-group">
                    <span class="input-group-text">Person</span>
                    <input type="text" name="fullName" class="form-control" placeholder="Type in your full Name" required>
                </div>
            </div>

            <div class="fDetail mb-3">
                <label for="gender" id="lbl">Gender: <span style="color: red;">*</span></label>
                <select class="form-select" name="gender" id="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>  
            </div>  

            <div class="fDetail mb-3">
                <label for="phone" id="lbl">Phone Number: <span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Type in your telephone number" required>
            </div>

            <div class="fDetail mb-3">
                <label for="address" id="lbl">Residential Address: <span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="address" id="address" placeholder="Type in your residential address" required>
            </div>    

            <div class="fDetail mb-3">
                <label for="profession" id="lbl">Profession:</label>
                <input type="text" class="form-control" name="profession" id="profession" placeholder="What is your profession?">
            </div>

            <div class="fDetail mb-3">
                <label for="invite" id="lbl">Invited By?</label>
                <input type="text" class="form-control" name="invite" id="invite" placeholder="Who invited you?">
            </div>

          <div class="fDetail mb-3">  
          <label for="comment" id="lbl"> Share with us what you are taking home from today's service...</label>
          <textarea class="form-control" rows="5" id="comment" name="notes"></textarea>            
          </div>

      <button type="submit" class="mfButton" name="submit">Submit</button>
  </form>
    </div>





    <footer>
        <p>&copy; 2024 Christ Commonwealth Community Membership Registration System</p>
    </footer>

    <script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>