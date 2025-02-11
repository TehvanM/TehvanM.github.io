<?php
/**
 * PHP
 * 02 - PHP - Operaatorid
 * Tehvan Marjapuu
 * Haapsalu Kutsehariduskeskus
 * 11.02.2025
 */

$a = 15;
$b = 4;

echo "$a + $b = " . ($a + $b) . "<br>\n";
echo "$a - $b = " . ($a - $b) . "<br>\n";
echo "$a * $b = " . ($a * $b) . "<br>\n";
echo "$a / $b = " . ($a / $b) . "<br>\n";
echo "$a % $b = " . ($a % $b) . "<br><br>\n";

$millimeters = 1234; 
$centimeters = $millimeters / 10;
$meters = $millimeters / 1000;

echo "$millimeters mm = " . number_format($centimeters, 2) . " cm<br>\n";
echo "$millimeters mm = " . number_format($meters, 2) . " m<br><br>\n";

$sideA = 3;
$sideB = 4;
$sideC = sqrt($sideA * $sideA + $sideB * $sideB);

$perimeter = $sideA + $sideB + $sideC;
$area = ($sideA * $sideB) / 2;

echo "Täisnurkse kolmnurga ümbermõõt on " . round($perimeter) . " ühikut.<br>\n";
echo "Täisnurkse kolmnurga pindala on " . round($area) . " ruutühikut.<br>\n";
?>
