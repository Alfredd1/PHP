<?php
    include 'nav.php';
    include "functions.php";
    session_start();
    if (isset($_POST['theme'])) {
        setTheme();
        exit;
    }
    $theme = $_COOKIE['theme'] ?? 'light';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['logout'])){
            logOut();
        }
        if(isset($_POST["title"]) && isset($_POST["description"])){
            if(createTopic($_SESSION['username'], $_POST["title"], $_POST["description"])){
                header("Location: vote.php");
            };
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
        <h2>Create a topic!</h2>
        <form action="create_topic.php" method="POST">
            <label>
                <input type="text" name="title" value="">
            </label>
            <label>
                <input type="text" name="description" value="">
            </label>
            <button type="submit">Submit</button>
        </form>
    </main>
    <footer>

    </footer>

</body>
</html>
<?php /*show_source(__FILE__) */?>