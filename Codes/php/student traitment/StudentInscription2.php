<?php 
session_start();
$host = "localhost";
$dbname="certieasedb";
$username="root";
$password="Adam123.123$";


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
}
catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function AddStudent($CIN, $FirstName, $LastName, $Mail, $Phone, $Password, $BirthDate, $Group, $Nivau) {

    global $pdo;
    $IsAdded=false;

    try {
        $pdo->beginTransaction();

        $QueryPeople = "INSERT INTO People (CIN, FirstName, LastName, Mail, Phone, Password, BirthDate, IsAdmin) VALUES (:CIN, :First, :Last, :Mail, :Phone, :Password, :BirthDate, false)";
        $CommandPeople = $pdo->prepare($QueryPeople);
        $CommandPeople->bindParam(":CIN", $CIN);
        $CommandPeople->bindParam(":First", $FirstName);
        $CommandPeople->bindParam(":Last", $LastName);
        $CommandPeople->bindParam(":Mail", $Mail);
        $CommandPeople->bindParam(":Phone", $Phone);
        $CommandPeople->bindParam(":Password", $Password);
        $CommandPeople->bindParam(":BirthDate", $BirthDate);
        $CommandPeople->execute();

        $QueryStudent = "INSERT INTO Student VALUES (:CIN, :Group, :Nivau)";
        $CommandStudent = $pdo->prepare($QueryStudent);
        $CommandStudent->bindParam(":CIN", $CIN);
        $CommandStudent->bindParam(":Group", $Group);
        $CommandStudent->bindParam(":Nivau", $Nivau);
        $CommandStudent->execute();

        $pdo->commit();
        $IsAdded=true;

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo("There was an error: " . $e->getMessage());
        $IsAdded=false;
    }
    return $IsAdded;
}

function IsValidInfo(){

    global $firstName;
    global $lastName;
    global $CIN;
    global $Level;
    global $group;
    global $BirthDate;
    global $Phone;
    global $mail;
    global $Password;

    if(empty($firstName)||empty($lastName)||empty($CIN)||empty($Level)||empty($group)||
    empty($BirthDate)||empty($Phone)||empty($mail)||empty($Password)){
        return false;
    }
    return true;
}

// Split full name into first and last name

$fullName= $_SESSION["fullName"];
$nameParts = explode(' ', $fullName, 2);

$firstName = $nameParts[0];
$lastName = $nameParts[1];
$CIN=$_SESSION["cin"];
$Level= $_SESSION["Level"];
$group= $_SESSION["gourp"];
$BirthDate=$_POST["birthday"];
$Phone=$_POST["phone"];
$mail=$_POST["email"];
$Password=$_POST["password"];

if(IsValidInfo()){
    if(AddStudent($CIN,$firstName,$lastName,$mail,$Phone,$Password,$BirthDate,$group,$Level)){
        session_unset();
        session_destroy();
        header("Location: ../../html/student/login_student.html");
    }
    else{
        echo("Student is not added");
    }
}
else{
    echo("not all data is valid");

}