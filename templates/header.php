<?php $currUser = $_SESSION['currUser'] ?? null; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/home.css">
        <link rel="stylesheet" href="styles/forms.css">
        <link rel="stylesheet" href="styles/profile.css">

        <title>
            <?php echo ($docTitle ?? '') . 'Make Your Profile'; ?>
        </title>
    </head>
    <body>
        <nav>
            <a href="home.php" class="header-title">Make Your Profile</a>
            <?php if($currUser): ?>
                <a href="<?php echo "profile.php?user={$currUser['username']}"; ?>">
                    <div class="profile-pic">
                        <?php echo strtoupper(($currUser['name'] ?? $currUser['username'])[0]); ?>
                    </div>
                </a>
            <?php else: ?>
                <a class="link-btn" href="login.php">LOGIN</a>
            <?php endif; ?>
        </nav>