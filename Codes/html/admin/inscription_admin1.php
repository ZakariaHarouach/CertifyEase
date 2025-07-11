<?php
  session_start();
  if($_SERVER["REQUEST_METHOD"]=="POST"){
  $_SESSION["adminFullName"]= $_POST["adminFullName"];
  $_SESSION["cin"]=$_POST["cin"];
  $_SESSION["adminPhone"]=$_POST["adminPhone"];
  $_SESSION["birthday"]=$_POST["birthday"];

  header("Location: inscription_admin2.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Certi-Ease</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="../../css/Login_student.css">
  
</head>
<body>
    <div class="container-fluid">
        <div class="row">      
            <div id="text" class="col-md-7 d-flex flex-column justify-content-center align-items-start ps-5 text-admin">
                <div class="content">
                  <h1>Certi-Ease</h1>
                  <p>Welcome to CertiFy-Ease! <br>
                    Communicate with administration with ease and simplicity!!</p>
                  <button id="butn" class="btn py-2 px-3 admin">Read more</button>
                </div>
            </div>

            <div class="col-md-5 d-flex flex-column justify-content-center align-items-center ps-5">
                <form class="form-section w-75" method="POST" action="inscription_admin1.php">
                    <h2>Hello!</h2>
                    <p>Sign up to get started</p>

                    <!-- Full Name Input -->
                    <div class="mt-5 mb-3">
                      <div class="input-group">
                        <span class="input-group-text"><i class='bx bxs-user'></i></span>
                        <input 
                          type="text" 
                          id="FullName" 
                          name="adminFullName" 
                          class="form-control p-3" 
                          placeholder="Full name" 
                          required>
                      </div>
                    </div>

                    <div class="mb-3">
                      <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-id-card'></i></span>
                        <input 
                          type="text" 
                          id="cin" 
                          name="cin" 
                          class="form-control p-3" 
                          placeholder="Enter your CIN" 
                          required>
                      </div>
                    </div>
                    
                    <!-- Phone Input -->
                    <div class="mb-3">
                      <div class="input-group">
                        <span class="input-group-text"><i class='bx bxs-phone'></i></span>
                        <input 
                          type="tel" 
                          id="Phone" 
                          name="adminPhone" 
                          class="form-control p-3" 
                          placeholder="Phone" 
                          required>
                      </div>
                    </div>

                    <!-- Birthday Input -->
                    <div class="mb-3">
                      <div class="mb-3">
                        <div class="input-group">
                          <span class="input-group-text"><i class='bx bxs-calendar'></i></span>
                          <input 
                            type="date" 
                            id="birthday" 
                            name="birthday" 
                            class="form-control p-3" 
                            style="color: #595c5f;" 
                            placeholder="Birthday" 
                            required>
                        </div>
                      </div>
                    </div>  

                    <!-- Next Button -->
                    <button 
                      id="NextButton" 
                      name="adminNextButton" 
                      type="submit" 
                      class="btn btn-primary w-100 p-3 admin"
                      onclick="ValidateProfAdminAuthentication(2)">
                      Next
                    </button>                
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/prof Admin Validatio/inscription_validation1.js"></script>

</body>
</html>
