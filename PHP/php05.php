<?php
// Määrame, millist ülesannet töödelda vastavalt GET parameetrile "task"
$task = isset($_GET['task']) ? $_GET['task'] : '';
?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <title>Ülesanne 5 – Mitme ülesande lahendused</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Ülesanne 5 – Mitme ülesande lahendused</h1>
    
    <!-- Navigeerimisnupud erinevate ülesannete jaoks -->
    <nav class="mb-4">
        <a href="?task=tudrukud" class="btn btn-primary">Tüdrukud</a>
        <a href="?task=autod" class="btn btn-primary">Autod</a>
        <a href="?task=keskmised_palgad" class="btn btn-primary">Keskmised palgad</a>
        <a href="?task=firmad" class="btn btn-primary">Firmad</a>
        <a href="?task=riigid" class="btn btn-primary">Riigid</a>
        <a href="?task=hiina_nimed" class="btn btn-primary">Hiina nimed</a>
        <a href="?task=google" class="btn btn-primary">Google</a>
        <a href="?task=pildid" class="btn btn-primary">Pildid</a>
    </nav>
    
    <?php
    /* #########################
       Tüdrukud – massiiv tüdruku nimedega
       ######################### */
    if ($task == "tudrukud") {
        echo '<h2>Tüdrukud</h2>';
        // Koosta vähemalt 8 tüdruku nimedega massiiv
        $girls = array("Liis", "Anna", "Maris", "Katrin", "Maarja", "Eve", "Sofia", "Helena");
        // Sorteeri kasvavas järjekorras
        sort($girls);
        echo '<p><strong>Sorteeritud nimed (üks real iga nimi):</strong></p>';
        echo '<ul>';
        foreach ($girls as $name) {
            echo '<li>' . htmlspecialchars($name) . '</li>';
        }
        echo '</ul>';
        // Väljasta esimesed 3 nime
        echo '<p><strong>Esimesed kolm nime:</strong> ' . htmlspecialchars($girls[0]) . ', ' . htmlspecialchars($girls[1]) . ', ' . htmlspecialchars($girls[2]) . '</p>';
        // Väljasta viimane nimi
        $last = end($girls);
        echo '<p><strong>Viimane nimi:</strong> ' . htmlspecialchars($last) . '</p>';
        // Väljasta suvaline nimi
        $randomIndex = array_rand($girls);
        echo '<p><strong>Suvaline nimi:</strong> ' . htmlspecialchars($girls[$randomIndex]) . '</p>';
    }
    
    /* #########################
       Autod – massiivid auto markidest ja VIN koodidest
       ######################### */
    if ($task == "autod") {
        echo '<h2>Autod</h2>';
        // Auto markide massiiv
        $carBrands = array(
            "Subaru","BMW","Acura","Mercedes-Benz","Lexus","GMC","Volvo","Toyota","Volkswagen","Volkswagen",
            "GMC","Jeep","Saab","Hyundai","Subaru","Mercedes-Benz","Honda","Kia","Mercedes-Benz","Chevrolet",
            "Chevrolet","Porsche","Buick","Dodge","GMC","Dodge","Nissan","Dodge","Jaguar","Ford","Honda",
            "Toyota","Jeep","Kia","Buick","Chevrolet","Subaru","Chevrolet","Chevrolet","Pontiac","Maybach",
            "Chevrolet","Plymouth","Dodge","Nissan","Porsche","Nissan","Mercedes-Benz","Suzuki","Nissan",
            "Ford","Acura","Volkswagen","Lincoln","Mazda","BMW","Mercury","Mitsubishi","Ram","Audi",
            "Kia","Pontiac","Toyota","Acura","Toyota","Toyota","Chevrolet","Oldsmobile","Acura","Pontiac",
            "Lexus","Chevrolet","Cadillac","GMC","Jeep","Audi","Acura","Acura","Honda","Dodge","Hummer",
            "Chevrolet","BMW","Honda","Lincoln","Hummer","Acura","Buick","BMW","Chevrolet","Cadillac",
            "BMW","Pontiac","Audi","Hummer","Suzuki","Mitsubishi","Jeep","Buick","Ford"
        );
        // VIN koodide massiiv
        $vinCodes = array(
            "1GKS1GKC8FR966658", "1FTEW1C87AK375821", "1G4GF5E30DF760067", "1FTEW1CW9AF114701", "WAUGGAFC8CN433989",
            "3G5DA03E83S704506", "4JGDA2EB0DA207570", "1FTEW1E88AK070552", "SAJWA0F77F8732763", "JHMFA3F21BS660717",
            "JTHBP5C29C5750730", "WA1LFAFP9DA963060", "3D7TT2CT6BG521976", "WVWN7EE961049", "2C3CA5CG3BH341234",
            "YV4952CFXC162587", "KNALN4D71F5805172", "JN1CV6EK7BM903692", "5FRYD3H84EB186765", "WAUL64B83N441878",
            "WDDGF4HBXCF845665", "WAUKF78E45A133973", "JN1BY0AR2AM022612", "WA1EY74L69D931520", "3GYFNGEYXBS290465",
            "1D7CW2GK4AS059336", "JN8AZ1FY5EW087447", "WAUBF78E57A343355", "SCFFBCCD8AG695133", "WBAWC73548E143482",
            "3GYFNGE38DS093883", "SCBCP73WC348460", "JN8AE2KPXE9353316", "2C3CDXDT2EH018229", "1G6AH5SX7D0325662",
            "WVWED7AJ7DW431402", "1FTKR1AD3AP316066", "WBAKF5C52CE612586", "1FTNX2A57AE16083", "WAUCFAFR1AA166821",
            "SCFFDAAM3EG486065", "1G4PR5SK5F4821043", "1C3CDFCB4ED858321", "1N6AD0CW8EN722090", "1NXBU4EE0AZ438077",
            "2T1BPRHE7FC131594", "JH4KB1637C451183", "1C4NJCBA7ED747024", "WAUHF68P86A736691", "3D7TT2HT1AG96429",
            "5GADX23L96D250838", "5FRYD3H25FB985936", "1G4GG5E30DF126304", "KNADH5A38B6072755", "WAUBFAFL1BA477979",
            "3C63DRL4CG674293", "1G6AR5SX0E0834815", "1NXBU4EE2AZ309838", "WAUKGBFB4AN797783", "JN1AJ0HP8AM801887",
            "WAUPL68E25A448831", "WA1C8BFP3FA535374", "WAUHE78P78A019744", "TRURD38J081400551", "1G4HP52K95428171",
            "5N1CR2MN1EC607241", "5UMDU93417L322773", "1G6AJ5S35F09585", "JN1CV6AP3BM234743", "SCBCR63W66C842051",
            "SCFFDCBD2AG509467", "WBA3C1C58CA664091", "1D7RW2BK6BS922303", "WAUDH98E67A546009", "2HNYB1H46CH683844",
            "3VW467AT4DM257275", "WDDGF4HB7CA515172", "2G61W5S88E9666199", "5GADV33W17D256205", "2C3CDXDT9CH683075",
            "2G4GU5X0E9989574", "WAUJC58E53A641651", "WDDEJ7KB3CA053774", "3D73M3CL6AG890452", "5GAER13D19J026924",
            "1G4HC5EM1BU329204", "3VWML7AJ6CM772736", "3C6TD4HT2CG011211", "JTDZN3EU2FJ023675", "JN8AZ1MU4CW041721",
            "KNAFX5A82F5991024", "1N6AA0CJ1D57470", "WAUEG98E76A780908", "WAUAF78E96A920706", "1GT01XEG8FZ268942",
            "1FTEW1CW4AF371278", "JN1AZ4EH8DM531691", "WAUEKAFBXAN294295", "1N6AA0EDXFN868772", "WBADW3C59DJ422810"
        );
        
        // Leia autode arv
        $carCount = count($carBrands);
        echo '<p><strong>Autode arv:</strong> ' . $carCount . '</p>';
        
        // Kontrolli, kas massiivide pikkused on võrdsed
        if (count($carBrands) == count($vinCodes)) {
            echo '<div class="alert alert-success">Auto markide ja VIN koodide massiivid on ühepikkused.</div>';
        } else {
            echo '<div class="alert alert-danger">Massiivid ei ole ühepikkused!</div>';
        }
        
        // Leia eraldi Toyotade ja Audide arv
        $brandCounts = array_count_values($carBrands);
        $toyotaCount = isset($brandCounts["Toyota"]) ? $brandCounts["Toyota"] : 0;
        $audiCount = isset($brandCounts["Audi"]) ? $brandCounts["Audi"] : 0;
        echo '<p><strong>Toyotade arv:</strong> ' . $toyotaCount . '</p>';
        echo '<p><strong>Audide arv:</strong> ' . $audiCount . '</p>';
        
        // Leia ja väljasta VIN koodid, mille pikkus on väiksem kui 17
        echo '<p><strong>VIN koodid (alla 17 märki):</strong></p><ul>';
        foreach ($vinCodes as $vin) {
            if (strlen($vin) < 17) {
                echo '<li>' . htmlspecialchars($vin) . ' (' . strlen($vin) . ' märki)</li>';
            }
        }
        echo '</ul>';
    }
    
    /* #########################
       Keskmised palgad – 2018 palkade keskmise arvutamine
       ######################### */
    if ($task == "keskmised_palgad") {
        echo '<h2>Keskmised palgad 2018</h2>';
        $salaries = array(1220,1213,1295,1312,1298,1354,1296,1286,1292,1327,1369,1455);
        $average = array_sum($salaries) / count($salaries);
        echo '<p><strong>Keskmine palk:</strong> ' . number_format($average, 2) . '</p>';
    }
    
    /* #########################
       Firmad – firma nimed, sorteerimine ja võimalus eemaldamiseks
       ######################### */
    if ($task == "firmad") {
        echo '<h2>Firmad</h2>';
        // Koosta firmade nimedega massiiv
        $firms = array("Kimia","Mynte","Voomm","Twiyo","Layo","Talane","Gigashots","Tagchat","Quaxo","Voonyx","Kwilith","Edgepulse","Eidel","Eadel","Jaloo","Oyope","Jamia");
        // Sorteeri massiiv
        sort($firms);
        echo '<p><strong>Sortitud firmade nimed:</strong></p><ul>';
        foreach ($firms as $firm) {
            echo '<li>' . htmlspecialchars($firm) . '</li>';
        }
        echo '</ul>';
        // Kuvame vormi, mis lubab kasutajal eemaldada firma nime järgi
        echo '<h4>Eemalda firma</h4>';
        ?>
        <form method="get" class="mb-4">
            <div class="form-group">
                <label for="removeFirm">Sisesta eemaldatava firma nimi:</label>
                <input type="text" class="form-control" id="removeFirm" name="removeFirm" required>
            </div>
            <input type="hidden" name="task" value="firmad">
            <button type="submit" class="btn btn-warning">Eemalda firma</button>
        </form>
        <?php
        // Kui kasutaja on esitanud firma eemaldamiseks
        if (isset($_GET['removeFirm'])) {
            $removeFirm = trim($_GET['removeFirm']);
            if (($key = array_search($removeFirm, $firms)) !== false) {
                unset($firms[$key]);
                // Taasta indeksid
                $firms = array_values($firms);
                echo '<div class="alert alert-success">Firma "' . htmlspecialchars($removeFirm) . '" eemaldatud.</div>';
            } else {
                echo '<div class="alert alert-danger">Firma "' . htmlspecialchars($removeFirm) . '" ei leitud.</div>';
            }
            echo '<p><strong>Uuendatud firmade nimekiri:</strong></p><ul>';
            foreach ($firms as $firm) {
                echo '<li>' . htmlspecialchars($firm) . '</li>';
            }
            echo '</ul>';
        }
    }
    
    /* #########################
       Riigid – leia kõige pikema riigi nime märkide arv
       ######################### */
    if ($task == "riigid") {
        echo '<h2>Riigid</h2>';
        $countries = array("Indonesia","Canada","Kyrgyzstan","Germany","Philippines","Philippines","Canada","Philippines","South Sudan","Brazil",
                           "Democratic Republic of the Congo","Indonesia","Syria","Sweden","Philippines","Russia","China","Japan",
                           "Brazil","Sweden","Mexico","France","Kazakhstan","Cuba","Portugal","Czech Republic");
        $maxLength = 0;
        foreach ($countries as $country) {
            $len = strlen($country);
            if ($len > $maxLength) {
                $maxLength = $len;
            }
        }
        echo '<p><strong>Kõige pikema riigi nime pikkus:</strong> ' . $maxLength . ' märki</p>';
    }
    
    /* #########################
       Hiina nimed – sorteerimine ja esimese ning viimase nime väljatrükk
       ######################### */
    if ($task == "hiina_nimed") {
        echo '<h2>Hiina nimed</h2>';
        $chineseNames = array("瀚聪","月松","雨萌","展博","雪丽","哲恒","慧妍","博裕","宸瑜","奕漳","思宏","伟菘","彦歆","睿杰","尹智","琪煜","惠茜","晓晴","志宸","博豪","璟雯","崇杉","俊誉","军卿","辰华","娅楠","志宸","欣妍","明美");
        sort($chineseNames);
        echo '<p><strong>Sorteeritud Hiina nimed:</strong></p><ul>';
        foreach ($chineseNames as $name) {
            echo '<li>' . htmlspecialchars($name) . '</li>';
        }
        echo '</ul>';
        echo '<p><strong>Esimene nimi:</strong> ' . htmlspecialchars($chineseNames[0]) . '</p>';
        echo '<p><strong>Viimane nimi:</strong> ' . htmlspecialchars(end($chineseNames)) . '</p>';
    }
    
    /* #########################
       Google – otsingumootori funktsioon nimede kontrollimiseks
       ######################### */
    if ($task == "google") {
        echo '<h2>Google nimed</h2>';
        $googleNames = array("mario","roomet","kent","Bradwell","Dreger","Bloggett","Lambole","Daish","Lippiett","Blackie","Stollenbeck","Houseago","Dugall","Sprowson","Kitley","Mcenamin","Allchin","Doghartie","Brierly","Pirrone","Fairnie","Seal","Scoffins","Galer","Matevosian","DeBlase","Cubbin","Izzett","Ebi","Clohisey","Prater","Probart","Samwaye","Concannon","MacLure","Eliet","Kundt","Reyes");
        ?>
        <form method="get" class="mb-4">
            <div class="form-group">
                <label for="searchName">Otsi nime:</label>
                <input type="text" class="form-control" id="searchName" name="searchName" required>
            </div>
            <input type="hidden" name="task" value="google">
            <button type="submit" class="btn btn-primary">Otsi</button>
        </form>
        <?php
        if (isset($_GET['searchName'])) {
            $searchName = trim($_GET['searchName']);
            if (in_array($searchName, $googleNames)) {
                echo '<div class="alert alert-success">Nimi "' . htmlspecialchars($searchName) . '" leiti massiivist.</div>';
            } else {
                echo '<div class="alert alert-danger">Nime "' . htmlspecialchars($searchName) . '" ei leitud massiivist.</div>';
            }
        }
    }
    
    /* #########################
       Pildid – profiilipiltide massiiv ja kuvamine Bootstrap 6 veerus
       ######################### */
    if ($task == "pildid") {
        echo '<h2>Pildid</h2>';
        // Piltide massiiv; pildid asuvad /img kataloogis
        $images = array("prentice.jpg","freeland.jpg","peterus.jpg","devlin.jpg","gabriel.jpg","pete.jpg");
        // Kuva massiivist kolmas pilt (indeks 2)
        echo '<p><strong>Kolmas pilt:</strong></p>';
        echo '<img src="img/' . htmlspecialchars($images[2]) . '" alt="Pilt" class="img-fluid mb-3">';
        
        // Kuva kõik pildid väikeste piltidena
        echo '<p><strong>Kõik pildid:</strong></p>';
        foreach ($images as $img) {
            echo '<img src="img/' . htmlspecialchars($img) . '" alt="Pilt" class="img-fluid mr-2 mb-2" style="max-width:100px;">';
        }
        
        // Kuvame pildid Bootstrap grid süsteemi abil 6 veerus
        echo '<p class="mt-4"><strong>Pildid 6 veerus:</strong></p>';
        echo '<div class="row">';
        foreach ($images as $img) {
            echo '<div class="col-md-2 col-6 mb-3">';
            echo '<img src="img/' . htmlspecialchars($img) . '" alt="Pilt" class="img-fluid">';
            echo '</div>';
        }
        echo '</div>';
    }
    ?>
</div>

<!-- Bootstrap JS ja sõltuvused -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
