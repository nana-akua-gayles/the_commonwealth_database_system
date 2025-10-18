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
    <title>COMMONWEALTH MEMBERS REGISTRATION FORM</title>
    
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>


        <button class="notice">THIS IS A REGISTRATION FORM FOR ONLY ACTIVE COMMONWEALTH MEMBERS !
        <a class="fTimers" href="fTimersForm.php">Click here for the First Timers Form </a>
        </button>

    <div class="membershipGrouping">

        <div class="fHeadings text-center">
            <img src="coloredLogo.PNG" class="cLogo" alt="Logo">
            <br><br><h2><b>THE COMMONWEALTH</b></h2>
            <h3><span style="font-size: 1em;"><b>Membership Registration Form</b></span></h3>
        </div>



        
        <?php if (!empty($message)): ?>

              <div class="alert alert-primary alert-dismissible fade show">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <?= $message ?></div>
        <?php endif; ?>

        <form id="memberform" action="member.php" method="POST" enctype="multipart/form-data">
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
                <label for="picture-upload" id="lbl">Passport Size Picture:</label>
                <input type="file" class="form-control" id="picture-upload" name="picture" accept="image/*">
            </div>

            <div class="fDetail mb-3">
                <label for="gender" id="lbl">Gender: <span style="color: red;">*</span></label>
                <select class="form-select" name="gender" id="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>  
            </div>    

            <div class="fDetail mb-3">
                <label for="dob" id="lbl">Date of Birth: <span style="color: red;">*</span></label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>

            <div class="fDetail mb-3">
                <label for="number" id="lbl">Phone Number: <span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="number" id="number" placeholder="Type in your telephone number" required>
            </div>
            
            <div class="fDetail mb-3">
                <label for="email" id="lbl">Email Address: <span style="color: red;">*</span></label>
                <div class="input-group">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Type in your email address" required>
                    <span class="input-group-text">@example.com</span>
                </div>
            </div>

            <div class="fDetail mb-3">
                <label for="address" id="lbl">Residential Address: <span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="address" id="address" placeholder="Type in your residential address" required>
            </div>    

            <div class="fDetail mb-3">
                <label for="maritalStatus" id="lbl">Marital Status:</label>
                <select class="form-select" name="maritalStatus" id="maritalStatus">
                    <option value="">Are you single or married?</option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                </select>
            </div>

            <div class="fDetail mb-3">
                <label for="nationality" id="lbl">Nationality: <span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="nationality" id="nationality" placeholder="Tell us your nationality" required>
            </div>    

            <div class="fDetail mb-3">
                <label for="education" id="lbl">Educational Level:</label>
                <select class="form-select" name="education" id="education">
                    <option value="">-- Choose your level of education --</option>
                    <option value="basic_education">Basic Education</option>
                    <option value="secondary_education">Secondary Education</option>
                    <option value="tertiary_education">Tertiary Education</option>
                </select>
            </div>

            <div class="fDetail mb-3">
                <label for="profession" id="lbl">Profession:</label>
                <input type="text" class="form-control" name="profession" id="profession" placeholder="What is your profession?">
            </div>

            <div class="fDetail mb-3">
                <label for="emergencyContactName" id="lbl">Name of Emergency Contact: <span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="emergencyContactName" id="emergencyContactName" placeholder="Who is your Emergency Contact?" required>
            </div>

            <div class="fDetail mb-3">
                <label for="emergencyContact" id="lbl">Emergency Contact: <span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="emergencyContact" id="emergencyContact" placeholder="Type in the contact details for your emergency contact" required>
            </div>

                <div class="fDetail mb-3">
                <label for="fellowship" id="lbl">Are you in a fellowship? <span style="color: red;">*</span></label>
                <select class="form-select" name="fellowship" id="fellowship" onchange="toggleFellowshipOptions()">
                    <option value="">Are you in a fellowship?</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>  
            </div>        

            <div id="fellowshipOptions" style="display: none;">
                <div class="fDetail mb-3">
                    <label for="fellowshipName" id="lbl">Your Fellowship:</label>
                    <select class="form-select" name="fellowshipName" id="fellowshipName" onchange="updatet360()">
                        <option value="">Find your fellowship headed by the esteemed leaders</option>
                        <option disabled>Pastor Mitchell</option>
                        <option value="pokuaseCity">Pokuase City</option>
                        <option disabled>Deacon Edward Atiase</option>
                        <option value="metamorphooATU">Metamorphoo ATU</option>
                        <option disabled>Deacon Daniel F. Agbosu</option>
                        <option value="metamorphooExecutives">Metamorphoo Executives</option>
                        <option disabled>Minister Prince S. Tetteh</option>
                        <option value="metamorphooLegon">Metamorphoo Legon</option>
                    </select>
                </div>

                <div class="fDetail mb-3">
                    <label for="t360" id="lbl">Your T360</label>
                    <select class="form-select" name="t360" id="t360">
                        <option value="">Choose your T360</option>
                    </select>
                </div>

            </div>


            <div class="fDetail mb-3">
                <label id="lbl">Stewardship Groups:</label>
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="checkbox" name="stewardshipGroups[]" value="music">
                    </div>
                    <label class="form-control">Music Department</label>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="checkbox" name="stewardshipGroups[]" value="media">
                    </div>
                    <label class="form-control">Media Department</label>
                </div>        

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="checkbox" name="stewardshipGroups[]" value="hospitality">
                    </div>
                    <label class="form-control">Hospitality Department</label>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="checkbox" name="stewardshipGroups[]" value="fragrance">
                    </div>
                    <label class="form-control">Fragrance Department</label>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="checkbox" name="stewardshipGroups[]" value="fi">
                    </div>
                    <label class="form-control">First Impression</label>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="checkbox" name="stewardshipGroups[]" value="editorial_board">
                    </div>
                    <label class="form-control">Editorial Board</label>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="checkbox" name="stewardshipGroups[]" value="vm">
                    </div>
                    <label class="form-control">Venue Management</label>
                </div>                        
            </div>

            <button type="submit" class="mfButton" name="submit">Submit</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Christ Commonwealth Community Membership Registration System</p>
    </footer>

    <script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleFellowshipOptions() {
        const fellowshipSelect = document.getElementById('fellowship');
        const fellowshipOptions = document.getElementById('fellowshipOptions');
        
        if (fellowshipSelect.value === 'yes') {
            fellowshipOptions.style.display = 'block';
        } else {
            fellowshipOptions.style.display = 'none';
            document.getElementById('fellowshipName').value = ''; 
            document.getElementById('t360').innerHTML = '<option value="">Choose your T360</option>'; 
        }
    }

    function updatet360() {  // Fixed function name to match HTML
        const fellowship = document.getElementById('fellowshipName').value;
        const t360Select = document.getElementById('t360');

        // Clear previous options
        t360Select.innerHTML = '<option value="">Choose your T360</option>';

        // Populate T360 based on selected fellowship
        if (fellowship === 'pokuaseCity') {
            t360Select.innerHTML += `
                <option value="t360_1A">T360 Team 1A</option>
                <option value="t360_1B">T360 Team 1B</option>
            `;
        } else if (fellowship === 'metamorphooATU') {
            t360Select.innerHTML += `
                <option value="t360_2A">T360 Team 2A</option>
                <option value="t360_2B">T360 Team 2B</option>
            `;
        } else if (fellowship === 'metamorphooExecutives') {
            t360Select.innerHTML += `
                <option value="t360_3A">T360 Team 3A</option>
                <option value="t360_3B">T360 Team 3B</option>
            `;
        } else if (fellowship === 'metamorphooLegon') {
            t360Select.innerHTML += `
                <option value="TeamSupernatural">Team Supernatural</option>
                <option value="TeamGrace">Team GRACE</option>
                <option value="TeamGod'sMightyArmy">Team God's Mighty Army</option>
                <option value="TeamAmbassadors">Team Ambassadors</option>
                <option value="TeamGloryReigns">Team Glory Reigns</option>
            `;
        }
    }
</script>
</body>
</html>