<!-- AGATA BRETE JÕPISELG Kasutaja lisab vormi nime, seda näiteks suured ja väikesed tähed läbisegi. Sina kood tervitab teda kenasti nimepidi, kus nimi algab suure algustähega.
Näiteks: sisend–>mARiO; väljund–>Tere, Mario!
Kuna on teada, et PHP käsitleb teksti kui massiivi, siis peaks saama seda tsükli abil nö. tükeldada. Ülesandeks on etteantud teksti iga tähe järgi lisada punkt.
Näiteks: sisend–>stalker; väljund–>S.T.A.L.K.E.R.
Koosta tekstiväli, mis kuvab kasutaja sisestatud sõnumeid. Kasutaja ropud sõnad asendatakse tärnidega.
Näiteks: sisend–>Sa oled täielik noob; väljund–>Sa oled täielik ***
Kasutajalt saadud eesnime ja perenime põhjal luuakse talle email lõpuga @hkhk.edu.ee. Kusjuures täpitähed asendatakse ä->a, ö->o, ü->y, õ->o ja kogu email on väikeste tähtedega
Näiteks: sisend–>Ülle ja Doos; väljund–>ylle.doos@hkhk.edu.ee -->
<!doctype html>
<html lang="et">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Harjutused</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </head>
<body>
    <div class="container">
        <h1>Harjutus 9</h1>
        <div class="row">
            <div class="col-md-4">

            <h2>Kasutaja tervitus</h2>

                <form action="" method="get">
                    <div class="mb-3">
                        <label class="form-label">Sisesta oma nimi!</label>
                        <input type="text" class="form-control" name="kasutaja">
                    </div>
                    <button type="submit" class="btn btn-primary">Saada</button>
                </form>  


                <?php

                if (isset($_GET["kasutaja"])) {
                    $kasutaja = $_GET["kasutaja"];
                    $kasutaja = ucfirst(strtolower($kasutaja));
                    echo "Tere, $kasutaja!";
                }

                ?>


                <br>

                <h2>Teksti tükeldamine</h2>

                <form action="" method="get">
                    <div class="mb-3">
                        <label class="form-label">Sisesta oma nimi!</label>
                        <input type="text" class="form-control" name="sisend">
                    </div>
                    <button type="submit" class="btn btn-primary">Saada</button>
                </form>  

                <?php

                if (isset($_GET["sisend"])) {
                    $sisend = $_GET["sisend"];
                    $sisend = strtoupper($sisend);
                    $sisend = str_split($sisend);
                    $sisend = implode(".", $sisend);
                    echo $sisend;
                }

                ?>

                <br>

                <h2>Ropud sõnad</h2>

                <form action="" method="get">
                    <div class="mb-3">
                        <label class="form-label">Sisesta oma nimi!</label>
                        <input type="text" class="form-control" name="parandus">
                    </div>
                    <button type="submit" class="btn btn-primary">Saada</button>
                </form> 

                <?php
                
                echo "noob, loll ja jobu";

                if (isset($_GET["parandus"])) {
                    $parandus = $_GET["parandus"];
                    $parandus = str_replace(array("noob", "loll", "jobu"), "***", $parandus);
                    echo $parandus;
                }

                ?>

                <br>

                <h2>Täpitähed ja email</h2>

                <form action="" method="get">
                    <div class="mb-3">
                        <label class="form-label">Sisesta oma nimi!</label>
                        <input type="text" class="form-control" name="nimi">
                    </div>
                    <button type="submit" class="btn btn-primary">Saada</button>
                </form>

                <?php

                if (isset($_GET["nimi"])) {
                    $nimi = $_GET["nimi"];
                    $nimi = strtolower($nimi);
                    $nimi = str_replace(array("ä", "ö", "ü", "õ"), array("a", "o", "y", "o"), $nimi);
                    $email = "$nimi@hkhk.edu.ee";
                    echo $email;
                }

                ?>



            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>