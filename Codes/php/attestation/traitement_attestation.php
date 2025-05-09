<?php
session_start();

require_once '../../php/includes/db.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['student_details'])) {
    header("Location: ../../html/student/login_student.html");
    exit();
}

$studentCIN = $_SESSION['student_details']['PersonCIN'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $demandDate = date('Y-m-d');

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=certieasedb", "root", $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "
            SELECT DemendDate
            FROM demend
            WHERE StudentCIN = :studentCIN
            ORDER BY DemendDate DESC
            LIMIT 1
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['studentCIN' => $studentCIN]);
        $lastDemand = $stmt->fetch(PDO::FETCH_ASSOC);

        // if ($lastDemand) {
        //     $lastDemandDate = new DateTime($lastDemand['DemendDate']);
        //     $currentDate = new DateTime($demandDate);
        //     $interval = $lastDemandDate->diff($currentDate);

        //     if ($interval->m < 3 && $interval->y == 0) {
        //         echo "You can only submit a new demand every 3 months. Your last demand was on " . $lastDemandDate->format('Y-m-d') . ".<br>";
        //         exit();
        //     }
        // }

        $query = "
            INSERT INTO demend (StudentCIN, DemendStatus, DemendDate)
            VALUES (:studentCIN, 'pending', :demendDate)
        ";
        $stmt = $pdo->prepare($query);

        $stmt->execute([
            'studentCIN' => $studentCIN,
            'demendDate' => $demandDate
        ]);

        header("Location: ../../html/Certificat S-P/attestation.php");
        exit();
    } catch (PDOException $e) {
        echo "Error during insertion: " . $e->getMessage() . "<br>";
    }
}

try {
    $query = "
        SELECT demend.DemendID, demend.DemendStatus, demend.DemendDate, student.StudentGroup, people.FirstName, people.LastName
        FROM demend
        INNER JOIN student ON demend.StudentCIN = student.PersonCIN
        INNER JOIN people ON student.PersonCIN = people.CIN
        WHERE demend.StudentCIN = :studentCIN
        ORDER BY demend.DemendDate DESC
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['studentCIN' => $studentCIN]);
    $demands = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error during fetch: " . $e->getMessage() . "<br>";
    exit();
}