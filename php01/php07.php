 <!-- Tehvan Marjapuu 
Harjutus 7 -->

<!doctype html>
<html lang="et">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PHP Harjutused</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </head>
<body>
    <div class="container">
        <h1>Harjutus 07</h1>
        <div class="row">
            <div class="col-md-4">
                <?php



                    echo "<h2>Tervitus</h2>";

                    function tervita(){
                        return "Tere päiksekesekene!";	
                    }
                    echo tervita();

                    echo "<br>";




                    echo "<br>";
                    echo "<h2>Liitu uudiskirjaga</h2>";

                    function uudiskiri(){
                        return '<form action="" method="post">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Liitun!</button>
                    </form>';

                    }

                    echo uudiskiri();

                    echo "<br>";
                ?>



                    <h2>Kasutajanimi ja email</h2>

                    <form action="" method="get">
                        <div class="mb-3">
                            <label class="form-label">Sisesta kasutajanimi</label>
                            <input type="text" class="form-control" name="kasutaja">
                        </div>
                        <button type="submit" class="btn btn-primary">Saada</button>
                    </form>  
                
                <?php
                    
                    function kasutaja($kasutajanimi){
                        $kasutajanimi = strtolower($kasutajanimi);
                        $email = "$kasutajanimi@hkhk.edu.ee";
                        $kood = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890'), 0, 7);
                        return "Kasutajanimi: $kasutajanimi <br> Email: $email <br> Kood: $kood";
                    }

                    if(isset($_GET['kasutaja'])){
                        echo kasutaja($_GET['kasutaja']);
                    }

                    echo '<br>';

                    

                ?>

                <h2>Arvud</h2>

                <form action="" method="get">
                    <div class="mb-3">
                        <label class="form-label">Sisesta esimene arv</label>
                        <input type="number" class="form-control" name="arv1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label
                        ">Sisesta viimane arv</label>
                        <input type="number" class="form-control" name="arv2">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sammupikkus</label>
                        <input type="number" class="form-control" name="samm">
                    </div>
                    <button type="submit" class="btn btn-primary">Saada</button>
                </form>


                <?php
                    
                    function arvud($arv1, $arv2, $samm) {
                        for ($arv = $arv1; $arv <= $arv2; $arv += $samm) {
                            echo "$arv";
                            echo ", ";
                        }
                    }
                    
                    if (isset($_GET['arv1'], $_GET['arv2'], $_GET['samm'])) {
                        $arv1 = $_GET['arv1'];
                        $arv2 = $_GET['arv2'];
                        $samm = $_GET['samm'];
                    
                        arvud($arv1, $arv2, $samm);

                    }
                    echo '<br>';
                    


                ?>

                <h2>Ristküliku pindala</h2>

                <form action="" method="get">
                    <div class="mb-3">
                        <label class="form-label">Sisesta külg A</label>
                        <input type="number" class="form-control" name="a">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sisesta külg B</label>
                        <input type="number" class="form-control" name="b">
                    </div>
                    <button type="submit" class="btn btn-primary">Saada</button>
                </form>


                <?php
                    
                function pindala($a, $b){
                    $pindala = 2*($a+$b);
                    return $pindala;
                }
                if (isset($_GET['a'], $_GET['b'])) {
                    $a = $_GET['a'];
                    $b = $_GET['b'];
                    echo "Ristküliku pindala on ".pindala($a, $b);
                }

                echo '<br>';
                ?>

                <h2>Isikukood</h2>

                <form action="" method="get">
                    <div class="mb-3">
                        <label class="form-label">Sisesta isikukood</label>
                        <input type="number" class="form-control" name="isikukood">
                    </div>
                    <button type="submit" class="btn btn-primary">Saada</button>
                </form>


                <?php
                    function isikukood($isikukood){
                        $isikukood = strval($isikukood);
                        if(strlen($isikukood) == 11){
                            $sugu = substr($isikukood, 0, 1);
                            if($sugu % 2 == 0){
                                $sugu = "Naine";
                            }else{
                                $sugu = "Mees";
                            }
                            $sunniaeg = substr($isikukood, 1, 2) . "." . substr($isikukood, 3, 2) . "." . substr($isikukood, 5, 2);
                            return "Sugu: $sugu <br> Sünniaeg: $sunniaeg";
                        }else{
                            return "Isikukood on vale pikkusega";
                        }
                    }
                    if(isset($_GET['isikukood'])){
                        echo isikukood($_GET['isikukood']);
                    }
              

                echo '<br>';
                ?>


                <h2>Head mõtted</h2>
                
                <?php
                function motted(){
                    $alus = array("Täna", "Homme", "Ülehomme", "Eile", "Üleeile");
                    $oeldis = array("on", "ei taha", "ei saa olema", "ei saa olla", "ei saa olema");
                    $sihitis = array("päikest", "vihma", "lund", "raha", "õnne");
                    $sona1 = $alus[array_rand($alus)];
                    $sona2 = $oeldis[array_rand($oeldis)];
                    $sona3 = $sihitis[array_rand($sihitis)];
                    return "$sona1 $sona2 $sona3";
                }
                echo motted();

                ?>



            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>