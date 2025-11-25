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