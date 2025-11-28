<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include("functions.php");
    $userNotFound = false;

    $test = authenticateUser('new_user', 'password123') ? "true" : "false";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $password = $_POST["password"];
        if(authenticateUser($username, $password)){
            setSession('username', $username);
            header('Location: profile.php');
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

            display: flex;              /* enables flexbox */
            flex-direction: column;     /* stack items vertically */
            justify-content: center;    /* center vertically */
            align-items: center;        /* center horizontally */
            text-align: center;         /* center text too */
        }
        .form {
            margin-top: 20px;
            color: black;
        }
        p{
            color: black;
        }
        #username, #password{
            margin-bottom: 20px;
            font-size: 25px;
            border-radius: 10px;
        }
        label{
            font-size: 30px;
        }
        #loginBtn{
            border-radius: 12px;

            padding: 20px 40px 20px 40px;
        }
        #loginBtn:hover{
            background-color:#cfcffc;
        }
    </style>
</head>
<body>
    <div>
        <h1 id="title"> Login </h1>
        <form class="form" name="login" action="login.php" method="POST" onsubmit="return formChecker()">
            <label for="username">Username</label>
            <br>
            <input type="text" id="username" name="username"">
            <br>
            <label for="password">Password</label>
            <br>
            <input type="password" id="password" name="password"">
            <br>
            <button id="loginBtn" type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register Here</a></p>
        <p>test: <?=$test?></p><!--TODO review what is this test all about>?-->
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