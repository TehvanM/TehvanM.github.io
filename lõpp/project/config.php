<?php
// Andmebaasi seaded
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'autoremontiks');

// Session käivitamine
session_start();

// Andmebaasi ühendus
function getDB() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        die("Andmebaasi ühenduse viga: " . $e->getMessage());
    }
}

// Kasutaja sisselogimise kontroll
function onSisselogitud() {
    return isset($_SESSION['kasutaja_id']);
}

// Kasutaja rolli kontroll
function onTootaja() {
    return isset($_SESSION['roll']) && $_SESSION['roll'] === 'tootaja';
}

// Eesti isikukoodi validaatori
function valideeruIsikukood($kood) {
    if (!preg_match('/^\d{11}$/', $kood)) return false;
    
    $kaalud1 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 1];
    $kaalud2 = [3, 4, 5, 6, 7, 8, 9, 1, 2, 3];
    
    $summa = 0;
    for ($i = 0; $i < 10; $i++) {
        $summa += intval($kood[$i]) * $kaalud1[$i];
    }
    
    $kontroll = $summa % 11;
    if ($kontroll === 10) {
        $summa = 0;
        for ($i = 0; $i < 10; $i++) {
            $summa += intval($kood[$i]) * $kaalud2[$i];
        }
        $kontroll = $summa % 11;
        if ($kontroll === 10) $kontroll = 0;
    }
    
    return $kontroll == intval($kood[10]);
}

// Broneeringu konfliktikontroll
function kontrolliKonflikti($kuupaev, $kellaaeg, $tookoht, $kestus, $broneering_id = null) {
    $db = getDB();
    
    $lopp_aeg = date('H:i:s', strtotime($kellaaeg . ' + ' . $kestus . ' hours'));
    
    $sql = "SELECT COUNT(*) FROM broneeringud b 
            JOIN teenused t ON b.teenus_id = t.id 
            WHERE b.kuupaev = ? AND b.tookoht = ? AND b.staatus = 'kinnitatud'
            AND (
                (b.kellaaeg <= ? AND DATE_ADD(CONCAT(b.kuupaev, ' ', b.kellaaeg), INTERVAL t.kestus_tunnid HOUR) > ?)
                OR (? < DATE_ADD(CONCAT(b.kuupaev, ' ', b.kellaaeg), INTERVAL t.kestus_tunnid HOUR) AND ? >= b.kellaaeg)
            )";
    
    $params = [$kuupaev, $tookoht, $kellaaeg, $kuupaev . ' ' . $kellaaeg, $kuupaev . ' ' . $kellaaeg, $kuupaev . ' ' . $lopp_aeg];
    
    if ($broneering_id) {
        $sql .= " AND b.id != ?";
        $params[] = $broneering_id;
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    
    return $stmt->fetchColumn() > 0;
}

// Tühistamise aja kontroll (24h)
function saabTyhistada($kuupaev, $kellaaeg) {
    $broneering_aeg = strtotime($kuupaev . ' ' . $kellaaeg);
    $praegu = time();
    $erinevus = $broneering_aeg - $praegu;
    
    return $erinevus >= (24 * 3600); // 24 tundi sekundites
}
?>