<?php
require_once 'includes/session.cfg.php';
if(!isset($_SESSION['user_id'])  || !$_SESSION['logged_in']){
    header("Location: mp-before-login.php");
} else {
    require_once 'includes/db.inc.php';
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
    <title>Question Management</title>

    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
    <script src="../jss/eventHandlers.js"></script>
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

            <header>
                <h1>My Questions</h1>
                <button>Sort</button>
            </header>

            <?php 
                $query = "SELECT q.question_id, q.title, q.question, q.date_posted, COUNT(a.answer_id) AS numAnswers
                FROM questions AS q
                LEFT JOIN answers AS a
                ON q.question_id = a.question_id
                WHERE q.user_id=$uid
                GROUP BY q.question_id
                ORDER BY q.date_posted DESC;";
                
                $result = $db->query($query);

                while($match = $result->fetch()){
            ?>
                    <section class="card question-card card-clickable" id="<?=$match['question_id']?>">

                        <div class="card-vote">
                            <!-- <button class="qcard-vote-btn"><img src="../images/vote/30-arrow-up.png" alt="vote up"/></button>
                            <p class="qcard-vote-num">999</p>
                            <button class="qcard-vote-btn"><img src="../images/vote/30-arrow-down.png" alt="vote up"/></button> -->
                        </div>

                        <div class="qcard-body">

                            <header class="qcard-header">
                                <h3><?=$match['title']?></h3>
                            </header>

                            <p class="qcard-question"><?=$match['question']?></p>

                            <footer class="question-footer">
                                <p><?=$match['numAnswers']?> Replies</p>
                                <p><?=$match['date_posted']?></p>
                            </footer>
                        </div>
                    </section>
            <?php
                }
            ?>

        </article>

        <aside>

            <section class="card sidebar-card">

                <header class="card-header sidebar-card-info-header">

                    <div class="sidebar-card-user">
                        <img src="<?=$pfp?>" alt="avatar" class="scard-pfp"/>
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

                    <?php
                        $query = "SELECT COUNT(question_id) AS numQuestions,
                                    (SELECT COUNT(answer_id)
                                    FROM answers 
                                    WHERE user_id=$uid) AS numAnswers,
                                    (SELECT COUNT(vote_id) 
                                    FROM votes 
                                    WHERE user_id=$uid AND vote_status != 0) AS numVotes,
                                    (SELECT SUM(v.vote_status)
                                    FROM answers AS a
                                    JOIN votes As v
                                    ON a.answer_id = v.answer_id
                                    WHERE a.user_id = $uid) AS voteScore 
                                    FROM questions
                                    WHERE user_id=$uid;";
                        $result = $db->query($query);
                        $match = $result->fetch();

                        $voteScore = $match['voteScore'];

                        $score = $match['numQuestions'] + $match['numAnswers'] + ($match['numVotes'] / 2);
                        if($voteScore > 0){
                            $score = min($score *= $voteScore, 9999999);
                        } else if($match['voteScore'] < 0){
                            $score = max($score /= $voteScore, -9999999);
                        } else{
                            $voteScore = 0;
                        }

                        $score = number_format($score, 0, ".", ",");

                    ?>

                    <p class="sidebar-card-stats-title">My Stats:</p>
                    <table class="sidebar-card-stats">
                        <tr class="stats-row">
                            <td>Questions Posted:</td>
                            <td><?=$match['numQuestions']?></td>
                        </tr>
                        <tr class="stats-row">
                            <td>Answers Posted:</td>
                            <td><?=$match['numAnswers']?></td>
                        </tr>
                        <tr class="stats-row">
                            <td>Votes Placed:</td>
                            <td><?=$match['numVotes']?></td>
                        </tr>
                        <tr class="stats-row">
                            <td>Vote Score:</td>
                            <td><?=$voteScore?></td>
                        </tr>
                        <tr class="stats-row">
                            <td>Account Score:</td>
                            <td><?=$score?></td>
                        </tr>
                    </table>

                    <?php 
                        $result = null;
                        $db = null;
                    ?>
                </div>

            </section>

        </aside>

    </main>
    <script src="../jss/eventRegisterQuestionManagement.js"></script>
</body>

</html>