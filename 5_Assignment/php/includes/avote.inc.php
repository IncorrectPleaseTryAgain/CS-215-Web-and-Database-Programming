<?php
require_once 'db.inc.php';
require_once 'session.cfg.php';
$qid = $_GET['qid'];
$aid = $_GET['aid'];
$auid = $_GET['auid'];
$vs = intval($_GET['vs']);
$uid = $_SESSION['user_id'];

if($vs !== -1 && $vs !== 1){
    header("Location: logout.inc.php");
    exit();
}

$query = "SELECT vote_id, vote_status 
FROM votes
WHERE answer_id=$aid AND user_id=$uid;";

$result = $db->query($query);
$match = $result->fetch();

if($uid != $auid) {
    if(empty($match)){
        $query = "INSERT INTO votes 
        (answer_id, user_id, vote_status)
        VALUES (
        $aid, $uid, $vs);";
    
        $result = $db->exec($query);
    } else {
        $vid = $match['vote_id'];
    
        if($match['vote_status'] === $vs){
            $query = "UPDATE votes
            SET vote_status=0
            WHERE vote_id=$vid AND user_id=$uid;";
            $result = $db->exec($query);
        }
        else {
            $query = "UPDATE votes
            SET vote_status=$vs
            WHERE vote_id=$vid AND user_id=$uid;";
            $result = $db->exec($query);
        }
    }
}

$result = null;
$db = null;
header("Location: ../question-detail.php?qid=$qid");
exit();