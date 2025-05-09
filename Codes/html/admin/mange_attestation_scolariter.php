<?php
session_start();
require_once '../../php/includes/db.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=certieasedb", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $search = $_GET['search'] ?? '';

    if (!empty($search)) {
        $query = "
            SELECT 
                demend.DemendID,
                demend.DemendStatus,
                demend.DemendDate,
                student.StudentGroup,
                people.FirstName,
                people.LastName,
                people.mail
            FROM demend
            INNER JOIN student ON demend.StudentCIN = student.PersonCIN
            INNER JOIN people ON student.PersonCIN = people.CIN
            WHERE demend.DemendStatus = 'pending' 
              AND (
                  student.PersonCIN LIKE :search OR 
                  CONCAT(people.FirstName, ' ', people.LastName) LIKE :search OR 
                  people.mail LIKE :search
              )
            ORDER BY demend.DemendDate DESC
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['search' => '%' . $search . '%']);
    } else {
        $query = "
            SELECT 
                demend.DemendID,
                demend.DemendStatus,
                demend.DemendDate,
                student.StudentGroup,
                people.FirstName,
                people.LastName,
                people.mail
            FROM demend
            INNER JOIN student ON demend.StudentCIN = student.PersonCIN
            INNER JOIN people ON student.PersonCIN = people.CIN
            WHERE demend.DemendStatus = 'pending'
            ORDER BY demend.DemendDate DESC
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }

    $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching certificates: " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $demandId = $_POST['certificate_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($demandId && $action) {
        try {
            if ($action === 'accept') {
                $query = "
                    UPDATE demend
                    SET DemendStatus = 'accepted'
                    WHERE DemendID = :demandId
                ";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['demandId' => $demandId]);

                $query="insert into educationcertificate(LastCertifcateDate,DemandID) values(curdate(),:ID)";
                $stmt = $pdo->prepare($query);
                
                $stmt->execute([':ID' => $demandId]);
            } elseif ($action === 'reject') {
                $query = "
                    UPDATE demend
                    SET DemendStatus = 'rejected'
                    WHERE DemendID = :demandId
                ";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['demandId' => $demandId]);
            }

            echo json_encode(['success' => true, 'demandId' => $demandId]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request.']);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Managing School certificates</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../../css/navbar.css"/>
  <link rel="stylesheet" href="../../css/footer.css"/>
  <link rel="stylesheet" href="../../css/management_cartificat.css"/>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-white shadow-sm px-4">
    <div class="container-fluid py-2">

      <!-- Left: Logo -->
      <a class="navbar-brand d-flex align-items-center" href="../index/index.html">
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
            <a class="nav-link" href="mange_certificat_medicale.php">Gestion C.Medical</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Gestion D'Attestation</a>
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
    <form method="GET" action="mange_attestation_scolariter.php" class="w-100">

    <div class="hello-msg text-center display-4 mb-5">
        Hello, <span class="username" data-name="<?php echo htmlspecialchars($_SESSION['first_name']) ?? 'Student'; ?>"></span><span class="cursor">|</span>
      </div>

      <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-10 col-lg-8">
          <div class="file-upload-box d-flex justify-content-between align-items-center p-3 rounded">
            <label for="search" class="file-label d-flex align-items-center w-100">
              <input 
                type="search" 
                id="search" 
                name="search" 
                class="form-control reason-input ms-3 border-0" 
                placeholder="Search for a user by CIN" 
                value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>"
              />
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
            <button type="submit" class="btn btn-validate px-5 py-3 w-50 rounded">Search</button>
          </div>
        </div>
    </form>
  </section>
  
  <!-- Table Section -->
  <section class="container mt-5 mb-5">
    <div class="section-title display-4 mb-5">School certifications</div>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="p-2">
          <tr>
            <th>Email</th>
            <th>Group</th>
            <th>Date</th>
            <th>Accepter / Refuser</th>
          </tr>
        </thead>
        <tbody>
            <?php if (!empty($certificates)): ?>
                <?php foreach ($certificates as $certificate): ?>
                    <tr id="row-<?php echo htmlspecialchars($certificate['DemendID']); ?>">
                        <td><?php echo htmlspecialchars($certificate['mail']); ?></td>
                        <td><?php echo htmlspecialchars($certificate['StudentGroup'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($certificate['DemendDate']); ?></td>
                        <td class="text-center">
                            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2">
                                <button 
                                    class="btn btn-accepter" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#actionModal"
                                    data-id="<?php echo htmlspecialchars($certificate['DemendID']); ?>"
                                    data-action="accept"
                                >
                                    Accepter
                                </button>
                                <button 
                                    class="btn btn-refuser" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#actionModal"
                                    data-id="<?php echo htmlspecialchars($certificate['DemendID']); ?>"
                                    data-action="reject"
                                >
                                    Refuser
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No school certificates found.</td>
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
                Are you sure you want to <span id="actionType"></span> this school certificate?
            </div>
            <div class="modal-footer">
                <form method="POST" action="mange_attestation_scolariter.php">
                    <input type="hidden" name="certificate_id" id="certificateIdInput">
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
  <script src="../../js/modal1.js"></script>
  
</body>
</html>
