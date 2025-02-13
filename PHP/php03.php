<?php
// Kontrollime, kas kõik vajalikud parameetrid on saadud
if (isset($_GET['a']) && isset($_GET['b']) && isset($_GET['h']) && isset($_GET['d'])) {
    // Muutujate määramine ja teisendamine ujukomaarvudeks
    $a = floatval($_GET['a']);
    $b = floatval($_GET['b']);
    $h = floatval($_GET['h']);
    $d = floatval($_GET['d']);
    
    // Trapetsi pindala arvutamine: A = ((a + b) * h) / 2
    $trapetsi_pindala = (($a + $b) * $h) / 2;
    
    // Rombi ümbermõõdu arvutamine: P = 4 * d
    $rombi_umbermoot = 4 * $d;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Trapetsi ja Rombi Arvutus</title>
</head>
<body>
    <h1>Trapetsi ja Rombi Arvutus</h1>
    <?php if (isset($trapetsi_pindala) && isset($rombi_umbermoot)) { ?>
        <p>Trapetsi pindala, mille aluseks olid alus a = <?php echo number_format($a, 1); ?>, alus b = <?php echo number_format($b, 1); ?> ja kõrgus h = <?php echo number_format($h, 1); ?>, on <?php echo number_format($trapetsi_pindala, 1); ?> ruutühikut.</p>
        <p>Rombi ümbermõõt, milleks on külg d = <?php echo number_format($d, 1); ?>, on <?php echo number_format($rombi_umbermoot, 1); ?> ühikut.</p>
    <?php } else { ?>
        <!-- Väljakontrolliga vorm: required atribuudiga veendume, et kõik andmed on sisestatud -->
        <form action="" method="get">
            <label for="a">Trapetsi esimene alus (a):</label>
            <input type="number" step="0.1" name="a" id="a" required><br><br>
            
            <label for="b">Trapetsi teine alus (b):</label>
            <input type="number" step="0.1" name="b" id="b" required><br><br>
            
            <label for="h">Trapetsi kõrgus (h):</label>
            <input type="number" step="0.1" name="h" id="h" required><br><br>
            
            <label for="d">Rombi külg (d):</label>
            <input type="number" step="0.1" name="d" id="d" required><br><br>
            
            <input type="submit" value="Arvuta">
        </form>
    <?php } ?>
</body>
</html>
