<?php

    session_start();

    if(!isset($_GET['user'])) {

        header('Location: home.php');
    }
    
    $username = $_GET['user'];

    $docTitle = "Profile - $username | ";

    include 'config/db-connect.php';
    $stmt = $pdo -> query("SELECT * FROM users WHERE username = '$username'");
    $user = $stmt -> fetch(\PDO::FETCH_ASSOC);

    if($user)
        $name = htmlspecialchars($user['name'] ?? $user['username']);
    
    $details = ['age', 'gender', 'email', 'location'];
?>

<?php include 'templates/header.php'; ?>

    <?php if($user): ?>

        <div class="container">

            <div class="profile-pic-wrapper">
                <div class="hero-img"></div>
                <div class="profile-info-wrapper">
                    <div class="profile-pic">
                        <?php echo strtoupper($name[0]); ?>
                    </div>
                    <h1 class="profile-name">
                        <?php echo $name; ?>
                    </h1>
                    <div class="username">
                        <?php echo '@' . htmlspecialchars($user['username']); ?>
                    </div>
                </div>
                <div class="roles">
                    <?php if($user['is_admin']): ?>
                        <span class="role role-admin">Admin</span>
                        <span class="role role-god">God</span>
                    <?php else: ?>
                        <span class="role">User</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="about">
                <h3>About</h3>
                <p><?php echo htmlspecialchars($user['about']); ?></p>
            </div>

            <div class="details-wrapper">

                <h3>Details</h3>

                <?php foreach($details as $detail): ?>

                    <div>
                        <span class="detail-heading">
                            <?php echo $detail . ': '; ?>
                        </span>
                        <span class="detail-value">
                            <?php echo htmlspecialchars($user[$detail]); ?>
                        </span>
                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    <?php else: ?>

        <h3>No such User exists!</h3>

    <?php endif; ?>

<?php include 'templates/footer.php'; ?>