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
        <div>
            <h2 id="title">Create a topic!</h2>
            <form action="create_topic.php" method="POST">

                <label >title </label>
                <br>
                <input type="text" name="title" value="">

                <br>

                <label>description </label>
                <br>
                <input type="text" name="description" value="">

                <br>

                <button id="create" type="submit">Create Topic</button>
            </form>
        </div>
    </main>
    <footer>

    </footer>

</body>
</html>

    <style>
        #title{
            color: black;
            font-size: 60px;
        }
        div {
            width: 500px;
            height: 500px;
            margin: 4em auto;
            background-color: #E6E6FA;
            border: 1px solid #ccc;
            border-radius: 10px;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        form {
            margin-top: 20px;
            color: black;
        }
        p{
            color: black;
        }
        input{
            margin-bottom: 20px;
            font-size: 25px;
            border-radius: 10px;
        }
        label{
            font-size: 30px;
        }
        #create{
            border-radius: 12px;

            padding: 20px 40px 20px 40px;
        }
        #create:hover{
            background-color:#cfcffc;
        }

    </style>
<?php /*show_source(__FILE__) */?>