<?php
require_once 'db.inc.php';
$result = "";

// Code snippet from CS-215 Lab 10
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errors = array();
$email = "";
$uname = "";
$pwd = "";
$cpwd = "";
$dob = "";
$pfp = "";


// Check that user got to this page through POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $emailRegex = "<^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$>";
    $unameRegex = "<^[a-zA-Z0-9@#_-]{1,15}$>";
    $pwdRegex = "<^[a-zA-Z0-9@#_!]{8,13}$>";
    $dobRegex = "<^\d{4}-\d{2}-\d{2}$>";


    $email = strtolower(sanitizeInput($_POST["email"]));
    $uname = sanitizeInput($_POST["uname"]);
    $pwd = sanitizeInput($_POST["pwd"]);
    $cpwd = sanitizeInput($_POST["cpwd"]);
    $dob = sanitizeInput($_POST["dob"]);
    $pfp = $_FILES["pfp"];

    // Validate the form inputs against their Regexes 
    if (!preg_match($emailRegex , $email)) {
        $errors["email"] = "101";
    }
    if (!preg_match($unameRegex , $uname)) {
        $errors["uname"] = "102";
    }
    if (!preg_match($pwdRegex , $pwd)) {
        $errors["pwd"] = "103";
    }
    if (!preg_match($dobRegex , $dob)) {
        $errors["dob"] = "104";
    }
    if ($cpwd != $pwd) {
        $errors["cpwd"] = "105";
    }


    // Validate the file input
    $file = $pfp['name'];
    $fileTempDestination = $pfp['tmp_name'];
    $fileSize = $pfp['size'];

    $fileAsArray = explode(".", $file);
    $fileExt = strtolower(end($fileAsArray));

    $allowedExt = ["jpg", "jpeg", "png", "gif"];

    // Check file type
    if(!in_array($fileExt, $allowedExt)){
        $errors["file_type"] = "201";
    }

    // Check file size | MAX: 1.5Mb
    if($fileSize > 1500000){
        $errors["file_size"] = "202";
    }

    // Check file error
    if($pfp['error'] !== 0){
        $errors["file_error"] = "203";
    }

    // Check if user already exists | username
    $query = "SELECT user_id FROM users WHERE username='$uname'";
    $result = $db->query($query);
    $match = $result->fetch();
    if(!empty($match)){
        $errors["db_duplicate_username"] = "301";
    }

    // Check if user already exists | email
    $query = "SELECT user_id FROM users WHERE email='$email'";
    $result = $db->query($query);
    $match = $result->fetch();
    if(!empty($match)){
        $errors["db_duplicate_email"] = "302";
    }


    if(!empty($errors)){
        $result = null;
        $db = null;

        $errs = implode("+", $errors);
        header("Location: ../signup.php?errs=" . $errs);
        exit();
    } else {

        // Insert user into table | Temporary profile picture destination
        $query = "INSERT INTO users (email, username, password, date_of_birth, profile_photo) VALUES (
            '$email',
            '$uname',
            '$pwd',
            '$dob',
            'PLACEHOLDER.EXT'
            );";
        $result = $db->exec($query);
        if(!$result){
            $error["query_insert"] = "401";

            // Exit
            $result = null;
            $db = null;
            $errs = implode("+", $errors);
            header("Location: ../signup.php?errs=" . $errs);
            exit();
        }
        $userId = $db->lastInsertId();

        // Upload file
        $fileDirectory = "../../uploads/";
        $fileName = $userId . "." . $fileExt;
        $fileNewDestination = $fileDirectory . $fileName;
        move_uploaded_file($fileTempDestination, $fileNewDestination);


        // Update user in table | Permanent profile picture destination
        $filePath = "../uploads/" . $fileName;
        $query = "UPDATE users SET profile_photo='$filePath' WHERE user_id='$userId';";
        $result = $db->exec($query);
        if(!$result){
            $error["query_update"] = "402";

            // Delete account
            $query = "DELETE FROM users WHERE user_id='$userId'";
            $result = $db->exec($query);

            // Exit
            $result = null;
            $db = null;
            $errs = implode("+", $errors);
            header("Location: ../signup.php?errs=" . $errs);
            exit();
        }
        header("Location: ../mp-before-login.php?success");
    }
}
else {
    $db = null;

    header("Location: ../signup.php?errs=000");
    exit();
}