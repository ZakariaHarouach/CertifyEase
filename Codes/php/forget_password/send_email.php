<?php  
session_start();

ob_start();

include '../../../../mailPHP/phpmailer-master/sendmail.php';
include 'C:/xampp/htdocs/CertiEase/Codes/php/includes/db.php';

function ReSendEmail($UserMail) {
    $Number = rand(100000, 999999);
    
    $_SESSION["Number"] = $Number;
    $_SESSION["UserMail"] = $UserMail;

    SendMail("adamelmekadem61@gmail.com", $UserMail, $Number);

    header("Location: ../../html/forgetPassword/forget-pass2.php?status=success");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" || $_SERVER["REQUEST_METHOD"] === "GET") {
    $UserMail = $_POST["email"] ?? $_GET["email"] ?? '';

    if (empty($UserMail)) {
        header("Location: ../../html/forgetPassword/forget-pass2.php?status=error&message=no_email");
        exit();
    }

    $Query = "SELECT 1 as y FROM People WHERE People.mail = :mail;";
    $Command = $pdo->prepare($Query);
    $Command->bindParam(":mail", $UserMail);

    if ($Command->execute()) {
        $Result = $Command->fetch(PDO::FETCH_ASSOC);

        if (!empty($Result)) {
            ReSendEmail($UserMail);
        } else {
            header("Location: ../../html/forgetPassword/forget-pass2.php?status=error&message=email_not_found");
            exit();
        }
    } else {
        header("Location: ../../html/forgetPassword/forget-pass2.php?status=error&message=db_error");
        exit();
    }
}
?>
