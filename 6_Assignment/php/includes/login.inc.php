<?php
require_once 'db.inc.php';
require_once 'session.cfg.php';
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
$pwd = "";


// Check that user got to this page through POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $_SESSION["email"] = $_POST['email']; 

    $emailRegex = "<^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$>";
    $pwdRegex = "<^[a-zA-Z0-9@#_!]{8,13}$>";


    $email = strtolower(sanitizeInput($_POST["email"]));
    $pwd = sanitizeInput($_POST["password"]);

    // Validate the form inputs against their Regexes 
    if (!preg_match($emailRegex , $email)) {
        $errors["email"] = "101";
    }
    if (!preg_match($pwdRegex , $pwd)) {
        $errors["pwd"] = "103";
    }

    // Check if user exists
    $query = "SELECT user_id, username, profile_photo FROM users WHERE email='$email' AND password='$pwd'";
    $result = $db->query($query);
    $match = $result->fetch();
    if(empty($match)){
        $errors["db_invalid_email"] = "501";
    }

    if(!empty($errors)){
        $result = null;
        $db = null;

        $errs = implode("+", $errors);
        header("Location: ../mp-before-login.php?errs=" . $errs);
        exit();
    } else{
        $_SESSION = $match;
        $_SESSION['logged_in'] = true;
        unset($_SESSION['email']);

        $result = null;
        $db = null;

        header("Location: ../mp-after-login.php");
        exit();
    }
}
else {
    $db = null;

    header("Location: ../mp-before-login.php?errs=000");
    exit();
}