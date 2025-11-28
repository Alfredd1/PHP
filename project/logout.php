<?php
    include("functions.php");

    if (isset($_GET['confirm']) && $_GET['confirm'] === '1') {
        logOut();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Logout</title>
    <style>
        /* Full-page overlay */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: rgba(0,0,0,0.5);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* The confirmation box */
        .confirm-box {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 400px;
        }

        .confirm-box h2 {
            margin-bottom: 20px;
        }

        .confirm-box a {
            display: inline-block;
            margin: 10px;
            padding: 10px 25px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            color: #fff;
            transition: background 0.3s;
        }

        .confirm-box a.logout {
            background-color: #e74c3c;
        }

        .confirm-box a.logout:hover {
            background-color: #c0392b;
        }

        .confirm-box a.cancel {
            background-color: #3498db;
        }

        .confirm-box a.cancel:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="confirm-box">
    <h2>Are you sure you want to log out?</h2>
    <a class="logout" href="logout.php?confirm=1">Yes, log out</a>
    <a class="cancel" href="profile.php">Cancel</a>
</div>

</body>
</html>
