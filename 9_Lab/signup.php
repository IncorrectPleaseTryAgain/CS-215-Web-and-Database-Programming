<?php
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>CS215 Homepage</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div id="container">
        <header id="header-auth">
            <h1>My Login History</h1>
        </header>
        <main id="main-left">

        </main>
        <main id="main-center">


<?php

//We will show a results page if we have valid POST data, and the form otherwise

// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If we got here through a POST submitted form, process the form

    //This array will keep track of any errors we find while processing the form
    $errors = array();


    // TODO 4.1: Grab all the form inputs (firstName, lastName, username, password, dob) 
    //           from the $_POST superglobal variable, test them to be sure they are safe,
    //           and store them into different variables,
    $firstName = test_input($_POST["fname"]);
    $lastName = test_input($_POST["lname"]);
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
    $dateOfBirth = test_input($_POST["dob"]);
    // ...
    
    // Form Field Regular Expressions - these should match the JavaScript ones
    $nameRegex = "/^[a-zA-Z]+$/";
    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    $passwordRegex = "/^.{8}$/"; //require 8 characters of any type
    $dobRegex = "/^\d{4}[-]\d{2}[-]\d{2}$/";
    
    // TODO 4.2: Validate the form inputs against their Regexes 
    $dataOK = TRUE;
    if (!preg_match($nameRegex, $firstName)) {
        $errors['fname'] = "Invalid First Name";
    }
    if (!preg_match($nameRegex, $lastName)) {
        $errors['lname'] = "Invalid Last Name";
    }
    if (!preg_match($unameRegex, $username)) {
        $errors['uanme'] = "Invalid Username";
    }
    if (!preg_match($nameRegex, $password)) {
        $errors['pwd'] = "Invalid Password";
    }
    if (!preg_match($dobRegex, $dateOfBirth)) {
        $errors['dob'] = "Invalid Date of Birth";
    }
    // ...

    // Directory where the avatars will be uploaded.
    $target_dir = "uploads/";
    $uploadOk = TRUE;


    // var_dump($_FILES);

    // Fetch the image filetype
    $imageFileType = strtolower(pathinfo($_FILES["profilephoto"]["name"],PATHINFO_EXTENSION));
    $imageFileName = strtolower(pathinfo($_FILES["profilephoto"]["name"],PATHINFO_FILENAME));

    // TODO: 5.1 Combine the $target_dir, $imageFileName and $imageFileType 
    //           to create a path to move the file to
    //$target_file = ...;
    $target_file = $target_dir.$imageFileName.'.'.$imageFileType;
    echo "{$imageFileType}<br>";

    // TODO: 5.2 Check whether the file exists in the uploads directory
    //       set uploadOk to FALSE if it already exists and add a message to the $errors array
    if(file_exists($target_file)){
        $errors['log_duplicate'] = "File already exists.";
        $uploadOk = FALSE;
    }


    // TODO: 5.3 Check whether the file is too large - maximum ~1MB
    //       set uploadOk to FALSE if it is too large and add a message to the $errors array
    if($_FILES["profilephoto"]["size"] > 1000000){
        $errors['log_size'] = "File too large.";
        $uploadOk =  FALSE;
    }


    // TODO: 5.4 Check the file extension to be sure it is an image
    //       set uploadOk to FALSE if it is not an accepted image type
    //       and add a message to the $errors array
    if($imageFileType != "jpg" && $imageFileType != "png" 
    && $imageFileType != "jpeg" && $imageFileType != "gif"){
        $errors['log_type'] = "File type not accepted.";
        $uploadOk = FALSE;
    }

    if ($uploadOk) {
        // TODO 5.5: Move the user's avatar to the uploads directory 
        //           and capture the result as $fileStatus.
        //$fileStatus = ...;
        $fileStatus = move_uploaded_file($_FILES["profilephoto"]["tmp_name"], $target_file);
        // var_dump($_FILES);

        // TODO 5.6: Check $fileStatus. 
        //           If the file could not be moved, add an error to the $errors array.
        if(!isset($fileStatus)){
            $errors['log_status'] = "Could not be moved";
        }
    }

    //Print the $_POST data if there's no errors
    //Next lab this will be stored and retrieved from the database
    if(empty($errors)) {
?>

        <section>
            <h2>
                <!-- TODO 6.1: Fill in username from POST data -->
                <?= $username ?>
            </h2>

            <!-- TODO 6.2: Fill in picture path -->
            <img src="<?=$target_file?>" alt="Picture of ..." />

            <div id="user-data">
                <h3 class="user-info-name">
                    <!-- First name and last name from POST data -->
                    <?= $firstName ?> <?= $lastName ?>
                </h3>

                <p class="user-info-dob">
                    <!-- TODO 6.3: Fill in Date of Birth from POST data -->
                    <?= $dateOfBirth ?>
                </p>

                <a class="update-info" href="signup.php">Edit</a></h1>
            </div>
        </section>
<?php

    } else {
        foreach($errors as $error)
        {
            print($error . "\n<br />");
        }
    }

} else {
    // echo "AAAAAAAAAAAAAA";
    //If we did not arrive here through a POST form submission, show the page.
?>
 
            <!--Do not remove the enctype attribute from the form element -->
                <form action="" method="POST" class="auth-form" id="signup-form" enctype="multipart/form-data">
                    <h3>Signup Form</h3>
                <p class="input-field">
                    <label>First Name</label>
                    <input type="text" id="fname" name="fname" /><br>
                <p id="error-text-fname" class="error-text hidden">First name is invalid</p>
                </p>
                <p class="input-field">
                    <label>Last Name</label>
                    <input type="text" id="lname" name="lname" />
                <p id="error-text-lname" class="error-text hidden">Last name is invalid</p>
                </p>
                <p class="input-field">
                    <label>Username</label>
                    <input type="text" id="username" name="username" />
                <p id="error-text-username" class="error-text hidden">Username is invalid</p>
                </p>
                <p class="input-field">
                    <label>Password</label>
                    <input type="password" id="password" name="password" />
                <p id="error-text-password" class="error-text hidden">Password is invalid</p>

                </p>
                <p class="input-field">
                    <label>Confirm Password</label>
                    <input type="password" id="cpassword" name="cpassword" />
                <p id="error-text-cpassword" class="error-text hidden">Confirm password is invalid</p>

                </p>
                <p class="input-field">
                    <label>Date of Birth</label>
                    <input type="date" id="dob" name="dob" />
                <p id="error-text-dob" class="error-text hidden">Date of birth is invalid</p>

                </p>
                <p class="input-field">
                    <label>Profile Photo</label>
                    <input type="file" id="profilephoto" name="profilephoto" accept="image/*" />
                <p id="error-text-profilephoto" class="error-text hidden">Profile photo is invalid</p>

                </p>

                <p>
                    <input type="submit" class="form-submit" value="Signup" />
                </p><br>
            </form>
            <div class="foot-note">
                <p>Already have an account? <a href="login.php">Login</a></p>
                <script src="js/eventRegisterSignup.js"></script>
            </div>
<?php
}
?>
        </main>
        <main id="main-right">

        </main>
        <footer id="footer-auth">
            <p class="footer-text">CS 215: Lab 3 Solution</p>
        </footer>
    </div>
</body>

</html>