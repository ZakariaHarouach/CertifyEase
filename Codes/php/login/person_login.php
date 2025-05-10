<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $loginSource = trim($_POST['login_source'] ?? ''); // Identify the login source (prof, student, or admin)

    // Validate input
    if (empty($email) || empty($password)) {
        echo "Email and password are required.";
        exit();
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=certieasedb", "root", $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query to fetch user details
        $query = "
            SELECT * FROM people
            WHERE mail = :mail
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['mail' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password === $user['Password']) {
            $_SESSION['email'] = $user['mail'];
            $_SESSION['first_name'] = $user['FirstName'];
            $_SESSION['last_name'] = $user['LastName'];
            $_SESSION['is_admin'] = $user['IsAdmin'] == 1; // admin flag

            if ($loginSource === 'student') {
                // Check if the user is a student
                $studentQuery = "
                    SELECT * FROM student
                    WHERE PersonCIN = :cin
                ";
                $studentStmt = $pdo->prepare($studentQuery);
                $studentStmt->execute(['cin' => $user['CIN']]);
                $isStudent = $studentStmt->fetch(PDO::FETCH_ASSOC);

                if ($isStudent) {
                    $_SESSION['student_details'] = [
                        'PersonCIN' => $user['CIN'],
                        'StudentGroup' => $isStudent['StudentGroup'],
                        'NivaueStudent' => $isStudent['NivaueStudent']
                    ];
                    $_SESSION['PersonCIN'] = $user['CIN'];

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
                    $certStmt->execute(['personCIN' => $user['CIN']]);
                    $certificates = $certStmt->fetchAll(PDO::FETCH_ASSOC);

                    $_SESSION['certificates'] = $certificates;

                    unset($_SESSION['is_prof']);
                    unset($_SESSION['prof_CIN']);
                    unset($_SESSION['is_admin']);
                    unset($_SESSION['admin_CIN']);
                    header("Location: ../../html/Certificat S-P/cetificat_medical.php");
                    exit();
                } else {
                    header("Location: ../../html/error_pages/log_with_studentAcc.html");
                    exit();
                }
            } elseif ($loginSource === 'admin') {
                // Check if the user is an admin
                if ($user['IsAdmin'] == 1) {
                    $_SESSION['is_admin'] = true;
                    $_SESSION['admin_CIN'] = $user['CIN'];
                    $_SESSION['PersonCIN'] = $user['CIN'];

                    unset($_SESSION['is_prof']);
                    unset($_SESSION['prof_CIN']);
                    unset($_SESSION['student_details']);

                    $certQuery = "
                        SELECT 
                            people.FirstName,
                            people.LastName,
                            certificatesmedical.StartDate,
                            certificatesmedical.EndDate,
                            certificatesmedical.photoPath
                        FROM certificatesmedical
                        INNER JOIN people ON certificatesmedical.PersonCIN = people.CIN
                        WHERE certificatesmedical.PersonCIN = :personCIN
                    ";
                    $certStmt = $pdo->prepare($certQuery);
                    $certStmt->execute(['personCIN' => $user['CIN']]);
                    $certificates = $certStmt->fetchAll(PDO::FETCH_ASSOC);

                    $_SESSION['certificates'] = $certificates;

                    header("Location: ../../html/admin/choix-fonctionement.html");
                    exit();
                } else {
                    header("Location: ../../html/error_pages/log_with_adminAcc.html");
                    exit();
                }
            } elseif ($loginSource === 'prof') {
                $studentQuery = "
                    SELECT * FROM student
                    WHERE PersonCIN = :cin
                ";
                $studentStmt = $pdo->prepare($studentQuery);
                $studentStmt->execute(['cin' => $user['CIN']]);
                $isStudent = $studentStmt->fetch(PDO::FETCH_ASSOC);

                if (!$isStudent && !$user['IsAdmin']) {
                    $_SESSION['is_prof'] = true;
                    $_SESSION['prof_CIN'] = $user['CIN'];
                    $_SESSION['PersonCIN'] = $user['CIN'];

                    unset($_SESSION['student_details']);
                    unset($_SESSION['is_admin']);
                    unset($_SESSION['admin_CIN']);
                    header("Location: ../../html/Certificat S-P/cetificat_medical.php");
                    exit();
                } else {
                    header("Location: ../../html/error_pages/log_with_profAcc.html");
                    exit();
                }
            } else {
                echo "Invalid login source.";
                exit();
            }
        } else {
            header("Location: ../../html/error_pages/user_not_found.html");
            exit();
        }
    } catch (PDOException $e) {
        echo "Connection error: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid request method.";
}
