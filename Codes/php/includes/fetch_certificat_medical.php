<?php
session_start();

require_once 'db.php'; 

if (!isset($_SESSION['email']) || !isset($_SESSION['first_name'])) {
    header("Location: ../../html/student/login_student.html"); // Redirect to the login page
    exit();
}

$email = $_SESSION['email'];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=certieasedb", "root", $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $certQuery = "
        SELECT 
            certificatesmedical.MdCerID,
            certificatesmedical.StartDate,
            certificatesmedical.EndDate,
            certificatesmedical.CertificatStatus,
            certificatesmedical.photoPath,
            people.FirstName,
            people.LastName,
            student.StudentGroup
        FROM certificatesmedical
        INNER JOIN people ON certificatesmedical.PersonCIN = people.CIN
        INNER JOIN student ON student.PersonCIN = people.CIN
        WHERE people.mail = :email
    ";

    $certStmt = $pdo->prepare($certQuery);
    $certStmt->execute(['email' => $email]);
    $certificates = $certStmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}