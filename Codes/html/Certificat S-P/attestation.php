<?php
require_once '../../php/attestation/traitement_attestation.php';
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
  <link rel="stylesheet" href="../../css/attestation.css"/>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-white shadow-sm px-4">
    <div class="container-fluid py-2">

      <!-- Left: Logo -->
      <a class="navbar-brand d-flex align-items-center" href="index.html">
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
            <a class="nav-link" href="cetificat_medical.php">Certificat Médical</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Demande Attestation</a>
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
    <form class="w-100"
    action="../../php/attestation/traitement_attestation.php"
    method="POST"
    onsubmit="return ValidateAddictation()">
      <!-- Greeting -->
      <div class="hello-msg text-center display-4 mb-5">
        Hello, <span class="username" data-name="<?php echo htmlspecialchars($_SESSION['first_name'])?? 'Student'; ?>"></span><span class="cursor">|</span>
      </div>

      <!-- File Upload -->
      <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-10 col-lg-8">
          <div class="file-upload-box d-flex justify-content-between align-items-center p-3 rounded">
            <label for="reason" class="file-label d-flex align-items-center w-100">
              <input type="text" id="reason" class="form-control reason-input ms-3 border-0" placeholder="Write your reason here..." />
            </label>
            <button type="submit" class="btn btn-validate ms-3">
              <i class="fas fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Validate Button -->
      <div class="row justify-content-center w-100">
        <div class="col-12 col-md-5 col-lg-3 text-center w-75">
          <button class="btn btn-validate px-5 py-3 w-50 rounded">Validate</button>
        </div>
      </div>
    </form>
  </section>
  
  <!-- Table Section -->
  <section class="container mt-5 mb-5">
    <div class="section-title display-4 mb-5">School Certifications</div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="p-2">
                <tr>
                    <th>Name</th>
                    <th>Group</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($demands)): ?>
                    <?php foreach ($demands as $demand): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($demand['FirstName'] . ' ' . $demand['LastName']); ?></td>
                            <td><?php echo htmlspecialchars($demand['StudentGroup']); ?></td>
                            <td><?php echo htmlspecialchars($demand['DemendDate']); ?></td>
                            <td><?php echo htmlspecialchars(ucfirst($demand['DemendStatus'])); ?></td> <!-- Display the status -->
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No demands found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal -->
<div 
    class="modal fade" 
    id="actionModal" 
    tabindex="-1" 
    aria-labelledby="actionModalLabel" 
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actionModalLabel">Confirmation</h5>
                <button 
                    type="button" 
                    class="btn-close" 
                    data-bs-dismiss="modal" 
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                Are you sure you want to <span id="actionType"></span> this attestation?
            </div>
            <div class="modal-footer">
                <form method="POST" action="mange_attestation_scolariter.php">
                    <input type="hidden" name="attestation_id" id="attestationIdInput">
                    <input type="hidden" name="action" id="actionInput">
                    <button 
                        type="button" 
                        class="btn btn-cancel" 
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="btn btn-accepter"
                    >
                        Confirm
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

  <footer class="container footer mt-5">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

  <script src="../../js/animations.js"></script>

  <script src="../../js/Certificates_valiations.js"></script>

</body>
</html>
