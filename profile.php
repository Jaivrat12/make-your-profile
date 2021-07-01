<?php

    session_start();

    if(!isset($_GET['user']))
        header('Location: home.php');

    include 'db/sql.php';
    include 'db/user-activity.php';

    // Refresh Current User Data
    if(isset($_SESSION['currUser']))
        $_SESSION['currUser'] = getUser($_SESSION['currUser']['username']);

    $username = $_GET['user'];
    $docTitle = "Profile - $username | ";
    $user = getUser($username);
    if($user) $name = $user['name'] ?? $user['username'];

    $sameUser = false;
    $adminView = false;
    if(isset($_SESSION['currUser'])) {

        $sameUser = $_SESSION['currUser']['username'] == $user['username'];
        $adminView = $_SESSION['currUser']['is_admin'];
    }

    $currTime = time();
    $details = ['age', 'gender', 'email', 'location', 'joined'];

    if(isset($_POST['delete'])) {

        if($sameUser || $adminView) {

            if(deleteUser($username)) {

                if($sameUser) header('Location: logout.php');
                else header('Location: home.php');
            }
            else echo 'Something went wrong!';
        }
        else {

            echo "You're NOT authourized to Delete this User!";
            exit();
        }
    }
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
                        <?php echo '@' . $user['username']; ?>
                    </div>
                </div>
                <div class="roles-and-status">
                    <div class="status">
                        <?php if($currTime - $user['last_activity'] < 60 * 5): ?>
                            <span class="online">online</span>
                        <?php else: ?>
                            <span class="offline">offline</span>
                        <?php endif; ?>
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
            </div>

            <?php if($sameUser || $adminView): ?>

                <div class="control-panel">
                    <h3>Control Panel</h3>
                    <div class="audit">
                        
                        <?php if($sameUser): ?>
                            <form action="edit-profile.php" method="POST">
                                <input type="submit" name="edit" value="Edit">
                            </form>
                            <form action="logout.php">
                                <input type="submit" name="logout" value="Logout">
                            </form>
                        <?php endif; ?>

                        <form
                            action="<?php echo "profile.php?user={$user['username']}"; ?>"
                            method="POST"
                        >
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </div>
                </div>

            <?php endif; ?>

            <div class="about">
                <h3>About</h3>
                <p><?php echo $user['about']; ?></p>
            </div>

            <div class="details-wrapper">
                <h3>Details</h3>
                <?php if($adminView || $sameUser || $user['is_public']): ?>

                    <?php foreach($details as $detail): ?>

                        <div>
                            <span class="detail-heading">
                                <?php echo $detail . ': '; ?>
                            </span>
                            <span class="detail-value">
                                <?php echo $user[$detail]; ?>
                            </span>
                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <em>Details of this user are private</em>

                <?php endif; ?>
            </div>

        </div>

    <?php else: ?>

        <h3>No such User exists!</h3>

    <?php endif; ?>

<?php include 'templates/footer.php'; ?>