 <!-- Tehvan Marjapuu
Harjutus 1-3 -->

<!DOCTYPE html>
<html lang="et">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Harjutus1-3</title>
        <meta name="keywords" content="HTML,CSS,HTML5,CSS3">
        <meta name="author" content="Tehvan Marjapuu IT-23">
    </head>
<body>
    <h1>Harjutus 1</h1>
    <?php





echo '"It\'s My life - Dr.Alban"<br>';
echo "<br>";
echo "(\(\<br>(-.-)<br>o_(\")(\")";

?>

<h1>Harjutus 2</h1>


<h2>Teisendamine</h2>


<form action="php01.php" method="get">
    a <input type="number" name="a"><br>
    b <input type="number" name="b"><br>
    <input type="submit" value="Teisenda"><br>

<?php

if(isset($_GET["a"])&&isset($_GET["b"])){
    $kylg_a = $_GET["a"];
    $kylg_b = $_GET["b"];
    $kylg_c = sqrt($kylg_a**2 + $kylg_b**2);
    $pindala = $kylg_a * $kylg_b / 2;
    $ymbermoot = $kylg_a+$kylg_b+$kylg_c;
    printf("Külg A:%d<br>Külg B:%d<br>Pindala:%d<br>Ümbermõõt:%d", $kylg_a, $kylg_b, $pindala, $ymbermoot);
}

?>



<h2>Millimeetrid</h2>

<form action="php01.php" method="get">
    mm <input type="number" name="mm"><input type="submit" value="Teisenda"><br>


<?php


    if(isset($_GET["ts"])){
        $mm = $_GET["ts"];
        echo $mm;
        printf("%ts on %dcm või %f.2fm", $ts, $mm/10, $mm/1000);
    }


echo "<h2>Liitmine</h2>";


$a = 5;

$b = 7;

    printf("%d + %d = %d<br>",$a, $b, $a+$b);
    printf("%d - %d = %d<br>",$a, $b, $a-$b);
    printf("%d / %d = %.2f<br>",$a, $b, $a/$b);
    printf("%d * %d = %d<br>",$a, $b, $a*$b);
    //------------
?>

</body>
</html>


<h1>Harjutus 03</h1>

<form action="" method="get">
    a <input type="number" name="a" required min=1><br>
    b <input type="number" name="b" required min=1><br>    
    c <input type="number" name="h" required min=1><br>
    <input type="submit" value="Arvuta">

</form>

<?php

if(isset($_GET["a"])&&isset($_GET["b"])&&isset($_GET["h"])){
    $kylg_a = $_GET["a"];
    $kylg_b = $_GET["b"];
    $kylg_h = $_GET["h"];
    $trapets_s = ($kylg_a+$kylg_b)/2*$kylg_h;
    $romb_p = 4 * $kylg_a;
    printf("Külg A: %d<br>Külg B: %d<br>Kõrgus: %d<br>Trapetsi pindala: %.2f<br>Romb: %d", $kylg_a, $kylg_b, $kylg_h, $trapets_s, $romb_p);   
}


?>