<?php
require_once 'config.php';

if (!onSisselogitud() || !onTootaja()) {
    header('Location: index.php');
    exit;
}

$db = getDB();

// Broneeringu staatus muutmine
if (isset($_GET['muuda_staatus'])) {
    $broneering_id = $_GET['muuda_staatus'];
    $uus_staatus = $_GET['staatus'];
    
    $stmt = $db->prepare("UPDATE broneeringud SET staatus = ? WHERE id = ?");
    if ($stmt->execute([$uus_staatus, $broneering_id])) {
        $edu = "Broneeringu staatus muudetud!";
    }
}

// Teenuse lisamine
if ($_POST && isset($_POST['lisa_teenus'])) {
    $nimi = trim($_POST['nimi']);
    $kirjeldus = trim($_POST['kirjeldus']);
    $kestus = intval($_POST['kestus_tunnid']);
    $hind = floatval($_POST['hind']);
    
    $stmt = $db->prepare("INSERT INTO teenused (nimi, kirjeldus, kestus_tunnid, hind) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$nimi, $kirjeldus, $kestus, $hind])) {
        $edu = "Teenus edukalt lisatud!";
    }
}

// Kõik broneeringud koos detailidega
$stmt = $db->prepare("
    SELECT b.*, 
           t.nimi as teenus_nimi, t.hind, t.kestus_tunnid,
           k.eesnimi, k.perenimi, k.email, k.isikukood
    FROM broneeringud b 
    JOIN teenused t ON b.teenus_id = t.id 
    JOIN kliendid k ON b.klient_id = k.id 
    ORDER BY b.kuupaev ASC, b.kellaaeg ASC
");
$stmt->execute();
$broneeringud = $stmt->fetchAll();

// Kõik teenused
$stmt = $db->prepare("SELECT * FROM teenused ORDER BY nimi");
$stmt->execute();
$teenused = $stmt->fetchAll();

// Statistika
$stmt = $db->prepare("SELECT COUNT(*) as kokku FROM broneeringud WHERE staatus = 'kinnitatud'");
$stmt->execute();
$kinnitatud_broneeringud = $stmt->fetch()['kokku'];

$stmt = $db->prepare("SELECT COUNT(*) as kokku FROM kliendid");
$stmt->execute();
$klientide_arv = $stmt->fetch()['kokku'];
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halduspaneel - AutoRemontiks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #ea580c;
        }
        .bg-primary-custom { background-color: var(--primary-color) !important; }
        .btn-primary-custom { background-color: var(--primary-color); border-color: var(--primary-color); }
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .stat-card {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigatsioon -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary-custom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="fas fa-wrench me-2"></i>AutoRemontiks
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Halduspaneel</span>
                <a href="index.php" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-home"></i> Avaleht
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <?php if (isset($edu)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo $edu; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Statistika -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card card-custom stat-card">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-check fa-3x mb-3"></i>
                        <h3><?php echo $kinnitatud_broneeringud; ?></h3>
                        <p class="mb-0">Kinnitatud broneeringut</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card card-custom stat-card">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x mb-3"></i>
                        <h3><?php echo $klientide_arv; ?></h3>
                        <p class="mb-0">Registreeritud klienti</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Broneeringute haldus -->
            <div class="col-lg-8 mb-4">
                <div class="card card-custom">
                    <div class="card-header bg-primary-custom text-white">
                        <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Kõik broneeringud</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($broneeringud)): ?>
                            <p class="text-muted text-center">Ühtegi broneeringut pole veel tehtud.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Klient</th>
                                            <th>Teenus</th>
                                            <th>Kuupäev</th>
                                            <th>Kellaaeg</th>
                                            <th>Töökoht</th>
                                            <th>Staatus</th>
                                            <th>Tegevused</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($broneeringud as $broneering): ?>
                                            <tr class="<?php echo $broneering['staatus'] === 'tyhistatud' ? 'table-light' : ''; ?>">
                                                <td>
                                                    <strong><?php echo htmlspecialchars($broneering['eesnimi'] . ' ' . $broneering['perenimi']); ?></strong><br>
                                                    <small class="text-muted"><?php echo htmlspecialchars($broneering['email']); ?></small>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($broneering['teenus_nimi']); ?><br>
                                                    <small class="text-muted"><?php echo $broneering['kestus_tunnid']; ?>h, <?php echo number_format($broneering['hind'], 2); ?>€</small>
                                                </td>
                                                <td><?php echo date('d.m.Y', strtotime($broneering['kuupaev'])); ?></td>
                                                <td><?php echo $broneering['kellaaeg']; ?></td>
                                                <td><?php echo htmlspecialchars($broneering['tookoht']); ?></td>
                                                <td>
                                                    <?php if ($broneering['staatus'] === 'kinnitatud'): ?>
                                                        <span class="badge bg-success">Kinnitatud</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Tühistatud</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($broneering['staatus'] === 'kinnitatud'): ?>
                                                        <a href="?muuda_staatus=<?php echo $broneering['id']; ?>&staatus=tyhistatud" 
                                                           class="btn btn-outline-danger btn-sm"
                                                           onclick="return confirm('Kas tühistada broneering?')">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="?muuda_staatus=<?php echo $broneering['id']; ?>&staatus=kinnitatud" 
                                                           class="btn btn-outline-success btn-sm">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Teenuste haldus -->
            <div class="col-lg-4">
                <!-- Uue teenuse lisamine -->
                <div class="card card-custom mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Lisa teenus</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Teenuse nimi</label>
                                <input type="text" name="nimi" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kirjeldus</label>
                                <textarea name="kirjeldus" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kestus (tundides)</label>
                                <input type="number" name="kestus_tunnid" class="form-control" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hind (€)</label>
                                <input type="number" name="hind" class="form-control" step="0.01" min="0" required>
                            </div>
                            <button type="submit" name="lisa_teenus" class="btn btn-secondary w-100">
                                <i class="fas fa-plus me-2"></i>Lisa teenus
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Olemasolevad teenused -->
                <div class="card card-custom">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Teenused</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($teenused as $teenus): ?>
                            <div class="card mb-2">
                                <div class="card-body p-3">
                                    <h6 class="card-title mb-1"><?php echo htmlspecialchars($teenus['nimi']); ?></h6>
                                    <p class="card-text mb-1 small"><?php echo htmlspecialchars($teenus['kirjeldus']); ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted"><?php echo $teenus['kestus_tunnid']; ?>h</small>
                                        <span class="fw-bold text-success"><?php echo number_format($teenus['hind'], 2); ?>€</span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>