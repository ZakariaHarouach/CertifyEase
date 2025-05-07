<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login_admin.html"); // Redirect to the admin login page
    exit();
}

require_once '../../php/includes/db.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=certieasedb", "root", $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $searchQuery = $_GET['searchQuery'] ?? '';

    $query = "
        SELECT 
            certificatesmedical.MdCerID,
            certificatesmedical.StartDate,
            certificatesmedical.EndDate,
            certificatesmedical.CertificatStatus,
            certificatesmedical.photoPath,
            people.CIN,
            people.FirstName,
            people.LastName,
            student.StudentGroup
        FROM certificatesmedical
        INNER JOIN people ON certificatesmedical.PersonCIN = people.CIN
        INNER JOIN student ON student.PersonCIN = people.CIN
        WHERE certificatesmedical.CertificatStatus = 'pending'
    ";

    if (!empty($searchQuery)) {
        $query .= " AND people.CIN LIKE :searchQuery";
    }

    $stmt = $pdo->prepare($query);

    if (!empty($searchQuery)) {
        $stmt->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
    }

    $stmt->execute();
    $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

