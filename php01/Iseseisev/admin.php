<!-- Tehvan Marjapuu iseseisev -->


<?php 
session_start();
if(!isset($_SESSION['UserData']['Username'])){
    header("location:login.php");
    exit;
}
?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administraator leht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Admin paneel</h1>
        <a href="logout.php" class="btn btn-secondary">Logi välja</a>
    </div>

    <form method="POST" enctype="multipart/form-data" class="mb-5">
        <h2>lisa uus toode</h2>
        <div class="mb-3">
            <label class="form-label">
                toote nimi:
                <input type="text" name="toote_nimi" class="form-control" required>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">
                hind:
                <input type="number" name="toote_hind" class="form-control" required>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">
                Pilt:
                <input type="file" name="toote_pilt" class="form-control" accept=".png" required>
            </label>
        </div>
        <button type="submit" name="lisa" class="btn btn-primary">Lisa toode</button>
    </form>

    <div class="row">
    <?php
    function loeAndmeid() {
        $toodete_array = [];
        $csv_fail = fopen("tooted.csv", "r");
        if($csv_fail !== false) {
            fgetcsv($csv_fail); // päise rida
            while ($csv_rida = fgetcsv($csv_fail)) {
                $toodete_array[] = $csv_rida;
            }
            fclose($csv_fail);
        }
        return $toodete_array;
    }

    function salvestaAndmeid($tooted_list) {
        $csv_fail = fopen("tooted.csv", "w");
        if($csv_fail !== false) {
            fputcsv($csv_fail, ["pilt", "toode", "hind"]);
            foreach ($tooted_list as $toode_andmed) {
                fputcsv($csv_fail, $toode_andmed);
            }
            fclose($csv_fail);
        }
    }

    if(isset($_GET['kustuta'])) {
        $kustuta_indeks = $_GET['kustuta'];
        $olemasolevad_tooted = loeAndmeid();
        if (isset($olemasolevad_tooted[$kustuta_indeks])) {
            unset($olemasolevad_tooted[$kustuta_indeks]);
            salvestaAndmeid($olemasolevad_tooted);
            echo "<div class='alert alert-success'>Toode on kustutatud!</div>";
        }
    }

    if(isset($_POST['lisa'])) {
        $toote_nimi = $_POST['toote_nimi'];
        $toote_hind = $_POST['toote_hind'];
        $pildi_info = $_FILES['toote_pilt'];

        $piltide_kataloog = "pildid/";
        $pildi_nimi = $piltide_kataloog . basename($pildi_info['name']);

        if(move_uploaded_file($pildi_info['tmp_name'], $pildi_nimi)) {
            $praegused_tooted = loeAndmeid();
            $praegused_tooted[] = [$pildi_nimi, $toote_nimi, $toote_hind];
            salvestaAndmeid($praegused_tooted);
            echo "<div class='alert alert-success'>Toode lisatud edukalt!</div>";
        } else {
            echo "<div class='alert alert-danger'>Pildi üleslaadimine ebaõnnestus!</div>";
        }
    }

    echo '<h2>Olemasolevad tooted</h2>';
    $koik_tooted = loeAndmeid();

    foreach($koik_tooted as $toote_indeks => $toote_andmed) {
        echo "
        <div class='col-md-4 mb-4'>
            <div class='card'>
                <img src='{$toote_andmed[0]}' class='card-img-top' alt='{$toote_andmed[1]}' style='height: 200px; object-fit: cover;'>
                <div class='card-body'>
                    <h5 class='card-title'>{$toote_andmed[1]}</h5>
                    <p class='card-text'>{$toote_andmed[2]}€</p>
                    <a href='?kustuta={$toote_indeks}' class='btn btn-danger' onclick='return confirm(\"Kas oled kindel?\")'>Kustuta</a>
                </div>
            </div>
        </div>";
    }
    ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
