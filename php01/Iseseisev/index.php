 <!-- Tehvan Marjapuu 
Harjutus IS  -->

<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kontrolltöö</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .jumbo {
            background-image: url(https://picsum.photos/1400/400);
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="jumbo">
        <div class="container">

            <nav class="navbar navbar-expand-lg text-secondary">
                <div class="container-fluid">

                    <a class="navbar-brand p-2" href="#">Tehvan Mar&puu.com</a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="index.php">Avaleht</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?leht=tooted">Tooted</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?leht=kontakt">Kontakt</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="admin.php">Admin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?leht=asdas">Suvaline</a>
                            </li>
                            <li class="nav-item text-center mt-2">
                                <i class="bi bi-bag"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <?php
            $pildid = array("pildid/banner1.png", "pildid/banner2.png", "pildid/banner3.png");
            $tekstid = array("SUPER ALE <br>-20% kõik tooted!", "KOOLI ALGUS ERI<br>-30% valiktooted!", "VAHEAJA ERI <br>-25% kogu kollektsioonile!");
            $pilt = $pildid[array_rand($pildid)];
            $tekst = $tekstid[array_rand($tekstid)];
            ?>

            <div class="row justify-content-center align-items-center">
                <div class="col-sm-8">
                    <h2><?php echo $tekst; ?></h2>
                    <p>Kasuta ilma taustata pilti. Ja kindlasti võta kasutusele BS5!</p>
                    <button class="btn btn-warning">Vaata pakkumisi →</button>
                </div>
                <div class="col-sm-4">
                    <img src="<?php echo $pilt; ?>" class="img-fluid" alt="Banner">
                </div>
            </div>
        </div>
    </div>

    <?php
    if (!empty($_GET['leht'])) {
        $leht = htmlspecialchars($_GET['leht']);
        $lubatud = array('tooted', 'kontakt', 'admin');
        $kontroll = in_array($leht, $lubatud);
        if ($kontroll == true) {
            include($leht . '.php');
        } else {
            echo '<h1 class="text-center mt-4">Lehte ei eksisteeri!</h1>';
        }
    } else {
        ?>


        <div class="container">
            <div class="row text-center mt-5 mb-5">
                <h2>Parimad pakkumised</h2>
            </div>
            <div class="row">


                <?php
                if ($csv = fopen("tooted.csv", "r")) {
                    fgetcsv($csv);
                    while ($andmed = fgetcsv($csv)) {
                        echo "
                        <div class='col-md-4 mb-4'>
                            <div class='card'>
                                <img src='{$andmed[0]}' class='card-img-top' alt='{$andmed[1]}'>
                                <div class='card-body'>
                                    <h5 class='card-title'>{$andmed[1]}</h5>
                                    <p class='card-text'>{$andmed[2]}€</p>
                                </div>
                            </div>
                        </div>";
                    }
                    fclose($csv);
                }
                ?>
            </div>
        </div>


        <?php
    }
    ?>

    <footer class="bg-dark py-5 mt-5">
        <div class="container text-light text-center">
            <p>Tehvan Mar&puu.com</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>