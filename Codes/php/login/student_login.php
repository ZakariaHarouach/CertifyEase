<?php
session_start();

require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Email and password are required.";
        header("Location: ../../html/student/login_student.html");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['login_error'] = "Invalid email format.";
        header("Location: ../../html/student/login_student.html");
        exit();
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=certieasedb", "root", $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "
            SELECT 
                people.FirstName,
                people.LastName,
                people.mail,
                people.Password,
                student.PersonCIN,
                student.StudentGroup,
                student.NivaueStudent
            FROM people
            INNER JOIN student ON people.CIN = student.PersonCIN
            WHERE people.mail = :email
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password === $user['Password']) {
            // Set session variables
            $_SESSION['email'] = $user['mail']; // Store the user's email
            $_SESSION['first_name'] = $user['FirstName'];
            $_SESSION['last_name'] = $user['LastName'];
            $_SESSION['user_id'] = $user['PersonCIN'];
            $_SESSION['student_details'] = [
                'PersonCIN' => $user['PersonCIN'],
                'StudentGroup' => $user['StudentGroup'],
                'NivaueStudent' => $user['NivaueStudent']
            ];

            $certQuery = "
                SELECT 
                    people.FirstName,
                    people.LastName,
                    student.StudentGroup,
                    certificatesmedical.StartDate,
                    certificatesmedical.EndDate,
                    certificatesmedical.photoPath
                FROM certificatesmedical
                INNER JOIN student ON certificatesmedical.PersonCIN = student.PersonCIN
                INNER JOIN people ON student.PersonCIN = people.CIN
                WHERE certificatesmedical.PersonCIN = :personCIN
            ";
            $certStmt = $pdo->prepare($certQuery);
            $certStmt->execute(['personCIN' => $user['PersonCIN']]);
            $certificates = $certStmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION['certificates'] = $certificates;

            // Redirect to the certificates page
            header("Location: ../../html/Certificat S-P/cetificat_medical.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Email or password is incorrect.";
            header("Location: ../../html/student/login_student.html");
            exit();
        }
    } catch (PDOException $e) {
        echo "Connection error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
