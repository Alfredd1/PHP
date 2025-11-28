<?php
    include 'nav.php';
    ///TODO Implement Vote Count
    /// TODO design UI
    session_start();
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
        <h2 id="pageTitle">Topic List</h2>
        <div id="grid-wrapper">
            <?php foreach ($topicList as $topic): ?>

            <div class="eventBox">
                <h2 class="topicTitle"><?= $topic['title'] ?></h2>
                <p>Created By: <?= $topic['creator'] ?></p>
                <p>ID: <?= $topic['topicID'] ?></p>
                <br>
                <p>Description: <?= $topic['description'] ?></p>

                <form method="POST">
                    <input type="hidden" name="topicID" value="<?= $topic['topicID'] ?>">
                    <button type="submit" name="voteType" value="up" class="upvoteBtn" ><?= getVoteResults($topic['topicID'])["up"] ?> <br>  Upvote</button>
                    <button type="submit" name="voteType" value="down" class="downvoteBtn" ><?= getVoteResults($topic['topicID'])["down"] ?> <br>  Downvote</button>

                </form>
            </div>

            <?php endforeach; ?>

            <?php if ($voted): ?>
                <p>You have already voted!</p>
            <?php endif ?>
        </div>

    </main>

    <footer>

    </footer>

</body>

</html>


<style>
    #pageTitle{
        text-align: center;
        font-size: 70px;
    }
    .eventBox{
        background-color: #E6E6FA;
        border: black 2px solid;
        border-radius: 5px;

        width: 308px;

        padding: 10px;
        margin-bottom: 15px;
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
    #grid-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fit, 308px);
        gap: 40px;
        justify-content: center; /* Center the whole grid */
    }

</style>


<script>


</script>

<?php /*show_source(__FILE__) */?>