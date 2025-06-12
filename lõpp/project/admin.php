                                                                            <?php
require_once 'config.php';

// Kontrolli kas kasutaja on töötaja
$kasutaja = kontrolliSessiooni();
if (!$kasutaja || $kasutaja['kasutaja_tyyp'] !== 'toottaja') {
    header('Location: login.php');
    exit;
}

$teade = '';
$aktiivsedTabid = ['dashboard' => 'active', 'broneeringud' => '', 'teenused' => '', 'kliendid' => ''];

// Tabi määramine
if (isset($_GET['tab'])) {
    $tab = $_GET['tab'];
    foreach ($aktiivsedTabid as $key => $value) {
        $aktiivsedTabid[$key] = ($key === $tab) ? 'active' : '';
    }
}

// Statistika
$stmt = $pdo->query("SELECT COUNT(*) FROM broneeringud WHERE staatus = 'kinnitatud'");
$kinnitatudBroneeringud = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM kliendid");
$kliendidKokku = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM teenused WHERE aktiivne = 1");
$aktiivsedTeenused = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT SUM(t.hind) FROM broneeringud b JOIN teenused t ON b.teenus_id = t.id WHERE b.staatus = 'valmis' AND MONTH(b.kuupaev) = MONTH(CURRENT_DATE())");
$kuuKaive = $stmt->fetchColumn() ?: 0;

// Teenuse lisamine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lisa_teenus'])) {
    $nimi = trim($_POST['teenus_nimi']);
    $kirjeldus = trim($_POST['teenus_kirjeldus']);
    $kestus = intval($_POST['teenus_kestus']);
    $hind = floatval($_POST['teenus_hind']);
    $kategooria = trim($_POST['teenus_kategooria']);
    
    if ($nimi && $kestus > 0 && $hind > 0 && $kategooria) {
        $stmt = $pdo->prepare("INSERT INTO teenused (nimi, kirjeldus, kestus, hind, kategooria) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$nimi, $kirjeldus, $kestus, $hind, $kategooria])) {
            $teade = '<div class="alert alert-success">Teenus lisatud edukalt!</div>';
        } else {
            $teade = '<div class="alert alert-danger">Teenuse lisamisel tekkis viga!</div>';
        }
    } else {
        $teade = '<div class="alert alert-danger">Palun täitke kõik kohustuslikud väljad!</div>';
    }
}

// Teenuse muutmine/kustutamine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['muuda_teenus'])) {
    $id = intval($_POST['teenus_id']);
    $nimi = trim($_POST['teenus_nimi']);
    $kirjeldus = trim($_POST['teenus_kirjeldus']);
    $kestus = intval($_POST['teenus_kestus']);
    $hind = floatval($_POST['teenus_hind']);
    $kategooria = trim($_POST['teenus_kategooria']);
    $aktiivne = isset($_POST['teenus_aktiivne']) ? 1 : 0;
    
    if ($id && $nimi && $kestus > 0 && $hind > 0 && $kategooria) {
        $stmt = $pdo->prepare("UPDATE teenused SET nimi = ?, kirjeldus = ?, kestus = ?, hind = ?, kategooria = ?, aktiivne = ? WHERE id = ?");
        if ($stmt->execute([$nimi, $kirjeldus, $kestus, $hind, $kategooria, $aktiivne, $id])) {
            $teade = '<div class="alert alert-success">Teenus muudetud edukalt!</div>';
        } else {
            $teade = '<div class="alert alert-danger">Teenuse muutmisel tekkis viga!</div>';
        }
    }
}

// Broneeringu staatuse muutmine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['muuda_broneeringut'])) {
    $id = intval($_POST['broneering_id']);
    $staatus = $_POST['broneering_staatus'];
    $markused = trim($_POST['broneering_markused']);
    
    if ($id && in_array($staatus, ['kinnitatud', 'tyhistatud', 'valmis'])) {
        $stmt = $pdo->prepare("UPDATE broneeringud SET staatus = ?, markused = ? WHERE id = ?");
        if ($stmt->execute([$staatus, $markused, $id])) {
            $teade = '<div class="alert alert-success">Broneering muudetud edukalt!</div>';
        } else {
            $teade = '<div class="alert alert-danger">Broneeringu muutmisel tekkis viga!</div>';
        }
    }
}

// Andmete laadimine
$broneeringud = [];
$teenused = [];
$kliendid = [];

