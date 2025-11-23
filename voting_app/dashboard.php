<?php
include "functions.php";
session_start();
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
    <nav>
        <a href="create_topic.php">Create Topic</a>
        <a href="profile.php">My Profile</a>
        <a href="vote.php">Vote Topic</a>
        <form method="POST">
            <button type="submit" name="logout">Log out</button>
            <button type="button" id="themeToggle">Theme</button>
        </form>
    </nav>
</header>
<main>
    <p>This is the dashboard</p>
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
<?php show_source(__FILE__) ?>