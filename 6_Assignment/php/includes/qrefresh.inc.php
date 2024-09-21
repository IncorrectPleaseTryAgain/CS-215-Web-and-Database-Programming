<?php
require_once 'db.inc.php';
$response = array();

// check: there is at least 1 question on page
$rqid = ($_GET['rqid'] != "empty") ? $_GET['rqid'] : 0;

// changes depending on mp-before-login, mp-after-login
$lim = $_GET['lim'];

// get any new questions that aren't on the page
$query = "SELECT u.username, u.profile_photo, q.question_id, q.title, q.question, q.date_posted, COUNT(a.answer_id) AS numAnswers
    FROM questions AS q
    JOIN users AS u
    ON q.user_id = u.user_id
    LEFT JOIN answers AS a
    ON q.question_id = a.question_id
    WHERE q.question_id > $rqid
    GROUP BY q.question_id
    ORDER BY q.date_posted DESC
    LIMIT $lim;";
$result = $db->query($query);
$match = $result->fetch();

// check: no new questions
if(empty($match)){
    $response = null;
} else {
    do {
        // save the question data as a response
        $data = array(
            "username"=> $match['username'],
            "profile_photo"=> $match['profile_photo'],
            "question_id"=> $match['question_id'],
            "title"=> $match['title'],
            "question"=> $match['question'],
            "date_posted"=> $match['date_posted'],
            "numAnswers"=> $match['numAnswers']);

        $response[] = $data;

    }while($match = $result->fetch());
}
$result = null;

echo json_encode($response);