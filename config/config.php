<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');     // Default MAMP username
define('DB_PASS', 'root');     // Default MAMP password
define('DB_NAME', 'suit_db');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}