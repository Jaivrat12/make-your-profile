<?php

    session_start();
    include 'db/sql.php';
    include 'db/user-activity.php';
    session_unset();
    session_destroy();

    header('Location: home.php');
?>