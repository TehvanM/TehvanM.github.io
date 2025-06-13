<?php
require_once 'config.php';

$teade = '';

// Kontrolli kas kasutaja on juba sisse logitud
$kasutaja = kontrolliSessiooni();
if ($kasutaja) {
    header('Location: index.php');
    exit;
}

// Registreerimise töötlemine
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eesnimi = trim($_POST['eesnimi']);
    $perekonnanimi = trim($_POST['perekonnanimi']);
    $isikukood = trim($_POST['isikukood']);
    $email = trim($_POST['email']);
    $telefon = trim($_POST['telefon']);
    $parool = $_POST['parool'];
    $paroolKinnitus = $_POST['parool_kinnitus'];
    
    // Serveripoolne valideerimine
    $vead = [];
    
    if (empty($eesnimi)) $vead[] = 'Eesnimi on kohustuslik';
    if (empty($perekonnanimi)) $vead[] = 'Perekonnanimi on kohustuslik';
    if (empty($isikukood)) $vead[] = 'Isikukood on kohustuslik';
    if (empty($email)) $vead[] = 'E-maili aadress on kohustuslik';
    if (empty($parool)) $vead[] = 'Parool on kohustuslik';
    if (empty($paroolKinnitus)) $vead[] = 'Parooli kinnitus on kohustuslik';
    
    if (!valideeriIsikukood($isikukood)) {
        $vead[] = 'Vigane isikukood';
    }
    
    if (!valideeriEmail($email)) {
        $vead[] = 'Vigane e-maili aadress';
    }
    
    if (strlen($parool) < 6) {
        $vead[] = 'Parool peab olema vähemalt 6 tähemärki pikk';
    }
    
    if ($parool !== $paroolKinnitus) {
        $vead[] = 'Paroolid ei kattu';
    }
    
    // Kontrolli kas isikukood või e-mail on juba kasutuses
    if (empty($vead)) {
        $stmt = $pdo->prepare("SELECT id FROM kliendid WHERE isikukood = ? OR email = ?");
        $stmt->execute([$isikukood, $email]);
        if ($stmt->fetch()) {
            $vead[] = 'Isikukood või e-maili aadress on juba kasutusel';
        }
    }
    
    if (empty($vead)) {
        // Lisa uus klient
        $stmt = $pdo->prepare("INSERT INTO kliendid (eesnimi, perekonnanimi, isikukood, email, telefon, parool) VALUES (?, ?, ?, ?, ?, ?)");
        $hashitudParool = password_hash($parool, HASH_ALGO);
        
        if ($stmt->execute([$eesnimi, $perekonnanimi, $isikukood, $email, $telefon, $hashitudParool])) {
            $teade = '<div class="alert alert-success">Registreerimine õnnestus! Nüüd saate sisse logida.</div>';
            // Tühjenda väljad
            $eesnimi = $perekonnanimi = $isikukood = $email = $telefon = '';
        } else {
            $teade = '<div class="alert alert-danger">Registreerimisel tekkis viga. Palun proovige uuesti.</div>';
        }
    } else {
        $teade = '<div class="alert alert-danger">' . implode('<br>', $vead) . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreerimine - <?php echo SITE_NAME; ?></title>
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
            padding: 2rem 0;
        }
        
        .register-container {
            max-width: 500px;
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
        <div class="register-container">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">
                        <i class="bi bi-wrench-adjustable me-2"></i>
                        AutoRemont
                    </h2>
                    <p class="mb-0 mt-2">Konto loomine</p>
                </div>
                <div class="card-body p-4">
                    <?php echo $teade; ?>
                    
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="eesnimi" class="form-label">Eesnimi *</label>
                                <input type="text" class="form-control" id="eesnimi" name="eesnimi" 
                                       value="<?php echo isset($eesnimi) ? htmlspecialchars($eesnimi) : ''; ?>" 
                                       maxlength="50" required>
                                <div class="invalid-feedback">Palun sisestage eesnimi.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="perekonnanimi" class="form-label">Perekonnanimi *</label>
                                <input type="text" class="form-control" id="perekonnanimi" name="perekonnanimi" 
                                       value="<?php echo isset($perekonnanimi) ? htmlspecialchars($perekonnanimi) : ''; ?>" 
                                       maxlength="50" required>
                                <div class="invalid-feedback">Palun sisestage perekonnanimi.</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="isikukood" class="form-label">Isikukood *</label>
                            <input type="text" class="form-control" id="isikukood" name="isikukood" 
                                   value="<?php echo isset($isikukood) ? htmlspecialchars($isikukood) : ''; ?>" 
                                   pattern="[0-9]{11}" maxlength="11" required>
                            <div class="invalid-feedback">Palun sisestage kehtiv 11-kohaline isikukood.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">E-maili aadress *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" 
                                   maxlength="100" required>
                            <div class="invalid-feedback">Palun sisestage kehtiv e-maili aadress.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telefon" class="form-label">Telefon</label>
                            <input type="tel" class="form-control" id="telefon" name="telefon" 
                                   value="<?php echo isset($telefon) ? htmlspecialchars($telefon) : ''; ?>" 
                                   maxlength="20">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="parool" class="form-label">Parool *</label>
                                <input type="password" class="form-control" id="parool" name="parool" 
                                       minlength="6" required>
                                <div class="invalid-feedback">Parool peab olema vähemalt 6 tähemärki pikk.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="parool_kinnitus" class="form-label">Kinnita parool *</label>
                                <input type="password" class="form-control" id="parool_kinnitus" name="parool_kinnitus" 
                                       minlength="6" required>
                                <div class="invalid-feedback">Paroolid peavad kattuma.</div>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-person-plus me-2"></i>Loo konto
                            </button>
                        </div>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-2">Juba konto olemas?</p>
                        <a href="login.php" class="btn btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Logi sisse
                        </a>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="index.php" class="text-muted text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i>Tagasi avalehele
                        </a>
                    </div>
                </div>
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
                        var parool = document.getElementById('parool').value;
                        var paroolKinnitus = document.getElementById('parool_kinnitus').value;
                        
                        if (parool !== paroolKinnitus) {
                            document.getElementById('parool_kinnitus').setCustomValidity('Paroolid ei kattu');
                        } else {
                            document.getElementById('parool_kinnitus').setCustomValidity('');
                        }
                        
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        
        // Isikukoodi valideerimine
        document.getElementById('isikukood').addEventListener('input', function() {
            var isikukood = this.value;
            if (isikukood.length === 11 && /^\d{11}$/.test(isikukood)) {
                // Põhiline kontrollnumbri valideerimine
                var kaalud1 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 1];
                var summa = 0;
                for (var i = 0; i < 10; i++) {
                    summa += parseInt(isikukood[i]) * kaalud1[i];
                }
                var kontroll = summa % 11;
                
                if (kontroll === 10) {
                    var kaalud2 = [3, 4, 5, 6, 7, 8, 9, 1, 2, 3];
                    summa = 0;
                    for (var i = 0; i < 10; i++) {
                        summa += parseInt(isikukood[i]) * kaalud2[i];
                    }
                    kontroll = summa % 11;
                    if (kontroll === 10) kontroll = 0;
                }
                
                if (kontroll !== parseInt(isikukood[10])) {
                    this.setCustomValidity('Vale isikukood');
                } else {
                    this.setCustomValidity('');
                }
            }
        });
    </script>
</body>
</html>