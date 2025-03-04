
<!-- // Tehvan Marjapuu 12.02.25
// Ülesanne 3 -->
<h1>Ülesanne 3</h1>
<form action="php01.php" method="get">
    Külg a <input type="number" name="a" required min=1><br>
    Külg b <input type="number" name="b" required min=1><br>
    Kõrgus h <input type="number" name="h" required min=1><br>
    <input type="submit" value="Arvuta"><br>
</form>
<?php
if(isset($_GET["a"])&&isset($_GET["b"])){
    $kylgA = $_GET["a"];
    $kylgB = $_GET["b"];
    $kylgH = $_GET["h"];
    $trapets_s=($kylg_a+$kylgB)/2*$kylgH;
    $romb_p = 4 * $kylgA;
    printf("Külg A:%d<br> Külg B:%d<br> Kõrgus: %d Trapetsi pindala: %.2f<br> Romb: %d", $kylgA, $kylgB, $kylgH, $trapets_s, $romb_p);
}



?>


<!-- // Tehvan Marjapuu 12.02.25
// Ülesanne 2 -->

<h1>Ülesanne 2</h1>
<h2>Kolmnurk</h2>

<form action="php01.php" method="get">
    a <input type="number" name="a"><br>
    b <input type="number" name="b"><br>
    <input type="submit" value="Teisenda"><br>
</form>
<?php

if(isset($_GET["a"])&&isset($_GET["b"])){
    $kylgA = $_GET["a"];
    $kylgB = $_GET["b"];
    $kylgC = sqrt(pow($kylgA,2) + pow($kylgB,2));
    $pindala = $kylgA * $kylgB / 2;
    $ymbermoot = $kylgA+$kylgB+$kylgC;
    printf("Külg A:%d<br>Külg B:%d<br> Pindala: %d<br> Ümbermõõt: %d", $kylgA, $kylgB, $pindala, $ymbermoot);
}



?>


<h2>Teisendamine</h2>
<form action="php01.php" method="get">
    mm <input type="number" name="mm"><input type="submit" value="Teisenda"><br>
</form>
<?php

if(isset($_GET["mm"])){
    $mm = $_GET["mm"];
    printf("%dmm on %dcm ja %.2fm", $mm, $mm/10, $mm/1000);
}

$a = 5;
$b = 7;
echo "<h2>Liitmine</h2>";
    printf("%d + %d = %d<br>", $a, $b, $a+$b);
    printf("%d - %d = %d<br>", $a, $b, $a-$b);
    printf("%d * %d = %d<br>", $a, $b, $a*$b);
    printf("%d / %d = %.2f<br>", $a, $b, $a/$b);


?>

<!-- // Tehvan Marjapuu 12.02.25
// Ülesanne 1 -->
<h1>Ülesanne 1</h1>

<?php


echo "\"It's My Life\" - Dr. Alban<br>";
echo "<br>";
echo "(\(\<br>(-.-)<br>o_(\")(\")"

?>