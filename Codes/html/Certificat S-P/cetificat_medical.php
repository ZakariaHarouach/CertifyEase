<?php
require_once '../../php/includes/fetch_certificat_medical.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Medical Certificates</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../../css/navbar.css"/>
  <link rel="stylesheet" href="../../css/footer.css"/>
  <link rel="stylesheet" href="../../css/certificat_medical.css"/>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-white shadow-sm px-4">
    <div class="container-fluid py-2">

      <!-- Left: Logo -->
      <a class="navbar-brand d-flex align-items-center" href="/Codes/html/index/index.html">
        <img src="../../../Documents/Logo-SVG/Asset-1.svg" alt="Logo" class="navbar-logo">
      </a>

      <!-- Toggle Button for Small Screens -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Center: Navbar Links -->
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav mx-auto gap-3">
          <li class="nav-item">
            <a class="nav-link" href="#">Certificat Médical</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="attestation.html">Demande Attestation</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#aboutUS">À propos</a>
          </li>
        </ul>
      </div>

      <!-- Right: Buttons (Visible on Desktop Only) -->
      <div class="d-none d-lg-flex gap-2">
        <a href="../index/choose_acc.html">
          <button class="btn-logout">Log Out</button>
        </a>
      </div>

    </div>
  </nav>

  <!-- Greeting -->

  <section class="container full-height d-flex flex-column justify-content-center">
    <form 
      method="POST" 
      action="../../php/cerificat madicale/add_certificate.php" 
      enctype="multipart/form-data" 
      class="w-100"
      onsubmit="return validateCertificateForm()"
    >
      <!-- Greeting -->
      <div class="hello-msg text-center display-4 mb-5">
        Hello, <span class="username" data-name="<?php echo htmlspecialchars($_SESSION['first_name']); ?>"></span><span class="cursor">|</span>
      </div>

      <!-- File Upload -->
      <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-10 col-lg-8">
          <div class="file-upload-box d-flex justify-content-between align-items-center p-3 rounded">
            <label for="certificate" class="file-label d-flex align-items-center w-100">
              <span id="fileName">
                <i class="fas fa-paperclip me-2"></i> Add your certificate here
              </span>
              <input type="file" id="certificate" name="certificate" class="custom-file-input" required />
            </label>
          </div>
        </div>
      </div>

      <!-- Date Range -->
      <div class="row justify-content-center align-items-center mb-4">
        <div class="col-12 col-md-5 col-lg-4 mt-lg-0 mb-lg-0 mb-4">
          <input type="date" name="start_date" class="form-control py-3 px-3" required />
        </div>
        <div class="col-12 col-md-5 col-lg-4">
          <input type="date" name="end_date" class="form-control py-3 px-3" required />
        </div>
      </div>

      <!-- Validate Button -->
      <div class="row justify-content-center w-100">
        <div class="col-12 col-md-5 col-lg-3 text-center w-75">
          <button type="submit" class="btn btn-validate px-5 py-3 w-50 rounded">Validate</button>
        </div>
      </div>
    </form>
  </section>
  
  <!-- Table Section -->
  <section class="container mt-5 mb-5">
    <div class="section-title display-4 mb-5">Medical Certifications</div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="p-2">
                <tr>
                    <th>Name</th>
                    <th>Group</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($certificates)): ?>
                    <tr>
                        <td colspan="6" class="text-center">No certificates found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($certificates as $certificate): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($certificate['FirstName'] . ' ' . $certificate['LastName']); ?></td>
                            <td><?php echo htmlspecialchars($certificate['StudentGroup']); ?></td>
                            <td><?php echo htmlspecialchars($certificate['StartDate']); ?></td>
                            <td><?php echo htmlspecialchars($certificate['EndDate']); ?></td>
                            <td>
                                <?php echo htmlspecialchars(ucfirst($certificate['CertificatStatus'])); ?> <!-- Display Status -->
                            </td>
                            <td>
                                <?php if (!empty($certificate['photoPath'])): ?>
                                    <a href="<?php echo htmlspecialchars($certificate['photoPath']); ?>" target="_blank">View</a>
                                <?php else: ?>
                                    No File
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

  <footer class="container footer mt-5">
    <div class="row justify-content-center g-4">
      
      <div class="col-md-4">
        <div class="glass-box">
          <div class="footer-title">Quick links</div>
          <a href="#" class="footer-link">Certificat Medicale</a>
          <a href="#" class="footer-link">School Certificate</a>
          <a href="#" class="footer-link">About Us</a>
          <a href="#" class="footer-link">Sign In</a>
          <a href="#" class="footer-link">Sign Up</a>
        </div>
      </div>

      <div class="col-md-4">
        <div class="glass-box">
          <div class="footer-title">Team:</div>
          <div class="footer-text">Adam Elmekadem</div>
          <div class="footer-text">Zakaria Harouach</div>
          <div class="footer-text">Abdesamad Tikonab</div>
          <div class="footer-text">Ilyas Dahs</div>
          <div class="footer-text italic">Ms. Chaimae Haoul <small>(Teacher)</small></div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="glass-box">
          <div class="footer-title">Thanks For:</div>
          <div class="footer-text">Ofppt Ntic Rabat</div>
          <div class="footer-text">Ms Wassima Akhrif</div>
        </div>
      </div>

    </div>

    <div class="footer-bottom">
      © 2024 CertifyEase. All rights reserved.
      <div class="footer-links-bottom">
        <a href="#">Privacy Policy</a> |
        <a href="#">Services Terms</a>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

  <script src="../../js/animations.js"></script>

  <script src="../../js/certifications validation/medical_certif_validation.js"></script>

</body>
</html>
