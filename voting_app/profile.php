<?php
include 'nav.php';

session_start();
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

$votes = getUserVotingHistory($_SESSION['username']);
$topics = getTopics();

$totalTopicsCreated = getTotalTopicsCreated($_SESSION['username']);
$totalVotesCast = getTotalVotesCast($_SESSION['username']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>

</head>

<body>

    <main>
        <h2>Voting History: </h2>
        <?php foreach($votes as $vote): ?>
            <?php foreach($topics as $topic): ?>
                <?php if ($topic['topicID'] === $vote[0]): ?>
                    <p>Title: <?= $topic['title'] ?></p>
                    <p>Vote: <?= $vote[2]?></p>
                <?php endif ?>
            <?php endforeach ?>
        <?php endforeach ?>
        <p>Total Votes: <?= $totalVotesCast ?></p>
        <p>Total Topics Created: <?= $totalTopicsCreated ?></p>
    </main>

    <footer>

    </footer>
</body>
</html>
<?php /*show_source(__FILE__) */?>