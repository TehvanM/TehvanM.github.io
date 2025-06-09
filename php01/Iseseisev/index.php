<!-- Tehvan Marjapuu iseseisev -->

<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-pood</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .hero-sektsioon {
            background-image: url(https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg);
            background-size: cover;
            background-position: center;
            min-height: 400px;
        }
        .hero-sektsioon .container {
            padding-top: 50px;
            padding-bottom: 50px;
        }
    </style>
</head>
<body>
    <div class="hero-sektsioon">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand p-2 text-black fw-bold" href="#">Mar&puu.ee</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-black" href="index.php">Avaleht</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-black" href="index.php?leht=tooted">Tooted</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-black" href="index.php?leht=kontakt">Kontakt</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-black" href="admin.php">Admin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-black" href="index.php?leht=test">Test leht</a>
                            </li>
                            <li class="nav-item text-center mt-2">
                                <i class="bi bi-cart text-black fs-4"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <?php
            // Juhuslikud reklaamid
            $reklaam_pildid = [
                "pildid\banner1.png",
                "pildid\banner2.png",
                "pildid\banner3.png",
                "https://images.pexels.com/photos/5632402/pexels-photo-5632402.jpeg",
                "https://images.pexels.com/photos/5625114/pexels-photo-5625114.jpeg",
                "https://images.pexels.com/photos/6347919/pexels-photo-6347919.jpeg"
            ];
            $reklaam_tekstid = [
                "SUUR ALE<br><span class='text-black'>kuni -50% kõigele!</span>",
                "TAGASI KOOLI<br><span class='text-black'>-40% kooliasjadele!</span>",
                "SÜGISE PAKKUMINE<br><span class='text-black'>-35% kõik tooted!</span>"
            ];

            $valitud_pilt = $reklaam_pildid[array_rand($reklaam_pildid)];
            $valitud_tekst = $reklaam_tekstid[array_rand($reklaam_tekstid)];
            ?>

            <div class="row justify-content-center align-items-center text-black">
                <div class="col-sm-8">
                    <h1 class="display-4"><?php echo $valitud_tekst; ?></h1>
                    <p class="lead">Avasta meie fantastilisi pakkumisi ja leia oma lemmiktooted soodsate hindadega!</p>
                    <button class="btn btn-warning btn-lg">Vaata pakkumisi ➜</button>
                </div>
                <div class="col-sm-4">
                    <img src="<?php echo $valitud_pilt; ?>" class="img-fluid rounded shadow" alt="Reklaam" style="max-height: 300px;">
                </div>
            </div>
        </div>
    </div>

    <?php
    // Lehe sisu kontroll 
    if (!empty($_GET['leht'])) {
        $leht_nimi = htmlspecialchars($_GET['leht']);
        $lubatud_lehed = ['tooted', 'kontakt'];
        $on_lubatud = in_array($leht_nimi, $lubatud_lehed);

        if ($on_lubatud) {
            include($leht_nimi . '.php');
        } else {
            echo '<div class="container mt-5"><h1 class="text-center text-danger">404 - Lehte ei leitud!</h1></div>';
        }
    } else {
    ?>

    <div class="container">
        <div class="row text-center mt-5 mb-4">
            <div class="col">
                <h2 class="display-5">Meie parimad tooted</h2>
                <p class="text-muted">Vaata, mida meil pakkuda on</p>
            </div>
        </div>
        <div class="row">
            <?php
            $csv_fail = fopen("tooted.csv", "r");
            if ($csv_fail) {
                fgetcsv($csv_fail); 
                $toode_loendur = 0;
                while ($toote_andmed = fgetcsv($csv_fail)) {
                    if ($toode_loendur < 6) { 
                        echo "
                        <div class='col-md-4 mb-4'>
                            <div class='card h-100 shadow-sm'>
                                <img src='{$toote_andmed[0]}' class='card-img-top' alt='{$toote_andmed[1]}' style='height: 250px; object-fit: cover;'>
                                <div class='card-body d-flex flex-column'>
                                    <h5 class='card-title'>{$toote_andmed[1]}</h5>
                                    <p class='card-text text-success fw-bold fs-4'>{$toote_andmed[2]}€</p>
                                    <button class='btn btn-primary mt-auto'>Lisa korvi</button>
                                </div>
                            </div>
                        </div>";
                    }
                    $toode_loendur++;
                }
                fclose($csv_fail);
            } else {
                echo '<div class="col-12"><p class="text-center">Tooteid ei leitud!</p></div>';
            }
            ?>
        </div>
    </div>

    <?php
    }
    ?>

    <footer class="bg-dark py-4 mt-5">
        <div class="container text-light text-center">
            <div class="row">
                <div class="col-md-6">
                    <h5>Mar&puu.ee</h5>
                    <p>sinu usaldusväärne ostupartner</p>
                </div>
                <div class="col-md-6">
                    <p>&copy; 2025 Kõik õigused kaitstud</p>
                    <p>Kontakt: info@marjapuu.ee, Tehvan.marjapuu@hkhk.edu.ee</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>