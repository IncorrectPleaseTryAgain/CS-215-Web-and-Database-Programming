<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=1, initial-scale=1.0"/>
    <title>Sign Up</title>

    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
    <script src="../jss/eventHandlers.js"></script>
</head>

<body>

    <main class="page-main page-main-signup">

        <form id="signup-form" action="includes/signup.inc.php" method="post" enctype="multipart/form-data" class="card signup-card">
            
            <header class="card-header signup-card-header">
                <a href="#"><img src="../images/logo/orig-placeholder.png" alt="website logo" id="website-logo"/></a>
                <h2 class="website-name"><a href="mp-before-login.php">Website Name</a></h2>
            </header>
            
            <section class="signup-card-body">

                <label for="username">Username:</label>
                <input class="signup-input" type="text" id="input-username" name="uname" placeholder="username..."/>
                <p class="error-message hidden" id="err-msg-username">Username Invalid</p>

                <label for="email">Email:</label>
                <input class="signup-input" type="text" id="input-email" name="email" placeholder="email..."/>
                <p class="error-message hidden" id="err-msg-email">Email Invalid</p>

                <label for="password">Password:</label>
                <input class="signup-input" type="password" id="input-password" name="pwd" placeholder="password..."/>
                <p class="error-message hidden" id="err-msg-password">Password Invalid</p>

                <label for="confirm-password">Confirm Password:</label>
                <input class="signup-input" type="password" id="input-confirm-password" name="cpwd" placeholder="re-enter password..."/>
                <p class="error-message hidden" id="err-msg-confirm-password">Password Does Not Match</p>

                <label for="dob">Date of Birth:</label>
                <input class="signup-input" type="date" id="input-dob" name="dob"/>
                <p class="error-message hidden" id="err-msg-dob">Date of Birth Invalid</p>

                <label for="avatar">Profile Picture:</label>
                <input class="signup-input" type="file" id="input-avatar" name="pfp"/>
                <p class="error-message hidden" id="err-msg-avatar">Avatar Invalid</p>

                <input type="submit" value="Create Account"/>
                <p>Already have an account? <a href="mp-before-login.php">sign in</a></p>

            </section>

        </form>
        
        <div class="errors"> 
            <?php
                if(isset($_GET['errs'])){
                    ?>
                    Errors:
                    <?php
                    
                    // Open file
                    $myfile = fopen("errors.txt", "r") or die("Unable to open file!");

                    // Get errors
                    $getErrs = explode(" ", $_GET['errs']);

                    while(!feof($myfile)) {

                        //Check error code
                        $fileRow = str_replace("\n", "", fgets($myfile));
                        $fileErrs = array_unique(explode(":", $fileRow));
                        $fileErrCode = $fileErrs[0];

                        if(in_array($fileErrCode, $getErrs)){
                            echo "<p class='color-red'>$fileRow</p>";
                        }
                    }

                    fclose($myfile);
                }
            ?>
        </div>
    </main>
    <script src="../jss/eventRegisterSignup.js"></script>
</body>



</html>