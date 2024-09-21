<?php
require_once 'includes/session.cfg.php';
if(!isset($_SESSION['user_id']) || !$_SESSION['logged_in']){
    header("Location: mp-before-login.php");

    echo "FAILED";
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
    <title>Main Page | After Login</title>

    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
    <script src="../jss/eventHandlers.js"></script>
</head>

<body>

    <header class="page-header">

        <img src="../images/logo/orig-placeholder.png" alt="website logo"/>
        <h2 class="website-name"><a href="#">Website Name</a></h2>

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
                <h1>Recent Questions</h1>
                <button>Sort</button>
            </header>

            <?php
                $query = "SELECT u.username, u.profile_photo, q.question_id, q.title, q.question, q.date_posted, COUNT(a.answer_id) AS numAnswers
                FROM questions AS q
                JOIN users AS u
                ON q.user_id = u.user_id
                LEFT JOIN answers AS a
                ON q.question_id = a.question_id
                GROUP BY q.question_id
                ORDER BY q.date_posted DESC
                LIMIT 20;";

                $result = $db->query($query);
                
                $match = $result->fetch();
                if(empty($match)){
                    echo "<h2>It's like a ghost town...👻</h2>";
                } else {
                    do {
            ?>
                        <section class="card question-card card-clickable" id="<?=$match['question_id']?>">

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
                                        <a href="#"><img src="<?=$match['profile_photo']?>" alt="avatar" class="qcard-pfp"/></a>
                                    </div>

                                </header>

                                <p class="qcard-question"><?=$match['question']?></p>

                                <footer class="question-footer">

                                    <p><?=$match['numAnswers']?> Responses</p>
                                    <p><?=$match['date_posted']?></p>

                                </footer>

                            </div>

                        </section>
            <?php
                    }while($match = $result->fetch());
                }
                $result = null;
            ?>

        </article>

        <aside>

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

                    <a href="question-management.php" class="sidebar-card-link-my-questions"><img src="../images/other/link.png" alt="link icon"/> My Questions</a>

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

    </main>
    <script src="../jss/eventRegisterAfterLogin.js"></script>
</body>
</html>