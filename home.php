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

    <div class="users">
        <?php foreach($users as $user): ?>
            <div class="user">
                <?php echo htmlspecialchars($user['username']); ?>
                <?php if($user['is_admin']): ?>
                    <span>Admin</span>
                <?php endif; ?>
                <?php echo htmlspecialchars($user['created_at']); ?>
            </div>
        <?php endforeach; ?>
    </div>

<?php include 'templates/footer.php' ?>