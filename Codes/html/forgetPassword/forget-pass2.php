<?php
session_start();

// Check if email exists in session
if (!isset($_SESSION['UserMail'])) {
    echo "No email found in session.";
    header("Location: ../../html/forgetPassword/forget-pass.php?status=error&message=no_email");
    exit();
}

// Retrieve the email from the session
$UserMail = $_SESSION['UserMail'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Certi-Ease</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../css/Login_student.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Left Section -->
      <div id="text" class="col-md-7 d-flex flex-column justify-content-center align-items-start ps-5 text-student">
        <div class="content">
          <h1>Certi-Ease</h1>
          <p>Welcome to CertiFy-Ease! <br>
            Communicate with administration with ease and simplicity!</p>
          <div class="d-flex gap-3">
            <button id="butn" class="btn py-2 px-3 student">Read more</button>
          </div>
        </div>
      </div>

      <!-- Right Section (Code Input and New Password Form) -->
      <div class="col-md-5 d-flex flex-column justify-content-center align-items-center ps-5">
        <form class="form-section w-75" action="../../php/forget_password/NewPassword.php" method="POST">
          <h2>Ooooh !</h2>
          <p>Verify your Gmail and enter the code</p>

          <!-- Code Input -->
          <div class="mt-5 mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bx bx-lock"></i></span>
              <input type="text" id="code" name="code" class="form-control p-3" placeholder="Enter the 6-digit code" maxlength="6" required>
            </div>
          </div>

          <!-- Password Input -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bx bx-lock"></i></span>
              <input type="password" id="password" name="password" class="form-control p-3" placeholder="New Password" required>
            </div>
          </div>

          <!-- Confirm Password Input -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bx bx-lock"></i></span>
              <input type="password" id="confirmPassword" name="ConfirmPassword" class="form-control p-3" placeholder="Confirm Password" required>
            </div>
          </div>

          <button id="loginButton" name="loginButton" type="submit" class="btn btn-primary w-100 p-3 student">
            Confirm
          </button>
        </form>

        <a href="../../php/forget_password/send_email.php?email=<?php echo $_SESSION['UserMail'];?>" class="text-dark mt-3">Resend code</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../js/forget_password_Validation.js"></script>
</body>
</html>
