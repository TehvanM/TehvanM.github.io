<?php
// -------------------------------------------------------------------------
// Ülesanne 2.1: Täisarvuliste muutujate tehete näide (ChatGPT, 2025-02-11)
function integerOperations() {
    $a = 10;
    $b = 3;
    
    // Liitmine, lahutamine, korrutamine, jagamine ja jäägi leidmine
    echo "$a + $b = " . ($a + $b) . "<br>";
    echo "$a - $b = " . ($a - $b) . "<br>";
    echo "$a * $b = " . ($a * $b) . "<br>";
    echo "$a / $b = " . ($a / $b) . "<br>";
    echo "$a % $b = " . ($a % $b) . "<br>";
}

// -------------------------------------------------------------------------
// Ülesanne 2.2: Millimeetrite teisendamine sentimeetriteks ja meetriteks
// (ChatGPT, 2025-02-11)
function convertMillimeters() {
    $mm = 1500;
    
    // 1 cm = 10 mm, 1 m = 1000 mm
    $cm = $mm / 10;
    $m  = $mm / 1000;
    
    // Väljund vormindatuna kahe koma järele
    echo "$mm mm = " . number_format($cm, 2, '.', '') . " cm<br>";
    echo "$mm mm = " . number_format($m, 2, '.', '') . " m<br>";
}

// -------------------------------------------------------------------------
// Ülesanne 2.3: Täisnurkse kolmnurga ümbermõõt ja pindala
// (ChatGPT, 2025-02-11)
function triangleCalculations() {
    $katet1 = 3;
    $katet2 = 4;
    
    // Hüpotenuus Pythagorase teoreemi abil
    $h = sqrt($katet1 * $katet1 + $katet2 * $katet2);
    
    // Ümbermõõt ja pindala
    $perimeter = $katet1 + $katet2 + $h;
    $area = 0.5 * $katet1 * $katet2;
    
    // Ümardame tulemused täisarvuni ja kuvatakse täislause kujul
    echo "Täisnurkse kolmnurga ümbermõõt on " . round($perimeter) . " ja pindala on " . round($area) . ".<br>";
}

// -------------------------------------------------------------------------
// Ülesanne 1: PHP - Muutujad
/**
 * PHP
 * 01-03 - PHP - Muutujad
 * Tehvan Marjapuu
 * Haapsalu Kutsehariduskeskus
 * 11.02.2025
 */
function phpVariablesTask() {
    $nimi = "Tanel";
    $sunniaasta = "2015";
    $tahtkuju = "Kaksikud";
    
    echo "Nimi: $nimi<br>";
    echo "Sünniaasta: $sunniaasta<br>";
    echo "Tähtkuju: $tahtkuju<br>";
    
    // Väljasta järgnev lause
    echo "\"It’s My Life\" – Dr. Alban<br>";
    
    // "Joonista" järgmine pilt
    echo "(\(\\<br>";
    echo "( -.-)<br>";
    echo "o_(\")(\")<br>";
}

// -------------------------------------------------------------------------
// Funktsioonide väljakutsed
integerOperations();
echo "<br>";
convertMillimeters();
echo "<br>";
triangleCalculations();
echo "<br>";
phpVariablesTask();
?>
