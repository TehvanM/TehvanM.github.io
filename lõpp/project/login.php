<?php
require_once 'config.php';

$teade = '';

// Kontrolli kas kasutaja on juba sisse logitud
$kasutaja = kontrolliSessiooni();
if ($kasutaja) {
    if ($kasutaja['kasutaja_tyyp'] === 'toottaja') {
        header('Location: admin.php');
    } else {
        header('Location: index.php');
    }
    exit;
}

// Sisselogimise töötlemine
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $parool = $_POST['parool'];
    $maletuMind = isset($_POST['maletu_mind']);
    
    if (empty($email) || empty($parool)) {
        $teade = '<div class="alert alert-danger">Palun täitke kõik väljad!</div>';
    } elseif (!valideeriEmail($email)) {
        $teade = '<div class="alert alert-danger">Vigane e-maili aadress!</div>';
    } else {
        // Otsi klienti
        $stmt = $pdo->prepare("SELECT id, eesnimi, perekonnanimi, email, parool FROM kliendid WHERE email = ?");
        $stmt->execute([$email]);
        $klient = $stmt->fetch();
        
        // Otsi töötajat
        $stmt = $pdo->prepare("SELECT id, eesnimi, perekonnanimi, email, parool, roll FROM toottajad WHERE email = ?");
        $stmt->execute([$email]);
        $toottaja = $stmt->fetch();
        
        if ($klient && password_verify($parool, $klient['parool'])) {
            // Klient
            looSessioon($klient['id'], 'klient');
            if ($maletuMind) {
                // Pikenda küpsist 30 päevaks
                setcookie('session_id', $_COOKIE['session_id'], time() + (30 * 24 * 60 * 60), '/', '', false, true);
            }
            header('Location: index.php');
            exit;
        } elseif ($toottaja && password_verify($parool, $toottaja['parool'])) {
            // Töötaja
            looSessioon($toottaja['id'], 'toottaja');
            if ($maletuMind) {
                // Pikenda küpsist 30 päevaks
                setcookie('session_id', $_COOKIE['session_id'], time() + (30 * 24 * 60 * 60), '/', '', false, true);
            }
            header('Location: admin.php');
            exit;
        } else {
            $teade = '<div class="alert alert-danger">Vale e-mail või parool!</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sisselogimine - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #64748b;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .login-container {
            max-width: 400px;
            margin: 0 auto;
        }
        
        .card {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 15px;
        }
        
        .card-header {
            background: var(--primary-color);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            text-align: center;
            padding: 2rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">
                        <i class="bi bi-wrench-adjustable me-2"></i>
                        AutoRemont
                    </h2>
                    <p class="mb-0 mt-2">Sisselogimine</p>
                </div>
                <div class="card-body p-4">
                    <?php echo $teade; ?>
                    
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-maili aadress *</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                                       required>
                                <div class="invalid-feedback">Palun sisestage kehtiv e-maili aadress.</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="parool" class="form-label">Parool *</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="parool" name="parool" required>
                                <div class="invalid-feedback">Palun sisestage parool.</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="maletu_mind" name="maletu_mind">
                                <label class="form-check-label" for="maletu_mind">
                                    Mäleta mind (30 päeva)
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Logi sisse
                            </button>
                        </div>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-2">Pole veel kontot?</p>
                        <a href="register.php" class="btn btn-outline-primary">
                            <i class="bi bi-person-plus me-2"></i>Registreeru
                        </a>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="index.php" class="text-muted text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i>Tagasi avalehele
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <small class="text-white">
                    <strong>Testimiseks:</strong><br>
                    Admin: admin@autoremondi.ee / admin123<br>
                    Klient: mart.tamm@email.ee / klient123
                </small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Kliendipoolne valideerimine
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                Array.prototype.forEach.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>
</html>