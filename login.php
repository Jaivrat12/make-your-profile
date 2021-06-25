<?php

    $username = $password = $error = '';

    if(isset($_POST['submit'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Connect to DB
        include 'config/db-connect.php';

        // Create SQL
        $sql = "SELECT * FROM users
                WHERE LOWER(username) = LOWER('$username') AND password = '$password';";
        $stmt = $pdo -> query($sql);
        $currUser = $stmt -> fetch(\PDO::FETCH_ASSOC);

        // print_r($user);

        if($currUser) {

            echo "Welcome, {$currUser['username']}!";
            session_start();
            $_SESSION['currUser'] = $currUser;
            header('Location: home.php');
        }
        else {

            $error = "Invalid Credentials!";
        }

        // // Create SQL
        // $stmt = $pdo -> query("SELECT username, password FROM users");
        // $credentials = $stmt -> fetchAll(\PDO::FETCH_ASSOC);
        
        // // Credentials Validation
        // $errors = [
        //     'username' => 'No such username exists!',
        //     'password' => 'Wrong Password!'
        // ];
        // foreach ($credentials as $credential) {

        //     if(!strcasecmp($username, $credential['username'])) {

        //         $errors['username'] = '';
        //         echo "<br>$password, {$credential['password']}<br>";
        //         echo $password === $credential['password'];
        //         if($password === $credential['password']) {

        //             $errors['password'] = '';
        //             echo "You're now logged in!";
        //         }
        //     }
        // }
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
                value= "<?php echo htmlspecialchars($username); ?>"
            >
        </div>
        <div class="form-grp">
            <label>Password</label>
            <input
                type="password" name="password"
                placeholder="Password"
                required
            >
        </div>
        <div class="form-grp">
            <input
                type="submit" name="submit"
                value="Login"
            >
        </div>
        <hr>
        <div class="no-account">
            Don't have an account? <a href="register.php">Register Here!</a>
        </div>
    </form>
<?php include 'templates/footer.php'; ?>