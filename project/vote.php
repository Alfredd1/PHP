<?php
    include 'nav.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include "functions.php";
    require_once "classes.php";
    $pdo = new PDO(
        "mysql:host=localhost;dbname=s5571963_tables;charset=utf8",
        "s5571963_AlfredNavarro", "1234alfred", [PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION]
        );
    $userReference = new User($pdo);
    $topicReference = new Topic($pdo);
    $voteReference = new Vote($pdo);

    $topicList = $topicReference->getTopics();
    $voteList = $voteReference->getVotes();
    $voted = false;
    $theme = $_COOKIE['theme'] ?? 'light';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['logout'])) {
            logOut();
        }
        $topicID = $_POST['topicID'];
        $voteType = $_POST['voteType'] ?? null;

        if ($voteType && !$voteReference->hasVoted($topicID, $userReference->getUserId($_SESSION['username']))) {
            $voteReference->vote($userReference->getUserId($_SESSION['username']), $topicID, $voteType);
        } else if ($voteType) {
            $voted = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
</head>

<body>
    <main>
        <div id="warning" >
            You Already Voted on this topic.
        </div>
        <h2 id="pageTitle">Topic List</h2>
        <div id="grid-wrapper">
            <?php foreach ($topicList as $topic): ?>

            <?php
                $upVotes = $voteReference->getTotalUpVotes($topic->id);
                $downVotes = $voteReference->getTotalDownVotes($topic->id);
                $userVote = null;
                $votes = $voteReference->getUserVoteHistory($userReference->getUserId($_SESSION['username']));
                foreach ($votes as $vote) {
                    if ($vote->topicId == $topic->id) {
                        $userVote = $vote->voteType === "up"; // "up" or "down"
                        break;
                    }
                }
            ?>
            <div class="eventBox">
                <h2 class="topicTitle"><?= $topic->title ?></h2>
                <p>Created By: <?= $userReference->getUsername($topic->userId) ?></p>
                <p>ID: <?= $topic->id ?></p>
                <br>
                <p>Description: <?= $topic->description ?></p>

                <form method="POST">
                    <input type="hidden" name="topicID" value="<?= $topic->id ?>">

                    <button
                            type="submit"
                            name="voteType"
                            value="up"
                            class="upvoteBtn    <?= $userVote ? 'voted' : '' ?>" >
                        <?= $upVotes ?>
                        <br>
                        Upvote
                    </button>

                    <button
                            type="submit"
                            name="voteType"
                            value="down"
                            class="downvoteBtn <?= $userVote ? '' : 'voted' ?> ">
                        <?= $downVotes ?>
                        <br>
                        Downvote
                    </button>

                </form>
            </div>

            <?php endforeach; ?>


        </div>

    </main>

    <footer>

    </footer>

</body>

</html>

<script>
    <?php if ($voted): ?>
        const warning = document.getElementById('warning');
        warning.style.display = 'block'; // show it
        setTimeout(() => {
            warning.style.display = 'none'; // hide after 2 seconds
        }, 2000);
    <?php endif; ?>
</script>


<style>
    #pageTitle{
        text-align: center;
        font-size: 100px;
    }
    .eventBox{
        background-color: #E6E6FA;
        border: black 2px solid;
        border-radius: 5px;

        width: 308px;

        padding: 10px;
        margin-bottom: 15px;

        color: black;
    }
    p{
        margin-bottom: 5px;
        margin-top: 5px;
    }
    .topicTitle{
        margin-bottom: 10px;
        text-align: center;
    }
    button {
        height: 60px;
        width: 150px;
        border-radius: 7px;
    }

    .downvoteBtn:hover{
        background-color: #e3495e;
    }
    .upvoteBtn:hover{
        background-color: #4dab64;
    }
    .upvoteBtn.voted {
        background-color: #4dab64 !important;
        color: white;
    }

    .downvoteBtn.voted {
        background-color: #e3495e !important;
        color: white;
    }


    #grid-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fit, 308px);
        gap: 40px;
        justify-content: center; /* Center the whole grid */
    }

    #warning{
        display: none;
        background-color: red;
        font-size: 40px;
        font-weight:bold;
        height: 50px;
        text-align: center;

    }
</style>


<script>


</script>

<?php /*show_source(__FILE__) */?>