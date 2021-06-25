<?php

    $isLoggedIn = isset($_SESSION['currUser']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="style.css">

        <title>User Login System</title>
    </head>
    <body>
        <nav>
            <div class="title">User Login System</div>
            <div>
                <?php if($isLoggedIn): ?>
                    <!-- <div>Hello, User</div> -->
                    <a href="logout.php">LOGOUT</a>
                <?php else: ?>
                    <a href="login.php">LOGIN</a>
                <?php endif; ?>
            </div>
        </nav>