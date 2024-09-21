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

// Check that user got to this page through POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $qTitle = sanitizeInput($_POST['title']);
    $qContent = sanitizeInput($_POST['content']);

    if(strlen($qTitle) === 0 || strlen($qContent) === 0){
        $result = null;
        $db = null;        
        $errors["input_empty"] = "001";
        $errs = implode("+", $errors);
        header("Location: ../question-creation.php?errs=" . $errs);
        exit();
    } else{

        $userId = $_SESSION['user_id'];
        $query = "INSERT INTO questions (user_id, title, question) VALUES ($userId, '$qTitle', '$qContent');";
        $result = $db->exec($query);

        if(!$result){
            $error["query_insert"] = "401";

            // Exit
            $result = null;
            $db = null;
            $errs = implode("+", $errors);
            header("Location: ../question-management.php?errs=" . $errs);
            exit();
        }

        // Exit
        $result = null;
        $db = null;
        header("Location: ../question-management.php?success");
        exit();
    }
}
else {
    $db = null;

    header("Location: ../question-creation.php?errs=000");
    exit();
}