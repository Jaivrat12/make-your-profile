<?php

    $username = $password = '';
    $errors = ['username' => '', 'password' => ''];

    if(isset($_POST['submit'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Form Validation
        if(!preg_match('/^[a-zA-Z0-9_]{3,}$/', $username)) {
            $errors['username'] = "Username must be atleast 3 characters long & should only contain alphanumerics or underscores";
        }
        if(!preg_match('/^(?=.{6,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/', $password)) {
            $errors['password'] = "Password must be atleast 6 chars long & should contain uppercase, lowercase letters & numbers";
        }

        // INSERT to DB if data is valid
        if(!array_filter($errors)) {

            // Connect to DB
            include 'config/db-connect.php';

            // Create SQL
            $sql = "INSERT INTO users(username, password) VALUES('$username', '$password')";

            // Save to DB & check for success
            $stmt = $pdo->prepare($sql);
            if($stmt->execute()) {

                header('Location: home.php');
            }
            else {

                echo 'Something went wrong!';
            }
        }
    }
?>

<?php include 'templates/header.php'; ?>
    <form action="register.php" method="POST">
        <h1>REGISTRATION</h1>
        <div class="form-grp">
            <label>Username</label>
            <input
                type="text" name="username"
                placeholder="Username"
                autofocus required
                value= "<?php echo htmlspecialchars($username); ?>"
            >
            <div class="error">
                <?php echo $errors['username'] ?>
            </div>
        </div>
        <div class="form-grp">
            <label>Password</label>
            <input
                type="password" name="password"
                placeholder="Password"
                required
                value= "<?php echo htmlspecialchars($password); ?>"
            >
            <div class="error">
                <?php echo $errors['password'] ?>
            </div>
        </div>
        <div class="form-grp">
            <input
                type="submit" name="submit"
                value="Register"
            >
        </div>
    </form>
<?php include 'templates/footer.php'; ?>