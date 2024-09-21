<?php
require_once 'includes/session.cfg.php';
if(!isset($_SESSION['user_id']) || !$_SESSION['logged_in']){
    header("Location: mp-before-login.php");
}
else {
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
    <title>Question Creation</title>

    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
    <script src="../jss/eventHandlers.js"></script>
</head>

<body>

    <header class="page-header" id="question-creation-header">

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

    <main class="page-main" id="question-creation-body">

        <article class="page-main-body">

            <header>
                <h1>Create Question:</h1>
            </header>

            <section>

                <form action="includes/qcreation.inc.php" method="post" class="card textarea-card" id="question-creation-form" enctype="multipart/form-data">

                    <input type="text" placeholder="Question Title..." name="title" id="question-title" class="question-creation-input"/>

                    <textarea rows="25" placeholder="Question Details..." name="content" id="question-content" class="question-creation-input"></textarea>
                    
                    <div>
                        <p class="character-count" id="question-character-count">0 / 1500 characters</p>
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
    <script src="../jss/eventRegisterQuestionCreation.js"></script>
</body>

</html>