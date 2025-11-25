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
        <h2>Topic List</h2>
        <?php foreach ($topicList as $topic): ?>

        <p><?= $topic['topicID'] ?> | <?= $topic['creator'] ?> | <?= $topic['title'] ?> | <?= $topic['description'] ?> </p>
        <form method="POST">
            <input type="hidden" name="topicID" value="<?= $topic['topicID'] ?>">
            <button type="submit" name="voteType" value="up">Upvote</button>
            <button type="submit" name="voteType" value="down">Downvote</button>
            <p><?= print_r(getVoteResults($topic['topicID']), true) ?></p>
        </form>

        <?php endforeach; ?>

        <?php if ($voted): ?>
            <p>You have already voted!</p>
        <?php endif ?>

    </main>
    <footer>

    </footer>

</body>

</html>

<?php /*show_source(__FILE__) */?>