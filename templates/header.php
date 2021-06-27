<?php

    $isLoggedIn = isset($_SESSION['currUser']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">

        <title>
            <?php echo ($docTitle ?? '') . 'Make Your Profile'; ?>
        </title>
    </head>
    <body>
        <nav>
            <a href="home.php" class="header-title">Make Your Profile</a>
            <div>
                <?php if($isLoggedIn): ?>
                    <!-- <div>Hello, User</div> -->
                    <a class="link-btn" href="logout.php">LOGOUT</a>
                <?php else: ?>
                    <a class="link-btn" href="login.php">LOGIN</a>
                <?php endif; ?>
            </div>
        </nav>