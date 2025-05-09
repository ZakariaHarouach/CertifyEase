<?php  
session_start();

include '../../../../mailPHP/phpmailer-master/sendmail.php';
include 'C:/xampp/htdocs/CertiEase/Codes/php/includes/db.php';

function ReSendEmail($UserMail) {
    // Generate a new 6-digit random number as the verification code
    $Number = rand(100000, 999999);
    
    // Store the new number and email in the session for further use
    $_SESSION["Number"] = $Number;
    $_SESSION["UserMail"] = $UserMail;

    // Send the email with the new verification code
    SendMail("adamelmekadem61@gmail.com", $UserMail, $Number);

    // Redirect to the same page with success status
    header("Location: ../../html/forgetPassword/forget-pass2.php?status=success");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" || $_SERVER["REQUEST_METHOD"] === "GET") {
    // Get the email from POST or GET request
    $UserMail = $_POST["email"] ?? $_GET["email"] ?? '';

    // If email is empty, redirect with error
    if (empty($UserMail)) {
        header("Location: ../../html/forgetPassword/forget-pass2.php?status=error&message=no_email");
        exit();
    }

    // Check if the email already exists in the database
    $Query = "SELECT 1 as y FROM People WHERE People.mail = :mail;";
    $Command = $pdo->prepare($Query);
    $Command->bindParam(":mail", $UserMail);

    // Execute the query
    if ($Command->execute()) {
        $Result = $Command->fetch(PDO::FETCH_ASSOC);

        // If the email exists in the database, send the email
        if (!empty($Result)) {
            ReSendEmail($UserMail);
        } else {
            // If email not found, redirect with error
            header("Location: ../../html/forgetPassword/forget-pass2.php?status=error&message=email_not_found");
            exit();
        }
    } else {
        // If there is a database error, redirect with error
        header("Location: ../../html/forgetPassword/forget-pass2.php?status=error&message=db_error");
        exit();
    }
}
?>
