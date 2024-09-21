<?php
require_once 'db.inc.php';
$response = array();


$qid = $_GET['qid'];
// check: there is at least 1 answer on page
// recent answer id
$raid = ($_GET['raid'] != "empty") ? $_GET['raid'] : 0;


// get any new answers that aren't on the page
$query = "SELECT a.user_id, a.title, a.answer, a.date_posted, a.answer_id, u.username, u.profile_photo, SUM(v.vote_status) AS numVotes
FROM answers AS a
INNER JOIN users AS u
ON a.user_id = u.user_id
LEFT JOIN votes AS v
ON a.answer_id = v.answer_id
WHERE a.question_id=$qid
GROUP BY a.answer_id
ORDER BY a.date_posted DESC;";
$result = $db->query($query);
$match = $result->fetch();

// check: no new answers
if(empty($match)){
    $response = "null";
} else {
    do {

        

        // save the answers data as a response
        $data = array(
            "title"=> $match['title'],
            "answer"=> $match['answer'],
            "date_posted"=> $match['date_posted'],
            "answer_id"=> $match['answer_id'],
            "username"=> $match['username'],
            "profile_photo"=> $match['profile_photo'],
            "numVotes" =>($match['numVotes'] == 0) ? "0" : $match['numVotes']);
        $response[] = $data;

    }while($match = $result->fetch());
}
$result = null;

echo json_encode($response);