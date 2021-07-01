<?php

    if(isset($_SESSION['currUser'])) {

        $currTime = time();
        $updates = "last_activity = '$currTime'";
        updateUser($updates, $_SESSION['currUser']['username']);
    }
?>