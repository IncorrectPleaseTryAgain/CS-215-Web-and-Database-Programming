<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=1, initial-scale=1.0"/>
    <title>Main Page | Before Login</title>

    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
    <script src="../jss/eventHandlers.js"></script>
</head>

<body>

    <header class="page-header">

        <img src="../images/logo/orig-placeholder.png" alt="website logo"/>
        <h2 class="website-name"><a href="#">Website Name</a></h2>

        <nav class="page-header-nav">

            <form class="search-form" role="search">
                <input type="search" placeholder="Search Question..."/>
                <button class="search-btn">Search</button>
            </form>

            <button class="menu-btn">Menu</button>
        </nav>

    </header>
    
    <main class="page-main">
        
        <article class="page-main-body">
            
            <header>
                <h1>Recent Questions</h1>
                <button>Sort</button>
            </header>

            <div id="questions">            
                <?php
                    require_once 'includes/db.inc.php';
                    require_once 'includes/session.cfg.php';

                    $query = "SELECT u.username, u.profile_photo, q.question_id, q.title, q.question, q.date_posted, COUNT(a.answer_id) AS numAnswers
                        FROM questions AS q
                        JOIN users AS u
                        ON q.user_id = u.user_id
                        LEFT JOIN answers AS a
                        ON q.question_id = a.question_id
                        GROUP BY q.question_id
                        ORDER BY q.date_posted DESC
                        LIMIT 5;";
                    $result = $db->query($query);
                    $match = $result->fetch();
                    
                    if(empty($match)){
                        echo "<h2>It's like a ghost town...👻</h2>";
                    } else {
                        do {
                ?>
                            <section class="card question-card" id="<?=$match['question_id']?>">

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
                        } while($match = $result->fetch());
                    }
                    $result = null;
                    $db = null;
                ?>
            </div>

        </article>

        <aside>
            
            <section class="card sidebar-card">

                <header class="card-header"><h2>Sign In</h2></header>

                <form id="login-form" action="includes/login.inc.php" method="post" enctype="multipart/form-data">

                    <div class="sidebar-card-body">

                        <label class="sidebar-card-input-label-email" for="input-email">Email</label>
                        <input type="text" id="input-email" name="email" placeholder="email..." value="<?=isset($_SESSION['email']) ? $_SESSION['email'] : null?>"/>
                        <p class="error-message hidden" id="err-msg-email">Email Invalid</p>
    
                        <label class="sidebar-card-input-label-password" for="input-password">Password</label>
                        <input type="password" id="input-password" name="password" placeholder="password..."/>
                        <p class="error-message hidden" id="err-msg-password">Password Invalid</p>

                        <div class="sidebar-card-password-options">

                            <div>
                                <input type="checkbox" id="sidebar-card-show-password"/>
                                <label for="sidebar-card-show-password">Show Password</label>
                            </div>

                            <a href="signup.php">forgot password?</a>

                        </div>
        
                        <input type="submit" name="login" value="Sign In"/>
                        
                    </div>
                    
                </form>
                
                <p class="sidebar-card-footer">Don't have an account?<a href="signup.php" id="signup">Sign Up</a></p>

            </section>

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
        </aside>

    </main>
    <script src="../jss/mpBeforeLoginRefresh.js"></script>
    <script src="../jss/eventRegisterBeforeLogin.js"></script>
</body>

</html>