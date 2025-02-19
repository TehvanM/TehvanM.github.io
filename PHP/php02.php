<?php
// Ülesanne 2, [Sinu Nimi], [Kuupäev]

// 1. Täisarvuliste muutujate loomine ja tehted
$a = 15;
$b = 4;

$summa = $a + $b;
$vahe = $a - $b;
$korrutis = $a * $b;
$jagatis = $a / $b;
$jaak = $a % $b;

echo "$a + $b = $summa<br>";
echo "$a - $b = $vahe<br>";
echo "$a * $b = $korrutis<br>";
echo "$a / $b = $jagatis<br>";
echo "$a % $b = $jaak<br><br>";

// 2. Millimeetrite teisendamine sentimeetriteks ja meetriteks
$millimeetrid = 1234;
$sentimeetrid = $millimeetrid / 10;
$meetrid = $millimeetrid / 1000;

echo "$millimeetrid mm on " . number_format($sentimeetrid, 2) . " cm<br>";
echo "$millimeetrid mm on " . number_format($meetrid, 2) . " m<br><br>";

// 3. Täisnurkse kolmnurga ümbermõõt ja pindala
$külg1 = 5;
$külg2 = 12;
$hüpotenuus = sqrt($külg1 ** 2 + $külg2 ** 2);

$ümbermõõt = $külg1 + $külg2 + $hüpotenuus;
$pindala = ($külg1 * $külg2) / 2;

$ümbermõõt_ümardatud = round($ümbermõõt);
$pindala_ümardatud = round($pindala);

echo "Täisnurkse kolmnurga ümbermõõt on $ümbermõõt_ümardatud ühikut.<br>";
echo "Täisnurkse kolmnurga pindala on $pindala_ümardatud ühikut.<br>";
?>