<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Trapetsi pindala ja rombi ümbermõõt</title>
</head>
<body>
    <h1>Arvutused</h1>
    <form action="" method="get">
        <!-- Trapetsi parameetrid -->
        Trapetsi alus 1 (a): <input type="number" step="0.1" name="a" required><br>
        Trapetsi alus 2 (b): <input type="number" step="0.1" name="b" required><br>
        Trapetsi kõrgus (h): <input type="number" step="0.1" name="h" required><br>
        <!-- Rombi parameetrid -->
        Rombi külje pikkus (k): <input type="number" step="0.1" name="k" required><br>
        <input type="submit" value="Arvuta">
    </form>

    <?php
    if (isset($_GET['a']) && isset($_GET['b']) && isset($_GET['h']) && isset($_GET['k'])) {
        // Vormist saadud andmete töötlemine
        $a = floatval($_GET['a']); // Trapetsi alus 1
        $b = floatval($_GET['b']); // Trapetsi alus 2
        $h = floatval($_GET['h']); // Trapetsi kõrgus
        $k = floatval($_GET['k']); // Rombi külje pikkus

        // Trapetsi pindala arvutamine
        $trapetsi_pindala = (($a + $b) * $h) / 2;
        $trapetsi_pindala_ymardatud = round($trapetsi_pindala, 1);

        // Rombi ümbermõõdu arvutamine
        $rombi_umbermoot = 4 * $k;
        $rombi_umbermoot_ymardatud = round($rombi_umbermoot, 1);

        // Tulemuste väljastamine
        echo "<h1>Tulemused</h1>";
        echo "Trapetsi pindala on " . $trapetsi_pindala_ymardatud . " ruutühikut.<br>";
        echo "Rombi ümbermõõt on " . $rombi_umbermoot_ymardatud . " ühikut.";
    }
    ?>
</body>
</html>
