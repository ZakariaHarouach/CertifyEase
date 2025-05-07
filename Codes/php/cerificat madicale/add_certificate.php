<?php
session_start();

require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // from data
    $personCIN = $_SESSION['student_details']['PersonCIN'] ?? null;
    $startDate = $_POST['start_date'] ?? null;
    $endDate = $_POST['end_date'] ?? null;
    $photoPath = null;

    // aextensions allowed
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

    // handling the file
    if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../uploads/';
        
        // directory exixt
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['certificate']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Extensions
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Invalid file type. Only JPG, JPEG, PNG, and PDF files are allowed.";
            exit();
        }

        // set he path dyal file
        $photoPath = $uploadDir . $fileName;

        // go to the file uploded
        if (!move_uploaded_file($_FILES['certificate']['tmp_name'], $photoPath)) {
            echo "Failed to upload the file.";
            exit();
        }
    }

    // Validate input
    if ($personCIN && $startDate && $endDate) {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=certieasedb", "root", $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // incert certi
            $query = "
                INSERT INTO certificatesmedical (PersonCIN, StartDate, EndDate, photoPath, CertificatStatus)
                VALUES (:personCIN, :startDate, :endDate, :photoPath, 'pending')
            ";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'personCIN' => $personCIN,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'photoPath' => $photoPath
            ]);

            // Redirect back to the page certificate 
            header("Location: ../../html/Certificat S-P/cetificat_medical.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request.";
}