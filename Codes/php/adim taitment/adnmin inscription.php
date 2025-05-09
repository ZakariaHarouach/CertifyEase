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
        global $AdminEmail;
        global $AdminPassword;

        if(empty($FirstName)|| empty($LastName)||empty($CIN)||empty($Phone)||empty($BirthDay)||empty($AdminEmail)||empty($AdminPassword))
        return false;
        return true;
    }

    function AddAdmin($CIN, $FirstName, $LastName, $Mail, $Phone, $Password, $BirthDate) {

        global $pdo;
        $IsAdded=false;
    
        try {
            $pdo->beginTransaction();
    
            $QueryPeople = "INSERT INTO People (CIN, FirstName, LastName, Mail, Phone, Password, BirthDate, IsAdmin) VALUES (:CIN, :First, :Last, :Mail, :Phone, :Password, :BirthDate, true)";
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

        $fullName= $_SESSION["adminFullName"];
        $nameParts = explode(' ', $fullName, 2);

        $FirstName = $nameParts[0];
        $LastName = $nameParts[1];
        $CIN=$_SESSION["cin"];
        $Phone = $_SESSION["adminPhone"];
        $BirthDay=$_SESSION["birthday"];
        $AdminEmail=$_POST["adminEmail"];
        $AdminPassword=$_POST["adminPassword"];

        if(IsValidData()){
            if(AddAdmin($CIN,$FirstName,$LastName,$AdminEmail,$Phone,$AdminPassword,$BirthDay)){
                header("Location: ../../html/admin/login_admin.html");
            }
            else{
                echo("Admin was not added");
            }
        }
        else{
            echo("not data is valid");
        }
    }
?>