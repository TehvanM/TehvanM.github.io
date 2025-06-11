<!-- Tehvan Marjapuu 
Harjutus 14 -->
<?php
$kaust = 'php14_pildid';
$pildid = [];

if (is_dir($kaust)) {
    $asukoht = opendir($kaust);
    while (($fail = readdir($asukoht)) !== false) {
        if ($fail !== '.' && $fail !== '..') {
            $pildid[] = $fail;
        }
    }
    closedir($asukoht);
}

function muudaPildiSuurus($pildiTee, $maxLaius, $maxKorgus) {
    list($laius, $korgus) = getimagesize($pildiTee);

    $suhe = min($maxLaius / $laius, $maxKorgus / $korgus, 1);

    return [
        'laius' => round($laius * $suhe),
        'korgus' => round($korgus * $suhe)
    ];
}

$suvapildiMax = 400;
$pisipildiLaius = 120;
$pisipildiKorgus = 90;
$kuvatavateArv = 16;

$suvalinePilt = $pildid[array_rand($pildid)];
$suvalinePildiTee = "$kaust/$suvalinePilt";
$suurPilt = muudaPildiSuurus($suvalinePildiTee, $suvapildiMax, $suvapildiMax);

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>harjutus 14</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-4">
        <h1>suvaline pilt</h1>
        <img src="<?php echo $suvalinePildiTee; ?>" 
             alt="Suvaline pilt" 
             width="<?php echo $suurPilt['laius']; ?>" 
             height="<?php echo $suurPilt['korgus']; ?>" 
             class="img-fluid mb-4">

        <h2>Suvalised pisipildid</h2>
        <div class="row mt-4 mb-5">
            <?php 
            for ($i = 0; $i < $kuvatavateArv; $i++) {
                $pisipilt = $pildid[array_rand($pildid)];
                $pisipildiTee = "$kaust/$pisipilt";
                $pisipiltSuurus = muudaPildiSuurus($pisipildiTee, $pisipildiLaius, $pisipildiKorgus);
            ?>
                <div class="col-md-3 col-sm-4 col-6 mb-3">
                    <a href="<?php echo $pisipildiTee; ?>" target="_blank">
                        <img src="<?php echo $pisipildiTee; ?>" 
                             alt="Pisipilt" 
                             width="<?php echo $pisipiltSuurus['laius']; ?>" 
                             height="<?php echo $pisipiltSuurus['korgus']; ?>" 
                             class="img-thumbnail">
                    </a>
                </div>
            <?php } ?>
        </div>
        <button onclick="location.reload();" class="btn btn-primary mb-5">Uuenda pilte</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
