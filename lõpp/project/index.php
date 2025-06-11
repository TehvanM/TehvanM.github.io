<?php
require_once 'config.php';

// Väljalogimine
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

// Sisselogimine
if ($_POST && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $parool = $_POST['parool'];
    
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM kasutajad WHERE email = ?");
    $stmt->execute([$email]);
    $kasutaja = $stmt->fetch();
    
    if ($kasutaja && password_verify($parool, $kasutaja['parool'])) {
        $_SESSION['kasutaja_id'] = $kasutaja['id'];
        $_SESSION['email'] = $kasutaja['email'];
        $_SESSION['roll'] = $kasutaja['roll'];
        
        header('Location: index.php');
        exit;
    } else {
        $viga = "Vale e-post või parool!";
    }
}

// Registreerimine
if ($_POST && isset($_POST['register'])) {
    $eesnimi = trim($_POST['eesnimi']);
    $perenimi = trim($_POST['perenimi']);
    $isikukood = trim($_POST['isikukood']);
    $email = trim($_POST['email']);
    $parool = $_POST['parool'];
    
    $vead = [];
    
    if (!valideeruIsikukood($isikukood)) {
        $vead[] = "Vigane isikukood!";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $vead[] = "Vigane e-posti aadress!";
    }
    
    if (strlen($parool) < 6) {
        $vead[] = "Parool peab olema vähemalt 6 märki!";
    }
    
    if (empty($vead)) {
        $db = getDB();
        
        try {
            $db->beginTransaction();
            
            // Kasutaja loomine
            $stmt = $db->prepare("INSERT INTO kasutajad (email, parool, roll) VALUES (?, ?, 'klient')");
            $stmt->execute([$email, password_hash($parool, PASSWORD_DEFAULT)]);
            $kasutaja_id = $db->lastInsertId();
            
            // Kliendi loomine
            $stmt = $db->prepare("INSERT INTO kliendid (eesnimi, perenimi, isikukood, email, kasutaja_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$eesnimi, $perenimi, $isikukood, $email, $kasutaja_id]);
            
            $db->commit();
            
            $_SESSION['kasutaja_id'] = $kasutaja_id;
            $_SESSION['email'] = $email;
            $_SESSION['roll'] = 'klient';
            
            header('Location: index.php');
            exit;
            
        } catch (Exception $e) {
            $db->rollBack();
            $viga = "Registreerimine ebaõnnestus. E-post või isikukood juba olemas.";
        }
    } else {
        $viga = implode('<br>', $vead);
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoRemontiks - Autoremondi haldussüsteem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #ea580c;
            --success-color: #16a34a;
        }
        
        .bg-primary-custom { background-color: var(--primary-color) !important; }
        .text-primary-custom { color: var(--primary-color) !important; }
        .btn-primary-custom { background-color: var(--primary-color); border-color: var(--primary-color); }
        .btn-primary-custom:hover { background-color: #1d4ed8; border-color: #1d4ed8; }
        .btn-secondary-custom { background-color: var(--secondary-color); border-color: var(--secondary-color); }
        .btn-secondary-custom:hover { background-color: #dc2626; border-color: #dc2626; }
        
        .hero-section {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            padding: 4rem 0;
        }
        
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .card-custom:hover {
            transform: translateY(-5px);
        }
        
        .service-card {
            border-left: 4px solid var(--secondary-color);
        }
    </style>
</head>
<body>
    <!-- Navigatsioon -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary-custom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="fas fa-wrench me-2"></i>AutoRemontiks
            </a>
            
            <div class="navbar-nav ms-auto">
                <?php if (onSisselogitud()): ?>
                    <span class="navbar-text me-3">
                        Tere, <?php echo htmlspecialchars($_SESSION['email']); ?>
                        <?php if (onTootaja()): ?>
                            <span class="badge bg-warning ms-1">Töötaja</span>
                        <?php endif; ?>
                    </span>
                    <?php if (onTootaja()): ?>
                        <a href="admin.php" class="btn btn-outline-light btn-sm me-2">
                            <i class="fas fa-cog"></i> Haldus
                        </a>
                    <?php endif; ?>
                    <a href="?logout=1" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logi välja
                    </a>
                <?php else: ?>
                    <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-sign-in-alt"></i> Logi sisse
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?php if (!onSisselogitud()): ?>
        <!-- Hero sektsioon -->
        <section class="hero-section">
            <div class="container text-center">
                <h1 class="display-4 fw-bold mb-4">AutoRemontiks</h1>
                <p class="lead mb-4">Professionaalne autoremondi broneerimissüsteem</p>
                <button class="btn btn-light btn-lg me-3" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="fas fa-sign-in-alt me-2"></i>Logi sisse
                </button>
                <button class="btn btn-outline-light btn-lg" data-bs-toggle="modal" data-bs-target="#registerModal">
                    <i class="fas fa-user-plus me-2"></i>Registreeru
                </button>
            </div>
        </section>

        <!-- Teenused -->
        <section class="py-5">
            <div class="container">
                <h2 class="text-center mb-5">Meie teenused</h2>
                <div class="row">
                    <?php
                    $db = getDB();
                    $stmt = $db->prepare("SELECT * FROM teenused WHERE aktiivne = 1");
                    $stmt->execute();
                    $teenused = $stmt->fetchAll();
                    
                    foreach ($teenused as $teenus):
                    ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="card card-custom service-card h-100">
                            <div class="card-body">
                                <h5 class="card-title text-primary-custom"><?php echo htmlspecialchars($teenus['nimi']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($teenus['kirjeldus']); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted"><?php echo $teenus['kestus_tunnid']; ?>h</span>
                                    <span class="fw-bold text-success"><?php echo number_format($teenus['hind'], 2); ?>€</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

    <?php else: ?>
        <!-- Sisselogitud kasutaja sisu -->
        <div class="container py-5">
            <?php if (onTootaja()): ?>
                <div class="row">
                    <div class="col-12">
                        <h2>Töötaja töölaud</h2>
                        <div class="card card-custom">
                            <div class="card-body">
                                <p>Tere tulemast töötaja paneeli! Siin saate hallata kõiki broneeringuid ja teenuseid.</p>
                                <a href="admin.php" class="btn btn-primary-custom">
                                    <i class="fas fa-cog me-2"></i>Ava halduspaneel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-12">
                        <h2>Tere tulemast!</h2>
                        <p>Siit saate broneerida autoremondi teenuseid.</p>
                        <a href="booking.php" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-calendar-plus me-2"></i>Broneeri teenus
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Sisselogimise modal -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sisselogimine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <?php if (isset($viga) && isset($_POST['login'])): ?>
                            <div class="alert alert-danger"><?php echo $viga; ?></div>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label class="form-label">E-posti aadress</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Parool</label>
                            <input type="password" name="parool" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">
                                Töötaja sisselogimine: tootaja@autoremontiks.ee / parool123
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sulge</button>
                        <button type="submit" name="login" class="btn btn-primary-custom">Logi sisse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Registreerimise modal -->
    <div class="modal fade" id="registerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registreerimine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <?php if (isset($viga) && isset($_POST['register'])): ?>
                            <div class="alert alert-danger"><?php echo $viga; ?></div>
                        <?php endif; ?>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Eesnimi</label>
                                <input type="text" name="eesnimi" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Perekonnanimi</label>
                                <input type="text" name="perenimi" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isikukood</label>
                            <input type="text" name="isikukood" class="form-control" pattern="[0-9]{11}" maxlength="11" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">E-posti aadress</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Parool</label>
                            <input type="password" name="parool" class="form-control" minlength="6" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sulge</button>
                        <button type="submit" name="register" class="btn btn-primary-custom">Registreeru</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if (isset($viga)): ?>
    <script>
        <?php if (isset($_POST['login'])): ?>
            new bootstrap.Modal(document.getElementById('loginModal')).show();
        <?php elseif (isset($_POST['register'])): ?>
            new bootstrap.Modal(document.getElementById('registerModal')).show();
        <?php endif; ?>
    </script>
    <?php endif; ?>
</body>
</html>