<?php

    /*
        MAINTAIN SECURED SESSIONS BY:
        1. Session ID should be server generated [unchangeable cookie?]
        2. Regenerate session ID after login and some major activities
        3. Set timeout/expire old sessions
    */

    session_start();

    $currUser = $_SESSION['currUser'] ?? null;
    // print_r($currUser);

    include 'config/db-connect.php';

    $stmt = $pdo -> query('SELECT * FROM users ORDER BY id');
    $users = $stmt -> fetchAll(\PDO::FETCH_ASSOC);
    // print_r($users);
?>

<?php include 'templates/header.php' ?>

    <h1 class="home-heading">Registered Users</h1>

    <div class="users">
        <?php foreach($users as $user): ?>
            <?php $name = htmlspecialchars($user['name'] ?? $user['username']); ?>
            <a href=<?php echo "profile.php?user=" . htmlspecialchars($user['username']); ?>
               class="user" title="<?php echo $name; ?>"
            >
                <div class="profile-pic">
                    <?php echo strtoupper($name[0]); ?>
                </div>
                <div class="profile-info">
                    <span class="name">
                        <?php echo $name; ?>
                    </span>
                    <span class="username">
                        <?php echo '@' . htmlspecialchars($user['username']); ?>
                    </span>
                    <div class="roles">
                        <?php if($user['is_admin']): ?>
                            <span class="role role-admin">Admin</span>
                            <span class="role role-god">God</span>
                        <?php else: ?>
                            <span class="role">User</span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

<?php include 'templates/footer.php' ?>