<!-- Tehvan Marjapuu 1-3 -->

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Harjutus 1-3</title>
</head>
<body>

<h1>Harjutus 1 </h1>

<?php

echo '"It\'s My life - Dr.Alban"<br>';
echo "<br>";
echo "(\\(\\ <br>(-.-)<br>o_(\")(\")";
?>

<hr>

<h1>Harjutus 2 </h1>

<form method="get">
    Külg A: <input type="number" name="a"><br>
    Külg B: <input type="number" name="b"><br>
    <input type="submit" value="Arvuta kolmnurk">
</form>

<?php
if (isset($_GET["a"]) && isset($_GET["b"])) {
    $a = $_GET["a"];
    $b = $_GET["b"];
    $c = sqrt($a * $a + $b * $b);
    $pindala = $a * $b / 2;
    $ymbermoot = $a + $b + $c;

    echo "Külg A: $a<br>";
    echo "Külg B: $b<br>";
    echo "Pindala: $pindala<br>";
    echo "Ümbermõõt: $ymbermoot<br>";
}
?>

<hr>

<h1>Millimeetrid sentimeetriteks ja meetriteks</h1>

<form method="get">
    Sisesta millimeetrid: <input type="number" name="mm"><br>
    <input type="submit" value="Teisenda">
</form>

<?php
if (isset($_GET["mm"])) {
    $mm = $_GET["mm"];
    $cm = $mm / 10;
    $m = $mm / 1000;

    echo "$mm mm = $cm cm või $m m<br>";
}
?>

<hr>

<h1>Lihtsad arvutused</h1>

<?php
$a = 5;
$b = 7;

echo "$a + $b = " . ($a + $b) . "<br>";
echo "$a - $b = " . ($a - $b) . "<br>";
echo "$a / $b = " . ($a / $b) . "<br>";
echo "$a * $b = " . ($a * $b) . "<br>";
?>

<hr>

<h1>Harjutus 3 </h1>

<h2>
<form method="get">
    Külg A: <input type="number" name="a" required><br>
    Külg B: <input type="number" name="b" required><br>
    Kõrgus H: <input type="number" name="h" required><br>
    <input type="submit" value="Arvuta">
</form>

<?php
if (isset($_GET["a"]) && isset($_GET["b"]) && isset($_GET["h"])) {
    $a = $_GET["a"];
    $b = $_GET["b"];
    $h = $_GET["h"];

    $trapets = ($a + $b) / 2 * $h;
    $romb = 4 * $a;

    echo "Trapetsi pindala: $trapets<br>";
    echo "Rombi ümbermõõt: $romb<br>";
}
?>

</body>
</html>
