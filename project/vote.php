<?php include 'nav.php'; ?>
<?php
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
    <style>
        body {
            background-color: #ffffff;
            color: #000000;
            transition: background-color 0.3s, color 0.3s;
        }
        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }
    </style>
</head>
<body class="<?php echo $theme === 'dark' ? 'dark-mode' : ''; ?>">
<header>
    <!--<nav>
        <a href="create_topic.php">Create Topic</a>
        <a href="profile.php">My Profile</a>
        <a href="vote.php">Vote Topic</a>
        <form method="POST">
            <button type="submit" name="logout">Log out</button>
            <button type="button" id="themeToggle">Theme</button>
        </form>
    </nav>-->
</header>
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
<script>
    const themeToggle = document.getElementById("themeToggle");
    themeToggle.addEventListener('click', async ()=>{
        const isDark = document.body.classList.toggle('dark-mode');
        const theme = isDark ? 'dark' : 'light';

        await fetch('', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'theme=' + theme
        });
    });
</script>
</body>
</html>

<?php /*show_source(__FILE__) */?>