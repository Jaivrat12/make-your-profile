<?php

    session_start();

    if(!isset($_SESSION['currUser']))
        header('Location: home.php');

    include 'db/fields.php';
    include 'db/sql.php';
    include 'db/user-activity.php';

    // Refresh Current User Data
    $_SESSION['currUser'] = getUser($_SESSION['currUser']['username']);

    $fields = getAllFields();

    $user = $_SESSION['currUser'];
    $docTitle = "Edit Profile - {$user['username']} | ";
    $uniqueUsernameError = '';
    $isPublic = $user['is_public'];

    if(isset($_POST['submit'])) {

        if($_POST['submit'] == 'Cancel')
            header("Location: profile.php?user={$user['username']}");

        $isValid = true;
        $updates = '';
        foreach($fields as $field) {

            $field -> value = encodeSpecialChars($field -> name == 'password' ? $_POST[$field -> name] : trim($_POST[$field -> name]));
            $updates .= "{$field -> name} = ";
            $updates .= ($field -> value ? "'{$field -> value}'" : 'null') . ', ';

            if($field -> value && !($field -> validate())) {
                $isValid = false;
            }
        }
        $isPublic = isset($_POST['is_public']) ? 'true' : 'false';
        $updates .= "is_public = $isPublic";

        $newUsername = $user['username'];
        if($fields['username'] -> value != $user['username']) {

            $newUsername = $fields['username'] -> value;
            if(getUser($newUsername)) {

                $uniqueUsernameError = 'This username has already been taken!';
                $isValid = false;
            }
        }

        if($isValid) {

            if(updateUser($updates, $newUsername)) {

                $_SESSION['currUser'] = getUser($fields['username'] -> value);
                header("Location: profile.php?user=$newUsername");
            }
            else echo 'Something went wrong!';
        }
    }
?>

<?php include 'templates/header.php'; ?>

    <form action="edit-profile.php" method="post">
        <h1>Edit Profile</h1>

        <div class="error">
            <?php echo $uniqueUsernameError; ?>
        </div>

        <?php foreach($fields as $field): ?>

            <div class="form-grp">

                <label>
                    <?php 
                        echo $field -> name;
                        if($field -> name != 'age')
                            echo " (max: {$field -> maxLen} chars.)";
                    ?>
                </label>
                
                <?php if($field -> name == 'about'): ?>
                    <textarea name="about" rows="5"><?php echo $field -> value ?? $user[$field -> name]; ?></textarea>
                <?php else: ?>
                    <input
                        type="<?php echo $field -> type; ?>"
                        name="<?php echo $field -> name; ?>"
                        value="<?php echo $field -> value ?? $user[$field -> name]; ?>"
                        <?php if($field -> name == 'username' || $field -> name == 'password'): ?>
                            required
                        <?php endif; ?>
                    >
                <?php endif; ?>

                <div class="error">
                    <?php if($field -> isError) echo $field -> errorMsg; ?>
                </div>

            </div>

        <?php endforeach; ?>

        <div style="margin-top: 1rem;">
            <input
                type="checkbox" name="is_public"
                <?php if($isPublic == 'true'): ?>
                    checked
                <?php endif; ?>
            >
            <label>Keep my Details Public</label>
        </div>

        <div class="form-grp multi-submit">
            <input type="submit" name="submit" value="Save">
            <input type="submit" name="submit" value="Cancel">
        </div>
    </form>

<?php include 'templates/footer.php'; ?>