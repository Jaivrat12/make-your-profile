<?php
    
    include 'config/db-connect.php';

    $stmt = $pdo -> query('SELECT * FROM users ORDER BY id');
    $users = $stmt -> fetchAll(\PDO::FETCH_ASSOC);

    print_r($users);
?>