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
    $aTitle = sanitizeInput($_POST['title']);
    $aContent = sanitizeInput($_POST['content']);

    if(strlen($aTitle) === 0 || strlen($aContent) === 0){
        $result = null;
        $db = null;        
        $errors["input_empty"] = "001";
        $errs = implode("+", $errors);
        header("Location: ../question-detail.php?errs=" . $errs);
        exit();
    } else{

        $userId = $_SESSION['user_id'];
        $questionId = $_GET['qid'];

        $query = "INSERT INTO answers (question_id, user_id, title, answer) VALUES ($questionId, $userId, '$aTitle', '$aContent');";
        $result = $db->exec($query);

        if(!$result){
            $error["query_insert"] = "401";

            // Exit
            $result = null;
            $db = null;
            $errs = implode("+", $errors);
            header("Location: ../question-detail.php?errs=" . $errs);
            exit();
        }

        // Exit
        $result = null;
        $db = null;
        header("Location: ../question-detail.php?qid={$questionId}");
        exit();
    }
}
else {
    $db = null;

    header("Location: ../question-detail.php?errs=000");
    exit();
}