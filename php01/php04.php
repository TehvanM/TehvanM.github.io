<!-- Tehvan marjapuu harjutus 4 -->


<?php  
$mytask = (isset($_GET['task'])) ? $_GET['task'] : '';

?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <title>harjutus 4</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">harjutus 4</h1>
    
    <?php
    if (!empty($mytask)) {
        if ($mytask === "jagamine" && isset($_GET['num1']) && isset($_GET['num2'])) {
            $x = $_GET['num1'] + 0;
            $y = $_GET['num2'] + 0;
            echo "<h2>Jagame midagi</h2>";
            if (!$y) {
                echo '<div class="alert alert-danger">Nulliga mäng ei sobi!</div>';
            } else {
                $answer = $x / $y;
                echo "<div class='alert alert-success'>$x jagatud $y tulemuseks on $answer</div>";
            }
        } elseif ($mytask == "vanus" && $_GET['age1'] != '' && $_GET['age2'] != '') {
            $v1 = $_GET['age1'] * 1;
            $v2 = $_GET['age2'] * 1;
            echo "<h2>Vanuse arvestus</h2>";
            echo '<div class="alert alert-info">';
            echo ($v1 > $v2) ? "Esimene on vanem" : (($v2 > $v1) ? "Teine on vanem" : "Võrdne vanus");
            echo '</div>';
        } elseif ($mytask === "ristkylik1" && @$_GET['side1'] && @$_GET['side2']) {
            $s1 = (float)$_GET['side1'];
            $s2 = (float)$_GET['side2'];
            echo "<h2>Kujundi määramine I</h2>";
            echo '<div class="alert alert-success">' . (($s1 === $s2) ? "See on ruut" : "See on ristkülik") . '</div>';
        } elseif ($mytask === "ristkylik2" && isset($_GET['length']) && isset($_GET['width'])) {
            $p = floatval($_GET['length']);
            $l = floatval($_GET['width']);
            echo "<h2>Kujundi määramine II</h2>";
            if ($p == $l) {
                echo '<div class="alert alert-success">Jälle ruut!</div>';
            } else {
                echo '<div class="alert alert-success">Seekord on ristkülik!</div>';
            }
        } elseif ($mytask === "juubel" && !empty($_GET['birthyear'])) {
            $synd = intval($_GET['birthyear']);
            $now = date("Y");
            $vanus = $now - $synd;
            echo "<h2>Juubel või mitte?</h2>";
            if ($vanus % 5 == 0) {
                echo "<div class='alert alert-success'>JUUBEL! $vanus aastat noor!</div>";
            } else {
                echo "<div class='alert alert-warning'>Pole juubel. Vaid $vanus aastat.</div>";
            }
        } elseif ($mytask === "hinne" && $_GET['points'] !== '') {
            $punktid = (int)$_GET['points'];
            echo "<h2>Hindamine käib</h2>";
            switch (true) {
                case ($punktid > 10):
                    echo '<div class="alert alert-success">TIMMIS!</div>';
                    break;
                case ($punktid >= 5 && $punktid < 10):
                    echo '<div class="alert alert-info">Täitsa ok</div>';
                    break;
                case ($punktid < 5):
                    echo '<div class="alert alert-danger">Nõrk</div>';
                    break;
                default:
                    echo '<div class="alert alert-warning">Sisesta midagi!</div>';
            }
        }
    }
    ?>
    
    <hr>
    <h3>Jagamine</h3>
    <form method="get" class="mb-4">
        <input type="number" name="num1" required placeholder="Arv 1" class="form-control mb-2">
        <input type="number" name="num2" required placeholder="Arv 2" class="form-control mb-2">
        <input type="hidden" name="task" value="jagamine">
        <button class="btn btn-primary">Arvuta</button>
    </form>

    <h3>Vanuse võrdlus</h3>
    <form method="get" class="mb-4">
        <input type="number" name="age1" required placeholder="Vanus 1" class="form-control mb-2">
        <input type="number" name="age2" required placeholder="Vanus 2" class="form-control mb-2">
        <input type="hidden" name="task" value="vanus">
        <button class="btn btn-primary">Võrdle</button>
    </form>

    <h3>Kujundi määramine I</h3>
    <form method="get" class="mb-4">
        <input type="number" name="side1" step="0.1" required placeholder="Külg 1" class="form-control mb-2">
        <input type="number" name="side2" step="0.1" required placeholder="Külg 2" class="form-control mb-2">
        <input type="hidden" name="task" value="ristkylik1">
        <button class="btn btn-primary">Kontrolli</button>
    </form>

    <h3>Kujundi määramine II</h3>
    <form method="get" class="mb-4">
        <input type="number" name="length" step="0.1" required placeholder="Pikkus" class="form-control mb-2">
        <input type="number" name="width" step="0.1" required placeholder="Laius" class="form-control mb-2">
        <input type="hidden" name="task" value="ristkylik2">
        <button class="btn btn-primary">Kontrolli</button>
    </form>

    <h3>Juubel</h3>
    <form method="get" class="mb-4">
        <input type="number" name="birthyear" required placeholder="Sünniaasta" class="form-control mb-2">
        <input type="hidden" name="task" value="juubel">
        <button class="btn btn-primary">Kontrolli juubelit</button>
    </form>

    <h3>Hinne</h3>
    <form method="get" class="mb-4">
        <input type="number" name="points" required placeholder="Punktid" class="form-control mb-2">
        <input type="hidden" name="task" value="hinne">
        <button class="btn btn-primary">Hinda</button>
    </form>
</div>
</body>
</html>