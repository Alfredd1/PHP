<?php
    require_once "classes.php";
    $pdo = new PDO(
        "mysql:host=localhost;dbname=s5571963_tables;charset=utf8",
        "s5571963_AlfredNavarro", "1234alfred", [PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION]
        );
    $userReference = new User($pdo);
    $registered = false;
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $email = trim($_POST['email']);
            if ($userReference->registerUser($username, $email, $password)) {
                header('Location: login.php');
                exit;
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
        #username, #password, #email{
            margin-bottom: 20px;
            font-size: 25px;
            border-radius: 10px;
        }
        label{
            font-size: 30px;
        }
        #registerBtn{
            border-radius: 12px;

            padding: 20px 40px 20px 40px;
        }
        #registerBtn:hover{
            background-color:#cfcffc;
        }

    </style>
</head>

<body>
    <div>
    <h1 id="title">Register</h1>
        <form class="form" name="registration" action="register.php" method="POST" onsubmit="return formChecker()">
            <label for="username">Username</label>
            <br>
            <input type="text" id="username" name="username"">
            <br>
            <label for="email">Email</label>
            <br>
            <input type="email" id="email" name="email"">
            <br>
            <label for="password">Password</label>
            <br>
            <input type="password" id="password" name="password"">
            <br>
            <button id="registerBtn" type="submit">Register</button>
        </form>
    </div>

    <script>
        function formChecker(){
            let username = document.forms["registration"]["username"].value.trim();
            let password = document.forms["registration"]["password"].value;
            let email = document.forms["registration"]["email"].trim();

            if(username === "" || password === "" || email === ""){
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
<?php /*show_source(__FILE__) */?>