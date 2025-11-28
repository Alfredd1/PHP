
<?php
    include "functions.php";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    header("Location: login.php"); // instantly redirects to login ( this is for the server )
    exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Redirection page</title>
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