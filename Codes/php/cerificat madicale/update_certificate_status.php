<?php
session_start();

require_once '../../includes/db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    http_response_code(403); // Forbidden
    echo "Unauthorized access.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $certificateId = $_POST['certificate_id'] ?? null;
    $status = $_POST['status'] ?? null;

    if ($certificateId && ($status == 1 || $status == 2)) {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=certieasedb", "root", $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "
                UPDATE certificatesmedical
                SET Status = :status
                WHERE MdCerID = :certificateId
            ";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'status' => $status,
                'certificateId' => $certificateId
            ]);

            echo "Certificate status updated successfully.";
        } catch (PDOException $e) {
            http_response_code(500);
            echo "Error: " . $e->getMessage();
        }
    } else {
        http_response_code(400);
        echo "Invalid request.";
    }
} else {
    http_response_code(405);
    echo "Invalid request method.";
}