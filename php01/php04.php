<?php 
// Kui vormi andmed on saadetud, käivitatakse vastav ülesande kood.
// Kontrollime, kas GET parameeter 'task' on määratud.
if (isset($_GET['task'])) {
    $task = $_GET['task'];
}
?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <title>Mitme ülesande lahendused</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Mitme ulesande lahendusd</h1>
    
    <?php
    if (isset($task) && $task == "jagamine" && !empty($_GET['num1']) && !empty($_GET['num2'])) {
        $num1 = intval($_GET['num1']);
        $num2 = intval($_GET['num2']);
        echo '<h2>Jagamine</h2>';
        if ($num2 == 0) {
            echo '<div class="alert alert-danger">Jagamine nulliga ei ole lubatud!</div>';
        } else {
            $result = $num1 / $num2;
            echo '<div class="alert alert-success">' . $num1 . ' jagatud ' . $num2 . ' annab tulemuseks ' . $result . '.</div>';
        }
    }
    
    if (isset($task) && $task == "vanus" && !empty($_GET['age1']) && !empty($_GET['age2'])) {
        $age1 = intval($_GET['age1']);
        $age2 = intval($_GET['age2']);
        echo '<h2>Vanuse võrdlus</h2>';
        if ($age1 > $age2) {
            echo '<div class="alert alert-info">Esimene isik on vanem.</div>';
        } elseif ($age2 > $age1) {
            echo '<div class="alert alert-info">Teine isik on vanem.</div>';
        } else {
            echo '<div class="alert alert-info">Mõlemad on ühevanused.</div>';
        }
    }
    
    if (isset($task) && $task == "ristkylik1" && !empty($_GET['side1']) && !empty($_GET['side2'])) {
        $side1 = floatval($_GET['side1']);
        $side2 = floatval($_GET['side2']);
        echo '<h2>Ristkülik või ruut</h2>';
        if ($side1 == $side2) {
            echo '<div class="alert alert-success">ruut.</div>';
        } else {
            echo '<div class="alert alert-success">ristkülik.</div>';
        }
    }
    
    if (isset($task) && $task == "ristkylik2" && !empty($_GET['length']) && !empty($_GET['width'])) {
        $length = floatval($_GET['length']);
        $width = floatval($_GET['width']);
        echo '<h2>Ristkülik või ruut II</h2>';
        if ($length == $width) {
            echo '<div class="alert alert-success"> tegemist on ruuduga.</div>';
        } else {
            echo '<div class="alert alert-success">tegemist on ristkülikuga.</div>';
        }
    }
    
    if (isset($task) && $task == "juubel" && !empty($_GET['birthyear'])) {
        $birthyear = intval($_GET['birthyear']);
        $currentYear = date("Y");
        $age = $currentYear - $birthyear;
        echo '<h2>Juubel</h2>';
        if ($age % 5 == 0) {
            echo '<div class="alert alert-success">Palju õnne! Teil on juubeliaasta: ' . $age . ' aastat!</div>';
        } else {
            echo '<div class="alert alert-warning">See ei ole juubeliaasta. Teie vanus on ' . $age . ' aastat.</div>';
        }
    }
    
    if (isset($task) && $task == "hinne" && !empty($_GET['points'])) {
        $points = intval($_GET['points']);
        echo '<h2>Hinne</h2>';
        switch (true) {
            case ($points > 10):
                echo '<div class="alert alert-success">SUPER LUX!</div>';
                break;
            case ($points >= 5 && $points <= 9):
                echo '<div class="alert alert-info">HAMMASTAVALT HASTI!</div>';
                break;
            case ($points < 5):
                echo '<div class="alert alert-danger">KASSIN!</div>';
                break;
            default:
                echo '<div class="alert alert-warning">PANE OMA PUNKTID SIIA!</div>';
        }
    }
    ?>
    
    <hr>
    
    <h3>Jagamine</h3>
    <form method="get" class="mb-4">
        <div class="form-group">
            <label for="num1">Esimene arv:</label>
            <input type="number" class="form-control" id="num1" name="num1" required>
        </div>
        <div class="form-group">
            <label for="num2">Teine arv:</label>
            <input type="number" class="form-control" id="num2" name="num2" required>
        </div>

        <input type="hidden" name="task" value="jagamine">
        <button type="submit" class="btn btn-primary">Jagame!</button>
    </form>
    
    <h3>Vanuse võrdlus</h3>
    <form method="get" class="mb-4">
        <div class="form-group">
            <label for="age1">Esimene vanus:</label>
            <input type="number" class="form-control" id="age1" name="age1" required>
        </div>
        <div class="form-group">
            <label for="age2">Teine vanus:</label>
            <input type="number" class="form-control" id="age2" name="age2" required>
        </div>
        <input type="hidden" name="task" value="vanus">
        <button type="submit" class="btn btn-primary">Võrdle vanuseid!</button>
    </form>
    
    <h3>Ristkülik või ruut</h3>
    <form method="get" class="mb-4">
        <div class="form-group">
            <label for="side1">Külg 1:</label>
            <input type="number" step="0.1" class="form-control" id="side1" name="side1" required>
        </div>
        
            <div class="form-group">
            <label for="side2">Külg 2:</label>
            <input type="number" step="0.1" class="form-control" id="side2" name="side2" required>
        </div>

        <input type="hidden" name="task" value="ristkylik1">
        <button type="submit" class="btn btn-primary">Määratle kujund!</button>
    </form>

    
    <h3>Ristkülik või ruut II</h3>
    <form method="get" class="mb-4">
        <div class="form-group">
        <label for="length">Pikkus:</label>
            <input type="number" step="0.1" class="form-control" id="length" name="length" required>
        </div>
     <div class="form-group">
        <label for="width">Laius:</label>
            <input type="number" step="0.1" class="form-control" id="width" name="width" required>
        </div>
        <input type="hidden" name="task" value="ristkylik2">
        <button type="submit" class="btn btn-primary">Määratle kuju!</button>
    </form>
    
    <h3>Juubel</h3>
    <form method="get" class="mb-4">
        <div class="form-group">


        <label for="birthyear">Sünniaasta:</label>
        <input type="number" class="form-control" id="birthyear" name="birthyear" required>
        </div>


        <input type="hidden" name="task" value="juubel">
        <button type="submit" class="btn btn-primary">Kontrolli juubleit!</button>
    </form>
    
    <h3>Hinne</h3>
    <form method="get" class="mb-4">
        <div class="form-group">
        <label for="points">KT punktid:</label>
        <input type="number" class="form-control" id="points" name="points" required>
        </div>
        <input type="hidden" name="task" value="hinne">
        <button type="submit" class="btn btn-primary">Hangi hinne!</button>
    </form>
    
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</body>
</html>