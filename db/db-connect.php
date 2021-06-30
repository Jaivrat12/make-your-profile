<?php
    
    require 'vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable('.');
    $dotenv -> safeLoad();

    try {

        // Create a pdo instance
        $pdo = (function() {

            $parts = (parse_url(getenv('DATABASE_URL')));
            extract($parts);
            $path = ltrim($path, "/");
            return new PDO("pgsql:host={$host};port={$port};dbname={$path}", $user, $pass);
        })();
        $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {

        echo 'Connection failed: ' . $e -> getMessage();
    }
?>