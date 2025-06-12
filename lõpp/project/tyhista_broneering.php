<?php
require_once 'config.php';

// Kontrolli kas kasutaja on klient
$kasutaja = kontrolliSessiooni();
if (!$kasutaja || $kasutaja['kasutaja_tyyp'] !== 'klient') {
    header('Location: login.php');
    exit;
}

$broneeringId = intval($_GET['id'] ?? 0);

// Leia broneering
$stmt = $pdo->prepare("SELECT * FROM broneeringud WHERE id = ? AND klient_id = ?");
$stmt->execute([$broneeringId, $kasutaja['kasutaja_id']]);
$broneering = $stmt->fetch();

if (!$broneering) {
    header('Location: index.php');
    exit;
}

// Kontrolli kas broneering on tühistatav
if (!onMuudetav($broneering['kuupaev'], $broneering['algus_aeg']) || $broneering['staatus'] !== 'kinnitatud') {
    header('Location: index.php');
    exit;
}

// Tühista broneering
$stmt = $pdo->prepare("UPDATE broneeringud SET staatus = 'tyhistatud' WHERE id = ?");
$stmt->execute([$broneeringId]);

header('Location: index.php#broneeringud');
exit;
?>