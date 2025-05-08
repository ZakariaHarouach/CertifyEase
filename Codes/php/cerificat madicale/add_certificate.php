<?php
session_start();

require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $personCIN = null;

    // Determine the user's role and set the correct CIN
    if (isset($_SESSION['is_prof']) && $_SESSION['is_prof'] === true) {
        // If the user is a prof, use Prof CIN
        $personCIN = $_SESSION['prof_CIN'] ?? null;
    } elseif (isset($_SESSION['student_details']['PersonCIN'])) {
        // If the user is a student, use Student CIN
        $personCIN = $_SESSION['student_details']['PersonCIN'];
    } elseif (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
        // If the user is an admin, use Admin CIN
        $personCIN = $_SESSION['admin_CIN'] ?? null;
    } else {
        // If no valid role is found, throw an error
        echo "Error: User role not recognized.";
        exit();
    }

    $startDate = $_POST['start_date'] ?? null;
    $endDate = $_POST['end_date'] ?? null;
    $photoPath = null;

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

    // Handle file upload
    if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] === UPLOAD_ERR_OK) {
        $fileExtension = strtolower(pathinfo($_FILES['certificate']['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Invalid file type.";
            exit();
        }

        $uploadDir = '../../uploads/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['certificate']['name']);
        $photoPath = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES['certificate']['tmp_name'], $photoPath)) {
            echo "Failed to upload the file.";
            exit();
        }
    } else {
        echo "File upload error: " . $_FILES['certificate']['error'];
        exit();
    }

    // Validate input
    if ($personCIN && $startDate && $endDate) {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=certieasedb", "root", $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insert certificate
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

            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
                header("Location: ../../html/admin/mange_certificat_medicale.php");
            } else {
                header("Location: ../../html/Certificat S-P/cetificat_medical.php");
            }
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Debugging Output:<br>";
        echo "PersonCIN: " . ($personCIN ?? 'Not set') . "<br>";
        echo "StartDate: " . ($startDate ?? 'Not set') . "<br>";
        echo "EndDate: " . ($endDate ?? 'Not set') . "<br>";
        echo "All fields are required.";
        exit();
    }
} else {
    echo "Invalid request.";
}