<?php
require_once 'config.php';

if (!onSisselogitud() || onTootaja()) {
    header('Location: index.php');
    exit;
}

$db = getDB();

// Kliendi andmete leidmine
$stmt = $db->prepare("SELECT * FROM kliendid WHERE kasutaja_id = ?");
$stmt->execute([$_SESSION['kasutaja_id']]);
$klient = $stmt->fetch();

if (!$klient) {
    die("Kliendi andmeid ei leitud!");
}

// Broneering
if ($_POST && isset($_POST['broneeringus'])) {
    $teenus_id = $_POST['teenus_id'];
    $kuupaev = $_POST['kuupaev'];
    $kellaaeg = $_POST['kellaaeg'];
    $tookoht = $_POST['tookoht'];
    
    // Teenuse andmete leidmine
    $stmt = $db->prepare("SELECT * FROM teenused WHERE id = ?");
    $stmt->execute([$teenus_id]);
    $teenus = $stmt->fetch();
    
    if ($teenus && !kontrolliKonflikti($kuupaev, $kellaaeg, $tookoht, $teenus['kestus_tunnid'])) {
        $stmt = $db->prepare("INSERT INTO broneeringud (klient_id, teenus_id, kuupaev, kellaaeg, tookoht) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$klient['id'], $teenus_id, $kuupaev, $kellaaeg, $tookoht])) {
            $edu = "Broneering edukalt lisatud!";
        } else {
            $viga = "Broneeringu lisamine ebaõnnestus!";
        }
    } else {
        $viga = "Valitud aeg on juba broneeritud!";
    }
}

// Broneeringu tühistamine
if (isset($_GET['tyhistada'])) {
    $broneering_id = $_GET['tyhistada'];
    
    $stmt = $db->prepare("SELECT b.*, t.kestus_tunnid FROM broneeringud b JOIN teenused t ON b.teenus_id = t.id WHERE b.id = ? AND b.klient_id = ?");
    $stmt->execute([$broneering_id, $klient['id']]);
    $broneering = $stmt->fetch();
    
    if ($broneering && saabTyhistada($broneering['kuupaev'], $broneering['kellaaeg'])) {
        $stmt = $db->prepare("UPDATE broneeringud SET staatus = 'tyhistatud' WHERE id = ?");
        if ($stmt->execute([$broneering_id])) {
            $edu = "Broneering edukalt tühistatud!";
        }
    } else {
        $viga = "Broneeringut ei saa tühistada (vähem kui 24h jäänud)!";
    }
}

// Kasutaja broneeringud
$stmt = $db->prepare("
    SELECT b.*, t.nimi as teenus_nimi, t.hind, t.kestus_tunnid 
    FROM broneeringud b 
    JOIN teenused t ON b.teenus_id = t.id 
    WHERE b.klient_id = ? 
    ORDER BY b.kuupaev DESC, b.kellaaeg DESC
");
$stmt->execute([$klient['id']]);
$broneeringud = $stmt->fetchAll();

// Teenused
$stmt = $db->prepare("SELECT * FROM teenused WHERE aktiivne = 1");
$stmt->execute();
$teenused = $stmt->fetchAll();

// Töökohtade nimekiri
$tookoht_list = ['Töökoht 1', 'Töökoht 2', 'Töökoht 3', 'Töökoht 4'];
$kellaaeg_list = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broneering - AutoRemontiks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #ea580c;
        }
        .bg-primary-custom { background-color: var(--primary-color) !important; }
        .btn-primary-custom { background-color: var(--primary-color); border-color: var(--primary-color); }
        .btn-secondary-custom { background-color: var(--secondary-color); border-color: var(--secondary-color); }
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
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
                <span class="navbar-text me-3">Tere, <?php echo htmlspecialchars($klient['eesnimi']); ?>!</span>
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
        
        <?php if (isset($viga)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo $viga; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Uue broneeringu vorm -->
            <div class="col-lg-6 mb-4">
                <div class="card card-custom">
                    <div class="card-header bg-primary-custom text-white">
                        <h5 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>Uus broneering</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Teenus</label>
                                <select name="teenus_id" class="form-select" required>
                                    <option value="">Vali teenus...</option>
                                    <?php foreach ($teenused as $teenus): ?>
                                        <option value="<?php echo $teenus['id']; ?>">
                                            <?php echo htmlspecialchars($teenus['nimi']); ?> 
                                            (<?php echo $teenus['kestus_tunnid']; ?>h, <?php echo number_format($teenus['hind'], 2); ?>€)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kuupäev</label>
                                <input type="date" name="kuupaev" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kellaaeg</label>
                                <select name="kellaaeg" class="form-select" required>
                                    <option value="">Vali kellaaeg...</option>
                                    <?php foreach ($kellaaeg_list as $aeg): ?>
                                        <option value="<?php echo $aeg; ?>"><?php echo $aeg; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Töökoht</label>
                                <select name="tookoht" class="form-select" required>
                                    <option value="">Vali töökoht...</option>
                                    <?php foreach ($tookoht_list as $koht): ?>
                                        <option value="<?php echo $koht; ?>"><?php echo $koht; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" name="broneeringus" class="btn btn-primary-custom">
                                <i class="fas fa-check me-2"></i>Broneeri
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Olemasolevad broneeringud -->
            <div class="col-lg-6">
                <div class="card card-custom">
                    <div class="card-header bg-secondary-custom text-white">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Minu broneeringud</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($broneeringud)): ?>
                            <p class="text-muted text-center">Ühtegi broneeringut pole veel tehtud.</p>
                        <?php else: ?>
                            <?php foreach ($broneeringud as $broneering): ?>
                                <div class="card mb-3 <?php echo $broneering['staatus'] === 'tyhistatud' ? 'bg-light' : ''; ?>">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="card-title <?php echo $broneering['staatus'] === 'tyhistatud' ? 'text-muted' : 'text-primary-custom'; ?>">
                                                    <?php echo htmlspecialchars($broneering['teenus_nimi']); ?>
                                                    <?php if ($broneering['staatus'] === 'tyhistatud'): ?>
                                                        <span class="badge bg-danger ms-2">Tühistatud</span>
                                                    <?php endif; ?>
                                                </h6>
                                                <p class="card-text mb-1">
                                                    <i class="fas fa-calendar me-2"></i><?php echo date('d.m.Y', strtotime($broneering['kuupaev'])); ?>
                                                    <i class="fas fa-clock ms-3 me-2"></i><?php echo $broneering['kellaaeg']; ?>
                                                </p>
                                                <p class="card-text mb-0">
                                                    <i class="fas fa-tools me-2"></i><?php echo htmlspecialchars($broneering['tookoht']); ?>
                                                    <span class="ms-3 text-success fw-bold"><?php echo number_format($broneering['hind'], 2); ?>€</span>
                                                </p>
                                            </div>
                                            <?php if ($broneering['staatus'] === 'kinnitatud' && saabTyhistada($broneering['kuupaev'], $broneering['kellaaeg'])): ?>
                                                <a href="?tyhistada=<?php echo $broneering['id']; ?>" 
                                                   class="btn btn-outline-danger btn-sm"
                                                   onclick="return confirm('Kas oled kindel, et soovid broneeringu tühistada?')">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>