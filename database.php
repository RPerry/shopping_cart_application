<?php
    $dsn = 'mysql:host=localhost;dbname=shopping_cart';
    $username = 'shopuser';
    $password = 'shopsecret';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }
?>