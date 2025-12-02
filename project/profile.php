<?php
    include 'nav.php';
    require_once "classes.php";
    $pdo = new PDO(
        "mysql:host=localhost;dbname=s5571963_tables;charset=utf8",
        "s5571963_AlfredNavarro", "1234alfred", [PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION]
        );
    $userReference = new User($pdo);
    $topicReference = new Topic($pdo);
    $voteReference = new Vote($pdo);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include "functions.php";
    if (isset($_POST['theme'])) {
        setTheme();
        exit;
    }
    $theme = $_COOKIE['theme'] ?? 'light';

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['logout'])) {
            logOut();
        }
    }

    $votes = $voteReference->getUserVoteHistory($userReference->getUserId($_SESSION['username']));
    $topics = $topicReference->getTopics();

    $totalTopicsCreated = $topicReference->getTotalTopicsCreated($userReference->getUserId($_SESSION['username']));
    $totalVotesCast = $voteReference->getTotalVotesCast($userReference->getUserId($_SESSION['username']));

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
</head>
<body>
    <h1 style="text-align:center; font-size: 100px;">Profile</h1>

    <div id="bigWrapper">
        <div id="userInfo">
            <div>
                <img id="pfp-img" src="imgs/default-pfp.svg" alt="pfp">
                <h3 style="text-align: center;"><?=  $_SESSION['username'] ?? "Guest" ?></h3>
            </div>

            <hr>

            <div>
                <p>ID: </p>
                <p >Total Votes: <?=  $totalVotesCast ?> </p>
                <p >Total Topics Created: <?=  $totalTopicsCreated ?> </p>
            </div>

        </div>

        <div id="vote-history-Wrapper">
            <h2 style="text-align: center; font-size: 40px; margin-top: 15px;">Voting History</h2>

            <div class="vote-blocks">
                <?php foreach($votes as $vote): ?>
                    <?php foreach($topics as $topic): ?>

                    <?php if ($topic->id === $vote->topicId): ?>
                        <div class="topic-vote" style=" background-color: <?= $vote->voteType === 'up' ? '#4dab64' : '#e3495e' ?>" >
                            <p class="vote-content"><?=  $topic->title ?></p>

                            <p class="vote-content"> voted <?=  $vote->voteType?></p>
                        </div>
                    <?php endif ?>

                    <?php endforeach ?>
                <?php endforeach ?>
            </div>

        </div>

    </div>

</body>

</html>

<style>
    #bigWrapper{
        margin: 100px;

        display: flex;
        gap: 40px; /* space between the two boxes */
        align-items: flex-start; /* keeps them aligned at the top */

        color: black;
    }

    #userInfo{
        border: #111111 solid 2px;
        border-radius:10px;

        padding: 20px;

        width: 350px;
        height: 350px;

        background-color:  #E6E6FA;
    }
    #pfp-img{
        height: 200px;
        width: 200px;


        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    #vote-history-Wrapper{
        background-color: #FAF6E6;
        border: solid 2px black;
        border-radius:10px;
        width: 1000px;
        height: 350px;
        padding: 20px;
        display: flex;
        flex-direction: column;
    }
    .vote-blocks {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    .topic-vote{
        border: 1px solid black;
        margin-bottom: 8px;
        border-radius: 6px;

        width: 88px;
        height:fit-content;
    }
    .vote-content{
        margin: 2px;
        text-align: center;
    }


</style>

<?php /*show_source(__FILE__) */?>