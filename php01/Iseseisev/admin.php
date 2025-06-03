 <!-- Tehvan Marjapuu 
Harjutus IS  -->

<?php session_start();

if(!isset($_SESSION['UserData']['Username'])){
        header("location:login/login.php");
        exit;
}
?>

<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Admin leht</h1>
            <a href="login/logout.php" class="btn btn-secondary">Logi välja</a>
        </div>

        <form method="POST" enctype="multipart/form-data" class="mb-5">

            <h2>Lisa uus toode</h2>

            <div class="mb-3">
                <label class="form-label">
                    Toote nimi:
                    <input type="text" name="toote_nimi" class="form-control" required>
                </label>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Toote hind:
                    <input type="number" name="toote_hind" class="form-control" required>
                </label>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Toote pilt (PNG):
                    <input type="file" name="toote_pilt" class="form-control" accept=".png" required>
                </label>
            </div>

            <button type="submit" name="lisa" class="btn btn-primary">Lisa toode</button>
    
        </form>

        <div class="row">


            <?php
            function andmed() {
                $tooted = [];
                $csv = fopen("tooted.csv", "r");
                if($csv !== false) {
                    fgetcsv($csv);
                    while ($rida = fgetcsv($csv)) {
                        $tooted[] = $rida;
                    }
                    fclose($csv);
                }
                return $tooted;
            }

            function salvesta($tooted) {
                $csv = fopen("tooted.csv", "w");
                if($csv !== false) {
                    fputcsv($csv, ["pilt", "toode", "hind"]);
                    foreach ($tooted as $toode) {
                        fputcsv($csv, $toode);
                    }
                    fclose($csv);
                }
            }

            if(isset($_GET['kustuta'])) {
                $kustuta = $_GET['kustuta'];
                $tooted = andmed();
                if (isset($tooted[$kustuta])) {
                    unset($tooted[$kustuta]);
                    salvesta($tooted);
                }
            }

            if(isset($_POST['lisa'])) {
                $toote_nimi = $_POST['toote_nimi'];
                $toote_hind = $_POST['toote_hind'];
                $pilt = $_FILES['toote_pilt'];
                $asukoht = "pildid/";
                $pildi_nimi = $asukoht . basename($pilt['name']);
                if(move_uploaded_file($pilt['tmp_name'], $pildi_nimi)) {
                    $tooted = andmed();
                    $tooted[] = [$pildi_nimi, $toote_nimi, $toote_hind];
                    salvesta($tooted);
                } else {
                    echo "<div class='alert alert-danger'>Pildi üleslaadimine ebaõnnestus.</div>";
                }
            }
            echo '<h2>Praegused tooted</h2>';

            $tooted = andmed();
            
            foreach($tooted as $kustuta => $toode) {
                echo "
                <div class='col-md-4 mb-4'>
                    <div class='card'>
                        <img src='{$toode[0]}' class='card-img-top' alt='{$toode[1]}'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$toode[1]}</h5>
                            <p class='card-text'>{$toode[2]}€</p>
                            <a href='?kustuta={$kustuta}' class='btn btn-danger'>Kustuta</a>
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