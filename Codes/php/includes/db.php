<?php
$host = 'localhost';
$db = 'certieasedb';
$user = 'root';
$pass = 'mysql';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, 'Adam123.123$');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
