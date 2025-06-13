<?php
require_once 'config.php';

$kasutaja = kontrolliSessiooni();
$teade = '';

// Kontrolli kas kasutaja on sisse logitud
if ($kasutaja && $kasutaja['kasutaja_tyyp'] === 'toottaja') {
    header('Location: admin.php');
    exit;
}

// Teenuste laadimine
$stmt = $pdo->prepare("SELECT * FROM teenused WHERE aktiivne = 1 ORDER BY kategooria, nimi");
$stmt->execute();
$teenused = $stmt->fetchAll();

// Töökohtade laadimine
$stmt = $pdo->prepare("SELECT * FROM tookohad WHERE aktiivne = 1 ORDER BY nimi");
$stmt->execute();
$tookohad = $stmt->fetchAll();

// Broneeringu töötlemine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['broneeri'])) {
    if (!$kasutaja) {
        $teade = '<div class="alert alert-danger">Palun logige esmalt sisse!</div>';
    } else {
        $teenusId = $_POST['teenus_id'];
        $tookohtId = $_POST['tookoht_id'];
        $kuupaev = $_POST['kuupaev'];
        $algusAeg = $_POST['algus_aeg'];
        
        // Teenuse kestuse leidmine
        $stmt = $pdo->prepare("SELECT kestus FROM teenused WHERE id = ?");
        $stmt->execute([$teenusId]);
        $teenus = $stmt->fetch();
        
        if ($teenus) {
            $loppAeg = date('H:i:s', strtotime($algusAeg) + ($teenus['kestus'] * 60));
            
            // Kontrolli kattuvusi
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM broneeringud 
                                  WHERE tookoht_id = ? AND kuupaev = ? 
                                  AND staatus = 'kinnitatud' 
                                  AND ((algus_aeg < ? AND lopp_aeg > ?) 
                                       OR (algus_aeg < ? AND lopp_aeg > ?))");
            $stmt->execute([$tookohtId, $kuupaev, $loppAeg, $algusAeg, $algusAeg, $loppAeg]);
            
            if ($stmt->fetchColumn() > 0) {
                $teade = '<div class="alert alert-danger">Valitud ajal on töökoht juba hõivatud!</div>';
            } else {
                // Lisa broneering
                $stmt = $pdo->prepare("INSERT INTO broneeringud (klient_id, teenus_id, tookoht_id, kuupaev, algus_aeg, lopp_aeg) 
                                      VALUES (?, ?, ?, ?, ?, ?)");
                if ($stmt->execute([$kasutaja['kasutaja_id'], $teenusId, $tookohtId, $kuupaev, $algusAeg, $loppAeg])) {
                    $teade = '<div class="alert alert-success">Broneering edukalt lisatud!</div>';
                } else {
                    $teade = '<div class="alert alert-danger">Broneeringu lisamisel tekkis viga!</div>';
                }
            }
        }
    }
}

