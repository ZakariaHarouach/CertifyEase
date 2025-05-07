<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=certieasedb", "root", $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "
            SELECT * FROM people
            WHERE mail = :mail AND Password = :password
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['mail' => $email, 'password' => $password]);

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $_SESSION['is_admin'] = true;
            $_SESSION['admin_FirstName'] = $admin['FirstName'];
            $_SESSION['admin_LastName'] = $admin['LastName'];

            header("Location: ../../html/admin/choix-fonctionement.html");
            exit();
        } else {
            echo "Invalid email or password.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Connection error: " . $e->getMessage();
        exit();
    }
}
