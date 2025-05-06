<?php
session_start();

require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=certieasedb", "root", $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM people WHERE mail = :email AND Password = :password");
        $stmt->execute(['email' => $email, 'password' => $password]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['first_name'] = $user['FirstName'];
            $_SESSION['last_name'] = $user['LastName'];

            header("Location: ../..html/");
            exit();
        } else {
            echo "Email ou mot de passe incorrect.";
        }

    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
} else {
    echo "Méthode non autorisée.";
}
