<!-- Tehvan Marjapuu  
Harjutus 12 -->

<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Harjutus 12 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Harjutus 12</h1>
        <div class="row">
            <div class="col-md-4">

                <h2>sõidukestus Kalkulaator</h2>

                <form method="get">
                    <div class="mb-3">
                        <label class="form-label">sinu nimi</label>
                        <input type="text" class="form-control" name="nimi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">algusaeg (hh:mm)</label>
                        <input type="text" class="form-control" name="start">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">lõppaeg (hh:mm)</label>
                        <input type="text" class="form-control" name="end">
                    </div>
                    <button type="submit" class="btn btn-primary">arvuta</button>
                </form>  

                <?php
                if (!empty($_GET["nimi"]) && !empty($_GET["start"]) && !empty($_GET["end"])) {
                    $kasutaja = trim($_GET["nimi"]);

                    
                    $algus = explode(":", $_GET["start"]);
                    $lopp = explode(":", $_GET["end"]);

                    $algusMin = $algus[0] * 60 + $algus[1];
                    $loppMin = $lopp[0] * 60 + $lopp[1];
                    $kokku = $loppMin - $algusMin;

                    $h = floor($kokku / 60);
                    $m = $kokku % 60;

                    echo "<p>Tere $kasutaja! Sinu sõit kestis $h tundi ja $m minutit.</p>";
                }
                ?>

                <h2>palkkade analüüs</h2>

                <?php
                $failitee = 'tootajad.csv';
                $fail = fopen($failitee, 'r');

                $mehed_summa = $naised_summa = 0;
                $mehed_kokku = $naised_kokku = 0;
                $mehed_suurim = $naised_suurim = 0;

                while (($rida = fgetcsv($fail, 1000, ';')) !== false) {
                    if (count($rida) < 3) continue;

                    list($nimi, $sugu, $palk) = $rida;
                    $palk = floatval($palk);

                    if ($sugu === 'm') {
                        $mehed_summa += $palk;
                        $mehed_kokku++;
                        if ($palk > $mehed_suurim) $mehed_suurim = $palk;
                    } elseif ($sugu === 'n') {
                        $naised_summa += $palk;
                        $naised_kokku++;
                        if ($palk > $naised_suurim) $naised_suurim = $palk;
                    }
                }
                fclose($fail);

                $mehed_avg = $mehed_kokku ? ($mehed_summa / $mehed_kokku) : 0;
                $naised_avg = $naised_kokku ? ($naised_summa / $naised_kokku) : 0;

                echo "<p>Meeste keskmine palk: " . number_format($mehed_avg, 2) . "€; suurim: " . number_format($mehed_suurim, 2) . "€.</p>";
                echo "<p>Naiste keskmine palk: " . number_format($naised_avg, 2) . "€; suurim: " . number_format($naised_suurim, 2) . "€.</p>";
                ?>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
