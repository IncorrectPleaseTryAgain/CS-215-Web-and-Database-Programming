<?php
require_once 'includes/session.cfg.php';
if(!isset($_SESSION['user_id'])  || !$_SESSION['logged_in']){
    header("Location: mp-before-login.php");
} else if (empty($_GET['qid'])){
    header("Location: mp-after-login.php");
} else {
    require_once 'includes/db.inc.php';
    $qid = $_GET['qid'];
    $uid = $_SESSION['user_id'];
    $uname = $_SESSION['username'];
    $pfp = $_SESSION['profile_photo'];
}
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=1, initial-scale=1.0"/>
    <title>Question Details</title>

    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
    <script src="../jss/eventHandlers.js"></script>
    <script src="https://kit.fontawesome.com/0d7596943b.js" crossorigin="anonymous"></script>
</head>

<body>

    <header class="page-header" id="mp-after-login-header">

        <a href="#"><img src="../images/logo/orig-placeholder.png" alt="website logo"/></a>
        <h2 class="website-name"><a href="mp-after-login.php">Website Name</a></h2>

        <nav class="page-header-nav">

            <form role="search" class="search-form">
                <input type="search" placeholder="Search Question..."/>
                <button class="search-btn">Search</button>
            </form>

            <button class="menu-btn">Menu</button>
        </nav>

    </header>
    
    <main class="page-main" id="mp-after-login-body">

        <article class="page-main-body">

            <h1>Question Details</h1>

            <!-- QUESTION -->
            <?php
                $errors = "";

                 $query = "SELECT u.username, u.profile_photo, q.title, q.question, q.date_posted, COUNT(a.answer) AS numAnswers
                 FROM questions AS q
                 INNER JOIN users AS u
                 ON q.user_id = u.user_id
                 LEFT JOIN answers AS a
                 ON q.question_id = a.question_id
                 WHERE q.question_id=$qid
                 GROUP BY a.question_id
                 ORDER BY q.date_posted;";
                 
                 $result = $db->query($query);
                 $match = $result->fetch();

                 if(empty($match)){
                    $errors = "403";

                    $result = null;
                    $db = null;
                    header("Location: mp-after-login.php?errs=" . $errors);
                 } else {
            ?>
            <section class="card question-card" name="question" id="<?=$qid?>">

                <div class="card-vote">

                    <!-- <button class="qcard-vote-btn"><img src="../images/vote/30-arrow-up.png" alt="vote up"/></button>
                    <p class="qcard-vote-num">999</p>
                    <button class="qcard-vote-btn"><img src="../images/vote/30-arrow-down.png" alt="vote up"/></button> -->
            
                </div>

                <div class="qcard-body">

                    <header class="qcard-header">

                        <h3 class="qcard-title"><?=$match['title']?></h3>

                        <div class="qcard-author">
                            <p><?=$match['username']?></p>
                            <img src="<?=$match['profile_photo']?>" alt="avatar" class="qcard-pfp"/>
                        </div>

                    </header>

                    <p><?=$match['question']?></p>

                    <footer class="question-detail-footer">
                        <p><?=$match['date_posted']?></p>
                    </footer>

                </div>

            </section>
            <h2><?=$match['numAnswers']?> Replies</h2>
            <?php
                }
            ?>

            <!-- ANSWERS -->
            <div id="answers">
            <?php
                if(!$match['numAnswers']){
                    echo "<h2 id='empty'>It's like a ghost town...👻</h2>";
                } else {
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

                while($match = $result->fetch()) {

                    $aid = $match['answer_id'];

                    $query2 = "SELECT vote_status, user_id
                    FROM votes
                    WHERE answer_id=$aid AND user_id=$uid";
                    $result2 = $db->query($query2);
                    $match2 = $result2->fetch();
            ?>
                            <sections class="card answer-card" id="aid-<?=$aid?>">

                                <div class="card-vote-active">

                                    <input type="image" id="vtu-<?=$aid?>" src="../images/vote/30-arrow-up.png" alt="UP" class="vote-btn vote-btn-up 
                                    <?php if(!empty($match2)) { echo ($match2['vote_status'] == 1 && $match2['user_id'] == $uid) ? "vote-active-green": ""; } ?>">

                                    <p class="comment-vote-num" id="vs-<?=$aid?>"><?=($match['numVotes'] == 0) ? "0" : $match['numVotes'];?></p>

                                    <input type="image" id="vtd-<?=$aid?>" src="../images/vote/30-arrow-down.png" alt="DOWN" class="vote-btn vote-btn-down 
                                    <?php if(!empty($match2)) { echo ($match2['vote_status'] == -1 && $match2['user_id'] == $uid) ? "vote-active-red": ""; } ?>">

                                </div>

                                <div class="qcard-body">
                                
                                <header class="qcard-header">

                                    <h3 class="acard-title"><?=$match['title']?></h3>

                                    <div class="qcard-author">
                                        <p><?=$match['username']?></p>
                                        <img src="<?=$match['profile_photo']?>" alt="avatar" class="qcard-pfp"/>
                                    </div>

                                </header>

                                <p class="acard-question"><?=$match['answer']?></p>

                                <footer>
                                    <p><?=$match['date_posted']?></p>
                                </footer>

                                </div>
                            </sections>

            <?php
                    }
                }

                $result = null;
            ?>
            </div>

            <section>

              <h2>Post Response: </h2>

              <form action="<?="includes/qdetail.inc.php?qid=".$_GET['qid'];?>" method="post" class="card textarea-card" id="answer-form" enctype="multipart/form-data">

                <input type="text" placeholder="Response Title..." name="title" id="answer-title" class="texarea-title"/>

                <textarea rows="10" placeholder="Response Details..." name="content" id="answer-content"></textarea>

                <div>
                  <p class="character-count" id="answer-character-count">0 / 1500 characters</p>
                  <input type="submit" value="Post"/>
                </div>

              </form>

            </section>

        </article>
        
        <aside>

            <section class="card sidebar-card">

                <header class="card-header sidebar-card-info-header">

                    <div class="sidebar-card-user">
                        <a href="#"><img src="<?=$pfp?>" alt="avatar" class="scard-pfp"/></a>
                        <p><?=$uname?></p>
                    </div>

                    <form action="includes/logout.inc.php" method="post">
                      <input type="submit" value="logout" class="logout"/>
                    </form>

                </header>

                <div class="sidebar-card-body">

                  <form target="_self" action="question-creation.php" method="post">
                    <input type="submit" value="Create Question"/>
                  </form>

                    <a href="question-management.php" class="sidebar-card-link-my-questions"><span class="fa-solid fa-pen-to-square"></span> My Questions</a>

                    <?php
                        $query = "SELECT q.title, COUNT(a.answer_id) AS numAnswers
                        FROM questions AS q
                        LEFT JOIN answers AS a
                        ON q.question_id = a.question_id
                        WHERE q.user_id=$uid
                        GROUP BY q.question_id
                        ORDER BY 2 DESC
                        LIMIT 3;";
                        
                        $result = $db->query($query);

                        while($match = $result->fetch()){
                    ?>
                            <section class="sidebar-card-qpreview">
                                <h4 class="sidebar-card-qpreview-title"><?=$match['title']?></h4>

                                <div class="sidebar-card-qpreview-stats">
                                    <!-- <div class="sidebar-card-qpreview-votes">
                                        <img src="../images/vote/25-arrow-updown.png" alt="vote logo"/>
                                        <p>999</p>
                                    </div> -->
                                    <p><?=$match['numAnswers']?> Responses</p>
                                </div>
                            </section>
                    <?php
                        }
                        $result = null;
                        $db = null;
                    ?>
                </div>

            </section>

        </aside>

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
    <script src="../jss/questionDetailRefresh.js"></script>
    <script src="../jss/eventRegisterQuestionDetails.js"></script>
</body>

</html>