if (empty($_GET['tab']) || $_GET['tab'] === 'dashboard' || $_GET['tab'] === 'broneeringud') {
    $stmt = $pdo->prepare("SELECT b.*, t.nimi as teenus_nimi, t.hind, t.kestus, 
                          tk.nimi as tookoht_nimi, k.eesnimi, k.perekonnanimi, k.email, k.telefon
                          FROM broneeringud b 
                          JOIN teenused t ON b.teenus_id = t.id 
                          JOIN tookohad tk ON b.tookoht_id = tk.id 
                          JOIN kliendid k ON b.klient_id = k.id 
                          ORDER BY b.kuupaev DESC, b.algus_aeg DESC");
    $stmt->execute();
    $broneeringud = $stmt->fetchAll();
}

if (empty($_GET['tab']) || $_GET['tab'] === 'teenused') {
    $stmt = $pdo->prepare("SELECT * FROM teenused ORDER BY kategooria, nimi");
    $stmt->execute();
    $teenused = $stmt->fetchAll();
}

if (empty($_GET['tab']) || $_GET['tab'] === 'kliendid') {
    $stmt = $pdo->prepare("SELECT k.*, COUNT(b.id) as broneeringute_arv 
                          FROM kliendid k 
                          LEFT JOIN broneeringud b ON k.id = b.klient_id 
                          GROUP BY k.id 
                          ORDER BY k.loodud DESC");
    $stmt->execute();
    $kliendid = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneel - <?php echo SITE_NAME; ?></title>
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
        
        .sidebar {
            background-color: #f8fafc;
            min-height: calc(100vh - 76px);
            border-right: 1px solid #e2e8f0;
        }
        
        .nav-link {
            color: var(--secondary-color);
            font-weight: 500;
        }
        
        .nav-link.active {
            background-color: var(--primary-color) !important;
            color: white !important;
            border-radius: 0.5rem;
        }
        
        .stat-card {
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
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
        
        .table th {
            background-color: #f8fafc;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <!-- Navigatsioon -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="admin.php">
                <i class="bi bi-wrench-adjustable me-2"></i>
                AutoRemont Admin
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

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-3">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link <?php echo $aktiivsedTabid['dashboard']; ?>" href="admin.php?tab=dashboard">
                            <i class="bi bi-speedometer2 me-2"></i>Ülevaade
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link <?php echo $aktiivsedTabid['broneeringud']; ?>" href="admin.php?tab=broneeringud">
                            <i class="bi bi-calendar-event me-2"></i>Broneeringud
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link <?php echo $aktiivsedTabid['teenused']; ?>" href="admin.php?tab=teenused">
                            <i class="bi bi-tools me-2"></i>Teenused
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link <?php echo $aktiivsedTabid['kliendid']; ?>" href="admin.php?tab=kliendid">
                            <i class="bi bi-people me-2"></i>Kliendid
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Peamine sisu -->
            <div class="col-md-9 col-lg-10 p-4">
                <?php echo $teade; ?>

                <!-- Dashboard -->
                <?php if (empty($_GET['tab']) || $_GET['tab'] === 'dashboard'): ?>
                <div class="mb-4">
                    <h2><i class="bi bi-speedometer2 me-2"></i>Ülevaade</h2>
                </div>

                <!-- Statistika kaardid -->
                <div class="row mb-4">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card stat-card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-check display-4 text-primary mb-2"></i>
                                <h3 class="text-primary"><?php echo $kinnitatudBroneeringud; ?></h3>
                                <p class="text-muted mb-0">Kinnitatud broneeringud</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card stat-card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-people display-4 text-success mb-2"></i>
                                <h3 class="text-success"><?php echo $kliendidKokku; ?></h3>
                                <p class="text-muted mb-0">Registreeritud kliendid</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card stat-card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-tools display-4 text-warning mb-2"></i>
                                <h3 class="text-warning"><?php echo $aktiivsedTeenused; ?></h3>
                                <p class="text-muted mb-0">Aktiivsed teenused</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card stat-card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-currency-euro display-4 text-info mb-2"></i>
                                <h3 class="text-info"><?php echo number_format($kuuKaive, 2); ?>€</h3>
                                <p class="text-muted mb-0">Kuu käive</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Viimaseid broneeringuid -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Viimased broneeringud</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Kuupäev</th>
                                        <th>Klient</th>
                                        <th>Teenus</th>
                                        <th>Staatus</th>
                                        <th>Hind</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($broneeringud, 0, 10) as $broneering): ?>
                                    <tr>
                                        <td><?php echo formateeriKuupaev($broneering['kuupaev']) . ' ' . formateeriAeg($broneering['algus_aeg']); ?></td>
                                        <td><?php echo htmlspecialchars($broneering['eesnimi'] . ' ' . $broneering['perekonnanimi']); ?></td>
                                        <td><?php echo htmlspecialchars($broneering['teenus_nimi']); ?></td>
                                        <td>
                                            <span class="booking-status status-<?php echo $broneering['staatus']; ?>">
                                                <?php 
                                                $staatused = ['kinnitatud' => 'Kinnitatud', 'tyhistatud' => 'Tühistatud', 'valmis' => 'Valmis'];
                                                echo $staatused[$broneering['staatus']];
                                                ?>
                                            </span>
                                        </td>
                                        <td><?php echo number_format($broneering['hind'], 2); ?>€</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <a href="admin.php?tab=broneeringud" class="btn btn-primary">
                                <i class="bi bi-arrow-right me-1"></i>Vaata kõiki
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Broneeringud -->
                <?php if (isset($_GET['tab']) && $_GET['tab'] === 'broneeringud'): ?>
                <div class="mb-4">
                    <h2><i class="bi bi-calendar-event me-2"></i>Broneeringud</h2>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kuupäev/Aeg</th>
                                        <th>Klient</th>
                                        <th>Kontakt</th>
                                        <th>Teenus</th>
                                        <th>Töökoht</th>
                                        <th>Staatus</th>
                                        <th>Hind</th>
                                        <th>Tegevused</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($broneeringud as $broneering): ?>
                                    <tr>
                                        <td><?php echo $broneering['id']; ?></td>
                                        <td>
                                            <?php echo formateeriKuupaev($broneering['kuupaev']); ?><br>
                                            <small class="text-muted">
                                                <?php echo formateeriAeg($broneering['algus_aeg']) . ' - ' . formateeriAeg($broneering['lopp_aeg']); ?>
                                            </small>
                                        </td>
                                        <td><?php echo htmlspecialchars($broneering['eesnimi'] . ' ' . $broneering['perekonnanimi']); ?></td>
                                        <td>
                                            <small>
                                                <i class="bi bi-envelope me-1"></i><?php echo htmlspecialchars($broneering['email']); ?><br>
                                                <?php if ($broneering['telefon']): ?>
                                                <i class="bi bi-telephone me-1"></i><?php echo htmlspecialchars($broneering['telefon']); ?>
                                                <?php endif; ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($broneering['teenus_nimi']); ?><br>
                                            <small class="text-muted"><?php echo $broneering['kestus']; ?> min</small>
                                        </td>
                                        <td><?php echo htmlspecialchars($broneering['tookoht_nimi']); ?></td>
                                        <td>
                                            <span class="booking-status status-<?php echo $broneering['staatus']; ?>">
                                                <?php 
                                                $staatused = ['kinnitatud' => 'Kinnitatud', 'tyhistatud' => 'Tühistatud', 'valmis' => 'Valmis'];
                                                echo $staatused[$broneering['staatus']];
                                                ?>
                                            </span>
                                        </td>
                                        <td><?php echo number_format($broneering['hind'], 2); ?>€</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#muudaBroneeringuModal<?php echo $broneering['id']; ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Broneeringu muutmise modal -->
                                    <div class="modal fade" id="muudaBroneeringuModal<?php echo $broneering['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Muuda broneeringut #<?php echo $broneering['id']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="broneering_id" value="<?php echo $broneering['id']; ?>">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Staatus</label>
                                                            <select class="form-select" name="broneering_staatus">
                                                                <option value="kinnitatud" <?php echo $broneering['staatus'] === 'kinnitatud' ? 'selected' : ''; ?>>Kinnitatud</option>
                                                                <option value="tyhistatud" <?php echo $broneering['staatus'] === 'tyhistatud' ? 'selected' : ''; ?>>Tühistatud</option>
                                                                <option value="valmis" <?php echo $broneering['staatus'] === 'valmis' ? 'selected' : ''; ?>>Valmis</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Märkused</label>
                                                            <textarea class="form-control" name="broneering_markused" rows="3"><?php echo htmlspecialchars($broneering['markused'] ?? ''); ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tühista</button>
                                                        <button type="submit" name="muuda_broneeringut" class="btn btn-primary">Salvesta</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Teenused -->
                <?php if (isset($_GET['tab']) && $_GET['tab'] === 'teenused'): ?>
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <h2><i class="bi bi-tools me-2"></i>Teenused</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#lisaTeenusModal">
                        <i class="bi bi-plus-circle me-2"></i>Lisa teenus
                    </button>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nimi</th>
                                        <th>Kategooria</th>
                                        <th>Kestus</th>
                                        <th>Hind</th>
                                        <th>Staatus</th>
                                        <th>Tegevused</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($teenused as $teenus): ?>
                                    <tr>
                                        <td><?php echo $teenus['id']; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($teenus['nimi']); ?></strong><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($teenus['kirjeldus']); ?></small>
                                        </td>
                                        <td><?php echo htmlspecialchars($teenus['kategooria']); ?></td>
                                        <td><?php echo $teenus['kestus']; ?> min</td>
                                        <td><?php echo number_format($teenus['hind'], 2); ?>€</td>
                                        <td>
                                            <?php if ($teenus['aktiivne']): ?>
                                                <span class="badge bg-success">Aktiivne</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Mitteaktiivne</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#muudaTeenusModal<?php echo $teenus['id']; ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Teenuse muutmise modal -->
                                    <div class="modal fade" id="muudaTeenusModal<?php echo $teenus['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Muuda teenust</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="teenus_id" value="<?php echo $teenus['id']; ?>">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Nimi *</label>
                                                            <input type="text" class="form-control" name="teenus_nimi" value="<?php echo htmlspecialchars($teenus['nimi']); ?>" required>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Kirjeldus</label>
                                                            <textarea class="form-control" name="teenus_kirjeldus" rows="3"><?php echo htmlspecialchars($teenus['kirjeldus']); ?></textarea>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Kestus (minutites) *</label>
                                                                <input type="number" class="form-control" name="teenus_kestus" value="<?php echo $teenus['kestus']; ?>" min="1" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Hind (€) *</label>
                                                                <input type="number" class="form-control" name="teenus_hind" value="<?php echo $teenus['hind']; ?>" step="0.01" min="0" required>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Kategooria *</label>
                                                            <input type="text" class="form-control" name="teenus_kategooria" value="<?php echo htmlspecialchars($teenus['kategooria']); ?>" required>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="teenus_aktiivne" <?php echo $teenus['aktiivne'] ? 'checked' : ''; ?>>
                                                                <label class="form-check-label">Aktiivne</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tühista</button>
                                                        <button type="submit" name="muuda_teenus" class="btn btn-primary">Salvesta</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Lisa teenuse modal -->
                <div class="modal fade" id="lisaTeenusModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Lisa uus teenus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nimi *</label>
                                        <input type="text" class="form-control" name="teenus_nimi" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Kirjeldus</label>
                                        <textarea class="form-control" name="teenus_kirjeldus" rows="3"></textarea>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kestus (minutites) *</label>
                                            <input type="number" class="form-control" name="teenus_kestus" min="1" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Hind (€) *</label>
                                            <input type="number" class="form-control" name="teenus_hind" step="0.01" min="0" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Kategooria *</label>
                                        <input type="text" class="form-control" name="teenus_kategooria" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tühista</button>
                                    <button type="submit" name="lisa_teenus" class="btn btn-primary">Lisa teenus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Kliendid -->
                <?php if (isset($_GET['tab']) && $_GET['tab'] === 'kliendid'): ?>
                <div class="mb-4">
                    <h2><i class="bi bi-people me-2"></i>Kliendid</h2>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nimi</th>
                                        <th>Kontakt</th>
                                        <th>Isikukood</th>
                                        <th>Broneeringuid</th>
                                        <th>Registreeritud</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kliendid as $klient): ?>
                                    <tr>
                                        <td><?php echo $klient['id']; ?></td>
                                        <td><?php echo htmlspecialchars($klient['eesnimi'] . ' ' . $klient['perekonnanimi']); ?></td>
                                        <td>
                                            <i class="bi bi-envelope me-1"></i><?php echo htmlspecialchars($klient['email']); ?><br>
                                            <?php if ($klient['telefon']): ?>
                                            <i class="bi bi-telephone me-1"></i><?php echo htmlspecialchars($klient['telefon']); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($klient['isikukood']); ?></td>
                                        <td>
                                            <span class="badge bg-primary"><?php echo $klient['broneeringute_arv']; ?></span>
                                        </td>
                                        <td><?php echo formateeriKuupaev($klient['loodud']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>