<?php
    include 'nav.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include "functions.php";

    $topicList = getTopics();
    $voted = false;
    $theme = $_COOKIE['theme'] ?? 'light';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['logout'])) {
            logOut();
        }
        $topicID = $_POST['topicID'];
        $voteType = $_POST['voteType'] ?? null;

        if ($voteType && !hasVoted($_SESSION['username'], $topicID)) {
            vote($_SESSION['username'], $topicID, $voteType);
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
            You Already Voted for on this topic.
        </div>
        <h2 id="pageTitle">Topic List</h2>
        <div id="grid-wrapper">
            <?php foreach ($topicList as $topic): ?>

            <?php
                $upVotes = getVoteResults($topic['topicID'])["up"];
                $downVotes = getVoteResults($topic['topicID'])["down"];
                $userVote = null;
                $votes = getUserVotingHistory($_SESSION['username']);
                foreach ($votes as $vote) {
                    if ($vote[0] == $topic['topicID']) {
                        $userVote = $vote[2] === "up"; // "up" or "down"
                        break;
                    }
                }
            ?>
            <div class="eventBox">
                <h2 class="topicTitle"><?= $topic['title'] ?></h2>
                <p>Created By: <?= $topic['creator'] ?></p>
                <p>ID: <?= $topic['topicID'] ?></p>
                <br>
                <p>Description: <?= $topic['description'] ?></p>

                <form method="POST">
                    <input type="hidden" name="topicID" value="<?= $topic['topicID'] ?>">

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