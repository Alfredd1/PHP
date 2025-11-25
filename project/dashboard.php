
<?php
    include 'nav.php';
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
</head>
<body>

    <main>
        <p>This is the dashboard</p>
    </main>
    <footer>

    </footer>

</body>
</html>
<?php /*show_source(__FILE__) */?>