<?php
session_start();
    include "../includes/db.php"; 
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $UserNumber=$_POST["code"];
        if($UserNumber==$_SESSION["Number"]){

            $NewPassword=$_POST["password"];
            if($_POST["ConfirmPassword"]==$NewPassword){
                $Query="update People set password=:password where mail=:mail";
                $Command=$pdo->prepare($Query);
                $Command->bindParam(":password",$NewPassword);
                $Command->bindParam(":mail",$_SESSION["UserMail"]);
                if($Command->execute()){
                    if($Command->rowCount()>0){
                        header("Location: ../../html/index/index.html");
                }
                else{
                    echo ("lpassword wa9ila raha mtbdaltch ");
                }
                }
                else{
                    echo("bleach 7seen mn attack on titan");
                }
            }
        }
        else{
            echo("dragon ball 2a7ssen anime");
        }
    }
?>