// Kasutaja broneeringute laadimine
$kasutajaBroneeringud = [];
if ($kasutaja && $kasutaja['kasutaja_tyyp'] === 'klient') {
    $stmt = $pdo->prepare("SELECT b.*, t.nimi as teenus_nimi, t.hind, tk.nimi as tookoht_nimi 
                          FROM broneeringud b 
                          JOIN teenused t ON b.teenus_id = t.id 
                          JOIN tookohad tk ON b.tookoht_id = tk.id 
                          WHERE b.klient_id = ? 
                          ORDER BY b.kuupaev DESC, b.algus_aeg DESC");
    $stmt->execute([$kasutaja['kasutaja_id']]);
    $kasutajaBroneeringud = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #64748b;
            --accent-color: #f97316;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
        }
        
        .navbar-brand {
            font-weight: bold;
            color: var(--primary-color) !important;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 4rem 0;
        }
        
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
        }
        
        .btn-warning {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .footer {
            background-color: #1f2937;
            color: white;
            padding: 2rem 0;
            margin-top: 4rem;
        }
        
        .booking-status {
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status-kinnitatud {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .status-tyhistatud {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .status-valmis {
            background-color: #dbeafe;
            color: #1e40af;
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
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Avaleht</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#teenused">Teenused</a>
                    </li>
                    <?php if ($kasutaja): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#broneeringud">Minu broneeringud</a>
                    </li>
                    <?php endif; ?>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if ($kasutaja): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>
                                <?php echo htmlspecialchars($kasutaja['eesnimi'] . ' ' . $kasutaja['perekonnanimi']); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logi välja
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Logi sisse
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">
                                <i class="bi bi-person-plus me-1"></i>Registreeru
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero sektsioon -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Autoremondi Teenuste Broneerimine</h1>
                    <p class="lead mb-4">Professionaalsed autoremondi teenused kogenud meestelt. Broneeri aeg mugavalt veebis ja säästa aega!</p>
                    <?php if (!$kasutaja): ?>
                    <div class="d-flex gap-3">
                        <a href="register.php" class="btn btn-light btn-lg">
                            <i class="bi bi-person-plus me-2"></i>Registreeru
                        </a>
                        <a href="login.php" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Logi sisse
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <i class="bi bi-car-front display-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-4">
        <?php echo $teade; ?>
        
        <!-- Teenused -->
        <section id="teenused" class="mb-5">
            <h2 class="mb-4">
                <i class="bi bi-tools me-2"></i>Meie Teenused
            </h2>
            
            <div class="row">
                <?php 
                $kategoriad = [];
                foreach ($teenused as $teenus) {
                    $kategoriad[$teenus['kategooria']][] = $teenus;
                }
                
                foreach ($kategoriad as $kategooria => $kategooriateenused): ?>
                    <div class="col-12 mb-4">
                        <h4 class="text-primary mb-3"><?php echo htmlspecialchars($kategooria); ?></h4>
                        <div class="row">
                            <?php foreach ($kategooriateenused as $teenus): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card service-card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($teenus['nimi']); ?></h5>
                                        <p class="card-text text-muted"><?php echo htmlspecialchars($teenus['kirjeldus']); ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-primary fw-bold"><?php echo number_format($teenus['hind'], 2); ?> €</span>
                                            <small class="text-muted"><?php echo $teenus['kestus']; ?> min</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Broneerimise vorm -->
        <?php if ($kasutaja && $kasutaja['kasutaja_tyyp'] === 'klient'): ?>
        <section class="mb-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="bi bi-calendar-plus me-2"></i>Broneeri Teenus
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="teenus_id" class="form-label">Teenus *</label>
                                <select class="form-select" id="teenus_id" name="teenus_id" required>
                                    <option value="">Vali teenus...</option>
                                    <?php foreach ($kategoriad as $kategooria => $kategooriateenused): ?>
                                        <optgroup label="<?php echo htmlspecialchars($kategooria); ?>">
                                            <?php foreach ($kategooriateenused as $teenus): ?>
                                                <option value="<?php echo $teenus['id']; ?>" 
                                                        data-kestus="<?php echo $teenus['kestus']; ?>"
                                                        data-hind="<?php echo $teenus['hind']; ?>">
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
                                        <option value="<?php echo $tookoht['id']; ?>">
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
                                       min="<?php echo date('Y-m-d'); ?>" required>
                                <div class="invalid-feedback">Palun vali kuupäev.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="algus_aeg" class="form-label">Kellaaeg *</label>
                                <input type="time" class="form-control" id="algus_aeg" name="algus_aeg" 
                                       min="08:00" max="17:00" step="900" required>
                                <div class="invalid-feedback">Palun vali kellaaeg (08:00-17:00).</div>
                                <small class="form-text text-muted">Tööaeg: 08:00-17:00</small>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" name="broneeri" class="btn btn-primary btn-lg">
                                <i class="bi bi-calendar-check me-2"></i>Broneeri
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Kasutaja broneeringud -->
        <?php if ($kasutaja && $kasutaja['kasutaja_tyyp'] === 'klient' && !empty($kasutajaBroneeringud)): ?>
        <section id="broneeringud" class="mb-5">
            <h3 class="mb-4">
                <i class="bi bi-calendar-event me-2"></i>Minu Broneeringud
            </h3>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Kuupäev</th>
                            <th>Kellaaeg</th>
                            <th>Teenus</th>
                            <th>Töökoht</th>
                            <th>Hind</th>
                            <th>Staatus</th>
                            <th>Tegevused</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kasutajaBroneeringud as $broneering): ?>
                        <tr>
                            <td><?php echo formateeriKuupaev($broneering['kuupaev']); ?></td>
                            <td><?php echo formateeriAeg($broneering['algus_aeg']) . ' - ' . formateeriAeg($broneering['lopp_aeg']); ?></td>
                            <td><?php echo htmlspecialchars($broneering['teenus_nimi']); ?></td>
                            <td><?php echo htmlspecialchars($broneering['tookoht_nimi']); ?></td>
                            <td><?php echo number_format($broneering['hind'], 2); ?> €</td>
                            <td>
                                <span class="booking-status status-<?php echo $broneering['staatus']; ?>">
                                    <?php 
                                    $staatused = [
                                        'kinnitatud' => 'Kinnitatud',
                                        'tyhistatud' => 'Tühistatud',
                                        'valmis' => 'Valmis'
                                    ];
                                    echo $staatused[$broneering['staatus']];
                                    ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($broneering['staatus'] === 'kinnitatud' && onMuudetav($broneering['kuupaev'], $broneering['algus_aeg'])): ?>
                                <div class="btn-group btn-group-sm">
                                    <a href="muuda_broneering.php?id=<?php echo $broneering['id']; ?>" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="tyhista_broneering.php?id=<?php echo $broneering['id']; ?>" 
                                       class="btn btn-outline-danger"
                                       onclick="return confirm('Kas olete kindel, et soovite broneeringu tühistada?')">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                </div>
                                <?php else: ?>
                                <small class="text-muted">Mittemuudetav</small>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-wrench-adjustable me-2"></i>AutoRemont</h5>
                    <p class="mb-0">Professionaalsed autoremondi teenused alates 2024. aastast.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        <i class="bi bi-clock me-1"></i>Tööaeg: E-R 8:00-17:00<br>
                        <i class="bi bi-telephone me-1"></i>Tel: +372 123 4567<br>
                        <i class="bi bi-envelope me-1"></i>Email: info@autoremondi.ee
                    </p>
                </div>
            </div>
        </div>
    </footer>

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
        
        // Kuupäeva piirang (mitte minevikku)
        document.getElementById('kuupaev').min = new Date().toISOString().split('T')[0];
    </script>
</body>
</html>