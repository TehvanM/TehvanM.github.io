<?php
// Andmebaasi konfiguratsioon
define('DB_HOST', 'localhost');
define('DB_NAME', 'tmarjapuu');
define('DB_USER', 'tmarjapuu');
define('DB_PASS', '9C3l+oxF6vuFhsRl');

// Rakenduse konfiguratsioon
define('SITE_NAME', 'AutoRemont - Tööde Haldamise Süsteem');
define('SITE_URL', 'http://localhost');

// Turvaseaded
define('SESSION_LIFETIME', 14400); // 4 tundi sekundites
define('HASH_ALGO', PASSWORD_DEFAULT);

// Ajavööndi seadmine
date_default_timezone_set('Europe/Tallinn');

// Andmebaasi ühendus
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    die("Andmebaasi ühenduse viga: " . $e->getMessage());
}

// Funktsioonid

/**
 * Kontrollib kasutaja sessiooni
 * @return array|false Kasutaja andmed või false
 */
function kontrolliSessiooni() {
    global $pdo;
    
    if (!isset($_COOKIE['session_id'])) {
        return false;
    }
    
    $stmt = $pdo->prepare("SELECT s.*, k.eesnimi, k.perekonnanimi, k.email, 'klient' as tyyp 
                          FROM sessioonid s 
                          JOIN kliendid k ON s.kasutaja_id = k.id 
                          WHERE s.id = ? AND s.kasutaja_tyyp = 'klient' AND s.kehtib_kuni > NOW()
                          UNION
                          SELECT s.*, t.eesnimi, t.perekonnanimi, t.email, 'toottaja' as tyyp 
                          FROM sessioonid s 
                          JOIN toottajad t ON s.kasutaja_id = t.id 
                          WHERE s.id = ? AND s.kasutaja_tyyp = 'toottaja' AND s.kehtib_kuni > NOW()");
    
    $sessionId = $_COOKIE['session_id'];
    $stmt->execute([$sessionId, $sessionId]);
    
    return $stmt->fetch();
}

/**
 * Loob uue sessiooni
 * @param int $kasutajaId Kasutaja ID
 * @param string $tyyp Kasutaja tüüp (klient/toottaja)
 */
function looSessioon($kasutajaId, $tyyp) {
    global $pdo;
    
    $sessionId = bin2hex(random_bytes(32));
    
    $stmt = $pdo->prepare("INSERT INTO sessioonid (id, kasutaja_id, kasutaja_tyyp) VALUES (?, ?, ?)");
    $stmt->execute([$sessionId, $kasutajaId, $tyyp]);
    
    // Seadista küpsis 4 tunniks
    setcookie('session_id', $sessionId, time() + SESSION_LIFETIME, '/', '', false, true);
}

/**
 * Hävitab sessiooni
 */
function havitaSessioon() {
    global $pdo;
    
    if (isset($_COOKIE['session_id'])) {
        $stmt = $pdo->prepare("DELETE FROM sessioonid WHERE id = ?");
        $stmt->execute([$_COOKIE['session_id']]);
        
        setcookie('session_id', '', time() - 3600, '/');
    }
}

/**
 * Valideerib eesti isikukoodi
 * @param string $isikukood
 * @return bool
 */
function valideeriIsikukood($isikukood) {
    if (strlen($isikukood) !== 11 || !ctype_digit($isikukood)) {
        return false;
    }
    
    // Kontrollnumbri arvutamine
    $kaalud1 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 1];
    $kaalud2 = [3, 4, 5, 6, 7, 8, 9, 1, 2, 3];
    
    $summa = 0;
    for ($i = 0; $i < 10; $i++) {
        $summa += intval($isikukood[$i]) * $kaalud1[$i];
    }
    
    $kontroll = $summa % 11;
    
    if ($kontroll === 10) {
        $summa = 0;
        for ($i = 0; $i < 10; $i++) {
            $summa += intval($isikukood[$i]) * $kaalud2[$i];
        }
        $kontroll = $summa % 11;
        if ($kontroll === 10) $kontroll = 0;
    }
    
    return $kontroll === intval($isikukood[10]);
}

/**
 * Valideerib e-maili aadressi
 * @param string $email
 * @return bool
 */
function valideeriEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Formateerib aja
 * @param string $aeg
 * @return string
 */
function formateeriAeg($aeg) {
    return date('H:i', strtotime($aeg));
}

/**
 * Formateerib kuupäeva
 * @param string $kuupaev
 * @return string
 */
function formateeriKuupaev($kuupaev) {
    return date('d.m.Y', strtotime($kuupaev));
}

/**
 * Kontrollib, kas broneering on muudetav (24h reegel)
 * @param string $kuupaev
 * @param string $aeg
 * @return bool
 */
function onMuudetav($kuupaev, $aeg) {
    $broneeringAeg = strtotime($kuupaev . ' ' . $aeg);
    $praegu = time();
    $vahe = $broneeringAeg - $praegu;
    
    return $vahe > 86400; // 24 tundi = 86400 sekundit
}
?>