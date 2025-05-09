<?php 
    session_start();
    $host = "localhost";
    $dbname="certieasedb";
    $username="root";
    $password="Adam123.123$";

    function IsValidData(){
        
        global $FirstName;
        global $LastName;
        global $CIN;
        global $Phone;
        global $BirthDay;
        global $profEmail;
        global $profPassword;

        if(empty($FirstName)|| empty($LastName)||empty($CIN)||empty($Phone)||empty($BirthDay)||empty($profEmail)||empty($profPassword))
        return false;
        return true;
    }

    function AddProf($CIN, $FirstName, $LastName, $Mail, $Phone, $Password, $BirthDate) {

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
    
            $pdo->commit();
            $IsAdded=true;
    
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo("There was an error: " . $e->getMessage());
            $IsAdded=false;
        }
        return $IsAdded;
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        }
        catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        $fullName= $_SESSION["profFullName"];
        $nameParts = explode(' ', $fullName, 2);

        $FirstName = $nameParts[0];
        $LastName = $nameParts[1];
        $CIN=$_SESSION["cin"];
        $Phone = $_SESSION["phone"];
        $BirthDay=$_SESSION["birthday"];
        $profEmail=$_POST["profEmail"];
        $profPassword=$_POST["profPassword"];

        if(IsValidData()){
            if(AddProf($CIN,$FirstName,$LastName,$profEmail,$Phone,$profPassword,$BirthDay)){
                header("Location: ../../html/prof/login_prof.html");
            }
            else{
                echo("Prof was not added");
            }
        }
        else{
            echo("not data is valid");
        }
    }
?>