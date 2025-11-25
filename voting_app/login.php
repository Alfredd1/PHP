<?php //TODO transfer the log in and everything into the index/dashboard
    include 'nav.php';
    session_start();
    include("functions.php");
    $userNotFound = false;

    $test = authenticateUser('new_user', 'password123') ? "true" : "false";

    if($_SERVER["REQUEST_METHOD"] == "POST"){ //TODO
        $username = $_POST["username"];
        $password = $_POST["password"];
        if(authenticateUser($username, $password)){
            setSession('username', $username);
            header('Location: dashboard.php');
        } else {
            $userNotFound = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Log-in Page</title>
    <style>
        div {
            width: 500px;
            height: 500px;
            margin: 4em auto;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .form {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div>
        <form class="form" name="login" action="login.php" method="POST" onsubmit="return formChecker()">
            <label for="username">Username:&nbsp;</label>
            <input type="text" id="username" name="username"">
            <br>
            <label for="password">Password:&nbsp;</label>
            <input type="password" id="password" name="password"">
            <br>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register Here</a></p>
        <p>test: <?=$test?></p>
    </div>

    <script>
        function formChecker(){
            let username = document.forms["login"]["username"].value.trim();
            let password = document.forms["login"]["password"].value;

            if(username === "" || password === ""){
                alert("Please fill out the log in fields");
                return false;
            }
            if (password.length < 5){
                alert("Password must be greater than 5");
                return false;
            }
            return true;


        }
        <?php if ($userNotFound): ?>
        alert("Incorrect username or password");
        <?php endif ?>
    </script>
</body>
</html>
<?php /*show_source(__FILE__) */?>