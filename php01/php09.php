<!-- Tehvan Marjapuu 
Harjutus 9  -->

<!doctype html>
<html lang="et">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>harjutus 9</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
<body>
    <div class="container">
        <h1>Harjutus 09 </h1>
        <div class="row">
            <div class="col-md-4">

            <h2>Tervitus Kasutaja</h2>

                <form method="get">
                    <div class="mb-3">
                        <label class="form-label">Kirjuta oma eesnimi siia</label>
                        <input type="text" class="form-control" name="nimi1">
                    </div>
                    <button type="submit" class="btn btn-warning">Tervita mind!</button>
                </form>  

                <?php
                    if (!empty($_GET["nimi1"])) {
                        $nimi = $_GET["nimi1"];
                        $nimi = ucfirst(strtolower(trim($nimi))); 
                        echo "Hei, $nimi! Kuidas läheb?";
                    }
                ?>

                <br>

                <h2>Sona Tukeldaja</h2>

                <form method="get">
                    <div class="mb-3">
                        <label class="form-label">Pane siia mingi sona</label>
                        <input type="text" class="form-control" name="sona">
                    </div>
                    <button type="submit" class="btn btn-success">L6igu</button>
                </form>  

                <?php
                    if (!empty($_GET["sona"])) {
                        $tekst = $_GET["sona"];
                        $tekst = strtoupper($tekst);
                        $tükid = str_split($tekst);
                        echo implode("-", $tükid);
                    }
                ?>

                <br>

                <h2>censor</h2>

                <form method="get">
                    <div class="mb-3">
                        <label class="form-label">Kirjuta midagi:</label>
                        <input type="text" class="form-control" name="laused">
                    </div>
                    <button type="submit" class="btn btn-danger">Kontrolli!</button>
                </form> 

                <?php
                    echo "<p> loll, tropp, tainaaju</p>";

                    if (!empty($_GET["laused"])) {
                        $kontroll = $_GET["laused"];
                        $asendus = array("tropp", "idioot", "lollpea");
                        $kontroll = str_replace($asendus, "*****", $kontroll);
                        echo "<p>$kontroll</p>";
                    }
                ?>

                <br>

                <h2>Nimi aj Email</h2>

                <form method="get">
                    <div class="mb-3">
                        <label class="form-label">sisesta oma nimi</label>
                        <input type="text" class="form-control" name="eesnimi">
                    </div>
                    <button type="submit" class="btn btn-info">Ggenereeri email</button>
                </form>

                <?php
                    if (!empty($_GET["eesnimi"])) {
                        $nimi2 = $_GET["eesnimi"];
                        $nimi2 = strtolower($nimi2);
                        $otsi = array("ä", "ö", "ü", "õ");
                        $asenda = array("a", "o", "y", "o");
                        $nimi2 = str_replace($otsi, $asenda, $nimi2);
                        $email = $nimi2 . "@hkhk.ee";
                        echo "<p>Email: $email</p>";
                    }
                ?>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
