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
                    <option value="Basic Education">Basic Education</option>
                    <option value="Secondary Education">Secondary Education</option>
                    <option value="Tertiary Education">Tertiary Education</option>
                </select>
            </div>

            <div class="fDetail mb-3">
                <label for="profession" id="lbl">Profession:</label>
                <input type="text" class="form-control" name="profession" id="profession" placeholder="What is your profession?">
            </div>

            <div class="fDetail mb-3">
                <label for="emergencyContactName" id="lbl">Next of Kin: <span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="emergencyContactName" id="emergencyContactName" placeholder="Who is your Emergency Contact?" required>
            </div>

            <div class="fDetail mb-3">
                <label for="emergencyContact" id="lbl">Contact of Next of Kin: <span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="emergencyContact" id="emergencyContact" placeholder="Type in the contact details for your emergency contact" required>
            </div>

            <div class="fDetail mb-3">
                <label for="network" id="lbl">Which Network are you in? <span style="color: red;">*</span></label>
                <select class="form-select" name="network" id="network" onchange="toggleFellowshipOptions()">
                    <option value="">-- Choose your Network --</option>
                    <option value="Accra">Accra</option>
                    <option value="Kumasi">Kumasi</option>
                    <option value="Ho">Ho</option>
                </select>  
            </div>

            <div id="fellowshipContainer" class="hidden">
                <div class="fDetail mb-3">
                    <label for="fellowship" id="lbl">Your Fellowship:</label>
                    <select class="form-select" id="fellowship" name="fellowship" onchange="showT360sOptions()">
                        <option value="">Find your fellowship headed by the esteemed leaders</option>
                    </select>
                </div>
            </div>

            <div id="t360sContainer" class="hidden">
                <div class="fDetail mb-3">
                    <label for="t360s" id="lbl">Choose your T360:</label>
                    <select class="form-select" id="t360s" name="t360s">
                        <option value="">Select your T360</option>
                    </select>
                </div>
            </div>

            <div class="fDetail mb-3">
            <label id="lbl">What function do you serve? Select all that applies...</label>
            
            <div class="input-group mb-3">
                <div class="input-group-text">
                    <input type="checkbox" name="function[]" value="Pastor">
                </div>
                <label class="form-control">Pastor</label>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-text">
                    <input type="checkbox" name="function[]" value="Deacon">
                </div>
                <label class="form-control">Deacon</label>
            </div>
        
            <div class="input-group mb-3">
                <div class="input-group-text">
                    <input type="checkbox" name="function[]" value="Deaconess">
                </div>
                <label class="form-control">Deaconess</label>
            </div>
            
            <div class="input-group mb-3">
                <div class="input-group-text">
                    <input type="checkbox" name="function[]" value="Network Leader">
                </div>
                <label class="form-control">Network Leader</label>
            </div>            

            <div class="input-group mb-3">
                <div class="input-group-text">
                    <input type="checkbox" name="function[]" value="Fellowship Leader">
                </div>
                <label class="form-control">Fellowship Leader</label>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-text">
                    <input type="checkbox" name="function[]" value="T360 Leader">
                </div>
                <label class="form-control">T360 Leader</label>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-text">
                    <input type="checkbox" name="function[]" value="Stewardship Leader">
                </div>
                <label class="form-control">Stewardship Group Leader</label>
            </div>
            </div>      

            <div class="fDetail mb-3">
                <label id="lbl">Stewardship Groups:</label>
                
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="checkbox" name="stewardshipGroups[]" value="Music">
                    </div>
                    <label class="form-control">Music Department</label>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="checkbox" name="stewardshipGroups[]" value="Media">
                    </div>
                    <label class="form-control">Media Department</label>
                </div>        

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="checkbox" name="stewardshipGroups[]" value="Hospitality">
                    </div>
                    <label class="form-control">Hospitality Department</label>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="checkbox" name="stewardshipGroups[]" value="Fragrance">
                    </div>
                    <label class="form-control">Fragrance Department</label>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="checkbox" name="stewardshipGroups[]" value="First Impression">
                    </div>
                    <label class="form-control">First Impression</label>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="checkbox" name="stewardshipGroups[]" value="Editorial Board">
                    </div>
                    <label class="form-control">Editorial Board</label>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="checkbox" name="stewardshipGroups[]" value="Venue Management">
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
                //SCRIPT FOR THE FELLOWSHIP AND T360s
        const fellowships = {
            Accra: [
                { name: "Pastor Mitchell", disabled: true },
                { name: "Pokuase City", disabled: false },
                { name: "Deacon Edward Atiase", disabled: true },
                { name: "Metamorphoo ATU", disabled: false },
                { name: "Deacon Daniel Fafa Agbosu", disabled: true },
                { name: "Metamorphoo Executives", disabled: false },
                { name: "Minister Prince Semanu Tetteh", disabled: true },
                { name: "Metamorphoo Legon", disabled: false }
            ],
            Kumasi: [
                { name: "Leader C", disabled: true },
                { name: "Fellowship C", disabled: false },
                { name: "Fellowship D", disabled: false }
            ],
            Ho: [
                { name: "Leader E", disabled: true },
                { name: "Fellowship E", disabled: false },
                { name: "Fellowship F", disabled: false }
            ]
        };

        const t360sOptions = {
            "Pokuase City": ["Team Auxanos", "Team Phronesis"],
            "Metamorphoo ATU": ["T360 B1", "T360 B2"],
            "Metamorphoo Executives": ["T360 B1", "T360 B2"],
            "Metamorphoo Legon": ["Team Supernatural", "Team Grace", "Team God's Mighty Army",
             "Team Ambassadors", "Team Glory Reigns", "Team City of Jedidiah"],
            "Fellowship C": ["T360 C1", "T360 C2"],
            "Fellowship D": ["T360 D1", "T360 D2"],
            "Fellowship E": ["T360 E1", "T360 E2"],
            "Fellowship F": ["T360 F1", "T360 F2"]
        };

        function toggleFellowshipOptions() {
            const networkSelect = document.getElementById('network');
            const fellowshipContainer = document.getElementById('fellowshipContainer');

            if (networkSelect.value) {
                fellowshipContainer.classList.remove('hidden');
                showFellowshipOptions();
            } else {
                fellowshipContainer.classList.add('hidden');
                document.getElementById('t360sContainer').classList.add('hidden'); // Hide T360s if network is not selected
                document.getElementById('fellowship').innerHTML = '<option value="">Find your fellowship headed by the esteemed leaders</option>'; // Reset fellowship options
            }
        }

        function showFellowshipOptions() {
            const networkSelect = document.getElementById('network');
            const fellowshipSelect = document.getElementById('fellowship');
            fellowshipSelect.innerHTML = '<option value="">Find your fellowship headed by the esteemed leaders</option>'; // Reset options

            if (networkSelect.value) {
                const selectedNetwork = networkSelect.value;

                fellowships[selectedNetwork].forEach(fellowship => {
                    fellowshipSelect.innerHTML += `<option value="${fellowship.name}" ${fellowship.disabled ? 'disabled' : ''}>${fellowship.name}</option>`;
                });
            }
            showT360sOptions(); // Reset T360s options when network changes
        }

        function showT360sOptions() {
            const fellowshipSelect = document.getElementById('fellowship');
            const t360sSelect = document.getElementById('t360s');
            const t360sContainer = document.getElementById('t360sContainer');
            t360sSelect.innerHTML = '<option value="">Select your T360</option>'; // Reset options

            if (fellowshipSelect.value) {
                t360sContainer.classList.remove('hidden');
                const selectedFellowship = fellowshipSelect.value;

                t360sOptions[selectedFellowship].forEach(t360 => {
                    t360sSelect.innerHTML += `<option value="${t360}">${t360}</option>`;
                });
            } else {
                t360sContainer.classList.add('hidden');
            }
        }
</script>
</body>
</html>