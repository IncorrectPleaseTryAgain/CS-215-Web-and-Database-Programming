<?php
require_once 'db.inc.php';
require_once 'session.cfg.php';
$response = null;

// get answer id
$aid = $_GET['aid'];
// get vote new vote status
$vs = intval($_GET['vs']);
// get current user id
$uid = $_SESSION['user_id'];


// get question id
$query = "SELECT user_id
    FROM answers
    WHERE answer_id=$aid";
$result = $db->query($query);
$match = $result->fetch();
$auid = $match['user_id'];


// users cannot vote on their own answers
// check: user placing vote != user who posted answer
if($uid != $auid) {
    // get vote id and vote status for 
    // current answer and current user who is placing vote
    $query = "SELECT vote_id, vote_status 
        FROM votes
        WHERE answer_id=$aid AND user_id=$uid;";
    $result = $db->query($query);
    $match = $result->fetch();

    // check: user has not placed vote on answer previously
    if(empty($match)){

        // create new vote entry
        $query = "INSERT INTO votes 
            (answer_id, user_id, vote_status)
            VALUES (
            $aid, $uid, $vs);";
        $result = $db->exec($query);

    } else {
        $vid = $match['vote_id'];
    
        // if vote status is same as current vote being placed, then
        // remove vote, by
        // setting vote status to 0 'no vote'
        if($match['vote_status'] === $vs){ $vs = 0; }

        // update the vote with the new vote status
        $query = "UPDATE votes
            SET vote_status=$vs
            WHERE vote_id=$vid AND user_id=$uid;";
        $result = $db->exec($query);
    }

    // get vote sum for current answer
    $query = "SELECT SUM(v.vote_status) AS votes
        FROM votes AS v
        WHERE v.answer_id = $aid
        GROUP BY v.answer_id;";
    $result = $db->query($query);
    $match = $result->fetch();
    
    // close databse
    $result = null;
    $db = null;
    
    // send results to eventHandlers.js : voteDownHandler or voteUpHandler
    $voteSum = $match['votes'];
    $response = array("vote-sum" => $voteSum, "vote-status" => $vs);
}


echo json_encode($response);