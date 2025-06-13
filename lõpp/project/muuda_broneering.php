<?php
require_once 'config.php';

// Kontrolli kas kasutaja on klient
$kasutaja = kontrolliSessiooni();
if (!$kasutaja || $kasutaja['kasutaja_tyyp'] !== 'klient') {
    header('Location: login.php');
    exit;
}

$teade = '';
$broneeringId = intval($_GET['id'] ?? 0);

// Leia broneering
$stmt = $pdo->prepare("SELECT b.*, t.nimi as teenus_nimi, t.kestus, tk.nimi as tookoht_nimi 
                      FROM broneeringud b 
                      JOIN teenused t ON b.teenus_id = t.id 
                      JOIN tookohad tk ON b.tookoht_id = tk.id 
                      WHERE b.id = ? AND b.klient_id = ?");
$stmt->execute([$broneeringId, $kasutaja['kasutaja_id']]);
$broneering = $stmt->fetch();

if (!$broneering) {
    header('Location: index.php');
    exit;
}

// Kontrolli kas broneering on muudetav
if (!onMuudetav($broneering['kuupaev'], $broneering['algus_aeg']) || $broneering['staatus'] !== 'kinnitatud') {
    header('Location: index.php');
    exit;
}

// Teenused ja töökohad
$stmt = $pdo->prepare("SELECT * FROM teenused WHERE aktiivne = 1 ORDER BY kategooria, nimi");
$stmt->execute();
$teenused = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM tookohad WHERE aktiivne = 1 ORDER BY nimi");
$stmt->execute();
$tookohad = $stmt->fetchAll();

// Broneeringu muutmine
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teenusId = intval($_POST['teenus_id']);
    $tookohtId = intval($_POST['tookoht_id']);
    $kuupaev = $_POST['kuupaev'];
    $algusAeg = $_POST['algus_aeg'];
    
    // Teenuse kestuse leidmine
    $stmt = $pdo->prepare("SELECT kestus FROM teenused WHERE id = ?");
    $stmt->execute([$teenusId]);
    $teenus = $stmt->fetch();
    
    if ($teenus) {
        $loppAeg = date('H:i:s', strtotime($algusAeg) + ($teenus['kestus'] * 60));
        
        // Kontrolli kattuvusi (välja arvatud praegune broneering)
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM broneeringud 
                              WHERE tookoht_id = ? AND kuupaev = ? AND id != ?
                              AND staatus = 'kinnitatud' 
                              AND ((algus_aeg < ? AND lopp_aeg > ?) 
                                   OR (algus_aeg < ? AND lopp_aeg > ?))");
        $stmt->execute([$tookohtId, $kuupaev, $broneeringId, $loppAeg, $algusAeg, $algusAeg, $loppAeg]);
        
        if ($stmt->fetchColumn() > 0) {
            $teade = '<div class="alert alert-danger">Valitud ajal on töökoht juba hõivatud!</div>';
        } else {
            // Muuda broneeringut
            $stmt = $pdo->prepare("UPDATE broneeringud SET teenus_id = ?, tookoht_id = ?, kuupaev = ?, algus_aeg = ?, lopp_aeg = ? WHERE id = ?");
            if ($stmt->execute([$teenusId, $tookohtId, $kuupaev, $algusAeg, $loppAeg, $broneeringId])) {
                header('Location: index.php#broneeringud');
                exit;
            } else {
                $teade = '<div class="alert alert-danger">Broneeringu muutmisel tekkis viga!</div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muuda broneeringut - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #64748b;
        }
        
        .navbar-brand {
            font-weight: bold;
            color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
        }
    </style>
</head>
<body>
    <!-- Navigatsioon -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <i class="bi bi-wrench-adjustable me-2"></i>
                AutoRemont
            </a>
            
            <div class="d-flex align-items-center">
                <span class="me-3">
                    <i class="bi bi-person-circle me-1"></i>
                    <?php echo htmlspecialchars($kasutaja['eesnimi'] . ' ' . $kasutaja['perekonnanimi']); ?>
                </span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i>Logi välja
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">
                            <i class="bi bi-pencil me-2"></i>Muuda broneeringut
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php echo $teade; ?>
                        
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Praegu broneeritud: <strong><?php echo htmlspecialchars($broneering['teenus_nimi']); ?></strong> 
                            <?php echo formateeriKuupaev($broneering['kuupaev']) . ' kell ' . formateeriAeg($broneering['algus_aeg']); ?>
                            (<?php echo htmlspecialchars($broneering['tookoht_nimi']); ?>)
                        </div>
                        
                        <form method="POST" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="teenus_id" class="form-label">Teenus *</label>
                                    <select class="form-select" id="teenus_id" name="teenus_id" required>
                                        <option value="">Vali teenus...</option>
                                        <?php 
                                        $kategoriad = [];
                                        foreach ($teenused as $teenus) {
                                            $kategoriad[$teenus['kategooria']][] = $teenus;
                                        }
                                        
                                        foreach ($kategoriad as $kategooria => $kategooriateenused): ?>
                                            <optgroup label="<?php echo htmlspecialchars($kategooria); ?>">
                                                <?php foreach ($kategooriateenused as $teenus): ?>
                                                    <option value="<?php echo $teenus['id']; ?>" 
                                                            data-kestus="<?php echo $teenus['kestus']; ?>"
                                                            <?php echo $teenus['id'] == $broneering['teenus_id'] ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($teenus['nimi']) . ' - ' . number_format($teenus['hind'], 2) . '€'; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Palun vali teenus.</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="tookoht_id" class="form-label">Töökoht *</label>
                                    <select class="form-select" id="tookoht_id" name="tookoht_id" required>
                                        <option value="">Vali töökoht...</option>
                                        <?php foreach ($tookohad as $tookoht): ?>
                                            <option value="<?php echo $tookoht['id']; ?>" 
                                                    <?php echo $tookoht['id'] == $broneering['tookoht_id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($tookoht['nimi']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Palun vali töökoht.</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kuupaev" class="form-label">Kuupäev *</label>
                                    <input type="date" class="form-control" id="kuupaev" name="kuupaev" 
                                           min="<?php echo date('Y-m-d'); ?>" 
                                           value="<?php echo $broneering['kuupaev']; ?>" required>
                                    <div class="invalid-feedback">Palun vali kuupäev.</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="algus_aeg" class="form-label">Kellaaeg *</label>
                                    <input type="time" class="form-control" id="algus_aeg" name="algus_aeg" 
                                           min="08:00" max="17:00" step="900" 
                                           value="<?php echo substr($broneering['algus_aeg'], 0, 5); ?>" required>
                                    <div class="invalid-feedback">Palun vali kellaaeg (08:00-17:00).</div>
                                    <small class="form-text text-muted">Tööaeg: 08:00-17:00</small>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="index.php#broneeringud" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Tagasi
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Salvesta muudatused
                                </button>
                            </div>
                        </form>
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