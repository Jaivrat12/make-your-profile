<?php

    include 'db-connect.php';

    function encodeSpecialChars($str) {

        return str_replace("'", "&#039;", htmlspecialchars($str));
    }

    function getUser($username, $password = null) {

        global $pdo;

        $sql = "SELECT * FROM users WHERE LOWER(username) = LOWER('$username')";
        $sql .= $password ? "AND  password = '$password';" : ';';
        $stmt = $pdo -> query($sql);
        return $stmt -> fetch(\PDO::FETCH_ASSOC);
    }

    function insertUser($userCredentials) {

        global $pdo;

        $sql = "INSERT INTO users(username, password) VALUES($userCredentials)";
        $stmt = $pdo->prepare($sql);
        return $stmt -> execute();
    }

    function updateUser($updates, $username) {

        global $pdo;

        $sql = "UPDATE users SET $updates WHERE LOWER(username) = LOWER('$username');";
        $stmt = $pdo -> prepare($sql);
        return $stmt -> execute();
    }

    function deleteUser($username) {

        global $pdo;

        $sql = "DELETE FROM users WHERE LOWER(username) = LOWER('$username');";
        $stmt = $pdo -> prepare($sql);
        return $stmt -> execute();
    }
?>