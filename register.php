<?php

    session_start();

    if(isset($_SESSION['currUser']))
        header('Location: home.php');

    include 'db/fields.php';
    include 'db/sql.php';

    $fields = getFields(['username', 'password']);

    $docTitle = 'Register | ';
    $uniqueUsernameError = '';
    
    if(isset($_POST['submit'])) {

        $isValid = true;
        $userCredentials = '';
        foreach($fields as $field) {
    
            $field -> value = $field -> name == 'password' ? $_POST[$field -> name] : trim($_POST[$field -> name]);
            $userCredentials .= $userCredentials ? ', ' : '';
            $userCredentials .= "'{$field -> value}'";
    
            if(!($field -> validate())) {
                $isValid = false;
            }
        }

        if(getUser($fields['username'] -> value)) {

            $uniqueUsernameError = 'This username has already been taken!';
            $isValid = false;
        }

        if($isValid) {

            if(insertUser($userCredentials))
                header('Location: login.php');
            else
                echo 'Something went wrong!';
        }
    }
?>

<?php include 'templates/header.php'; ?>

    <form action="register.php" method="POST">

        <h1>REGISTRATION</h1>

        <div class="error">
            <?php echo $uniqueUsernameError; ?>
        </div>

        <?php foreach($fields as $field): ?>

            <div class="form-grp">

                <label>
                    <?php echo "{$field -> name} (max: {$field -> maxLen} chars.)"; ?>
                </label>
                
                <input
                    type="<?php echo $field -> type; ?>"
                    name="<?php echo $field -> name; ?>"
                    value="<?php echo $field -> value; ?>"
                    <?php if($field -> name == 'username'): ?>
                        autofocus
                    <?php endif; ?>
                    required
                >

                <div class="error">
                    <?php echo $field -> isError ? $field -> errorMsg : ''; ?>
                </div>

            </div>

        <?php endforeach; ?>

        <div class="form-grp">
            <input type="submit" name="submit" value="Register" />
        </div>

    </form>

<?php include 'templates/footer.php'; ?>