<!-- Tehvan Marjapuu  
Harjutus 13 - Muudetud -->

<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Harjutus 13</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>harjutus 13</h1>
        <div class="row">
            <div class="col-md-4">

                <h2>lisa uus pilt</h2>
                <?php
                if (!empty($_FILES['piltfail']['name'])) {
                    $failinimi = $_FILES['piltfail']['name'];
                    $tempfail = $_FILES['piltfail']['tmp_name'];
                    $tyyp = $_FILES['piltfail']['type'];

                    if ($tyyp === 'image/jpeg' || $tyyp === 'image/jpg') {
                        $kaust = 'php13_pildid';
                        if (move_uploaded_file($tempfail, $kaust . '/' . $failinimi)) {
                            echo '<div class="alert alert-success">Pilt laeti edukalt üles!</div>';
                        } else {
                            echo '<div class="alert alert-danger">Pildi salvestamine ebaõnnestus!</div>';
                        }
                    } else {
                        echo '<div class="alert alert-warning">Ainult JPG/JPEG failid on lubatud.</div>';
                    }
                }
                ?>

                <form method="post" enctype="multipart/form-data">
                    <input type="file" name="piltfail" accept="image/jpeg, image/jpg"><br>
                    <input type="submit" value="Lae pilt üles!" class="btn btn-primary mt-2">
                </form>

                <h2>Vaata üleslaetud pilte</h2>
                <form method="post">
                    <select name="valitud_pilt" class="form-select">
                        <option value="">-- Vali pilt --</option>
                        <?php
                        $kaust = 'php13_pildid';
                        if (is_dir($kaust)) {
                            if ($dh = opendir($kaust)) {
                                while (($fail = readdir($dh)) !== false) {
                                    if ($fail !== '.' && $fail !== '..') {
                                        echo "<option value='$fail'>$fail</option>";
                                    }
                                }
                                closedir($dh);
                            }
                        }
                        ?>
                    </select>
                    <input type="submit" value="Näita pilti" class="btn btn-secondary mt-2">
                </form>

                <?php
                if (!empty($_POST['valitud_pilt'])) {
                    $kuvatav_pilt = $_POST['valitud_pilt'];
                    $pildi_asukoht = $kaust . '/' . $kuvatav_pilt;
                    echo "<img src='$pildi_asukoht' alt='Valitud pilt' style='max-width:100%; margin-top:10px;'><br>";
                }
                ?>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
