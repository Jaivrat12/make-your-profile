<?php

    session_start();

    if(isset($_SESSION['currUser']))
        header('Location: home.php');

    include 'db/sql.php';

    $docTitle = 'Login | ';
    $username = $password = $error = '';

    if(isset($_POST['submit'])) {

        $username = htmlspecialchars(trim($_POST['username']));
        $password = $_POST['password'];

        $currUser = getUser($username, $password);
        if($currUser) {

            $_SESSION['currUser'] = $currUser;
            header('Location: home.php');
        }
        else {

            $error = "Invalid Credentials!";
        }
    }
?>

<?php include 'templates/header.php'; ?>

    <form action="login.php" method="POST">

        <h1>LOGIN</h1>

        <div class="error">
            <?php echo $error; ?>
        </div>

        <div class="form-grp">
            <label>Username</label>
            <input
                type="text" name="username"
                placeholder="Username"
                autofocus required
                value= "<?php echo $username; ?>"
            >
        </div>
        <div class="form-grp">
            <label>Password</label>
            <input
                type="password" name="password"
                placeholder="Password" required
            >
        </div>
        <div class="form-grp">
            <input type="submit" name="submit" value="Login" />
        </div>

        <hr>
        <div class="no-account">
            Don't have an account? <a href="register.php">Register Here!</a>
        </div>

    </form>

<?php include 'templates/footer.php'; ?>