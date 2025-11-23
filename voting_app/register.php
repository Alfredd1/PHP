<?php
    $registered = false;
    include("functions.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (registerUser($username, $password)) {
                header('Location: login.php');
            } else {
                $registered = true;
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        div {
            width: 500px;
            height: 500px;
            margin: 4em auto;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 10px;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 1em;
        }
    </style>
</head>
<body>
<div>
    <form name="registration" action="register.php" method="POST" onsubmit="return formChecker()">
        <label for="username">Username:&nbsp;</label>
        <input type="text" id="username" name="username"">
        <br>
        <label for="password">Password:&nbsp;</label>
        <input type="password" id="password" name="password"">
        <br>
        <button type="submit">Register</button>
    </form>
</div>
<script>
    function formChecker(){
        let username = document.forms["registration"]["username"].value.trim();
        let password = document.forms["registration"]["password"].value;

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
</script>
</body>
</html>
<?php show_source(__FILE__) ?>