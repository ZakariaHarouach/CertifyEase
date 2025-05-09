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
<?php 

    session_start();
   if($_SERVER["REQUEST_METHOD"]==="POST"){

    $_SESSION["fullName"]=$_POST["fullName"];
    $_SESSION["cin"]=$_POST["cin"];
    $_SESSION["Level"]=$_POST["Level"];
    $_SESSION["gourp"]=$_POST["gourp"];
    
    header("Location: inscription_student2.html");
   }
  
?>
<body>
  <div class="container-fluid">
    <div class="row">      
      <div id="text" class="col-md-7 d-flex flex-column justify-content-center align-items-start ps-5 text-student">
        <div class="content">
          <h1>Certi-Ease</h1>
          <p>Welcome to CertiFy-Ease! <br>
          Communicate with administration with ease and simplicity!!</p>
          <button id="butn" class="btn py-2 px-3 student">Read more</button>
        </div>
      </div>

      <div class="col-md-5 d-flex flex-column justify-content-center align-items-center ps-5">
        <form class="form-section w-75" onsubmit="return validateFirstForm()" method="POST" action="inscription_student1.php">
          <h2>Hello!</h2>
          <p>Sign up to get started</p>

          <!-- Full Name Input -->
          <div class="mt-5 mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class='bx bxs-user'></i></span>
              <input 
                type="text" 
                id="fullName" 
                name="fullName" 
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
          <!-- Student Level Select -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class='bx bxs-graduation'></i></span>
              <select 
                id="Level" 
                name="Level" 
                class="form-select p-3"
                style="color: #595c5f;" 
                required
                onchange="AddGroups()"
              >
                <option value="" disabled selected>Select your level</option>
                <option value="1a">1st Year</option>
                <option value="2a">2nd Year</option>
              </select>
            </div>
          </div>

          <!-- Group Select -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class='bx bxs-group'></i></span>
              <select 
                id="gourp" 
                name="gourp" 
                class="form-select p-3" 
                style="color: #595c5f;" 
                required
              >
                <option value="" disabled selected>Select your group</option>
              </select>
            </div>
          </div>

          <!-- Next Button -->
          <button 
            id="nextButton"
            name="nextButton" 
            type="submit" 
            class="btn btn-primary w-100 p-3 student">
            Next
          </button>                
        </form>
      </div>
    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/student_validation/Student_inscription_validation.js"></script>
    <script src="../../js/Groups.js"></script>
</body>
</html>
