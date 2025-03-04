<!-- AGATA BRETE JÕPISELG Suvaline pilt – koosta kood, mis valib kataloogist suvalise pildi
Pisipildid veergudes – koosta kood, mis kuvab pisipildid näiteks kolmes veerus. Piltidele klikkides kuvatakse suurem pilt ning veergude arvu saan koodis kiiresti muuta. Pisipildid võid tekitada Photoshsopi abiga. -->
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
        <h1>Harjutus 14</h1>

        <form method="post" action="">
            <select name="pildid"> 
        <option value="">Vali pilt</option>
        <?php 
            $kataloog = '14_pildid';
            $asukoht=opendir($kataloog);
            while($rida = readdir($asukoht)){
                if($rida!='.' && $rida!='..'){
                    echo "<option value='$rida'>$rida</option>\n";
                }
            }
        ?>
    </select>
    <input type="submit" value="Vaata">
    </form>
    <?php
    if(!empty($_POST['pildid'])){
        $pilt = $_POST['pildid'];
        $pildi_aadress = '14_pildid/'.$pilt;
        $pildi_andmed = getimagesize($pildi_aadress);
        
        $laius = $pildi_andmed[0];
        $korgus = $pildi_andmed[1];
        $formaat = $pildi_andmed[2];
        $max_laius = 120;
        $max_korgus = 90;
        
        //suhtearvu leidmine
        if($laius <= $max_korgus && $korgus<=$max_korgus){
            $ratio = 1;	
        } elseif($laius>$korgus){
            $ratio = $max_laius/$laius;	
        } else {
            $ratio = $max_korgus/$korgus;	
        }
        
        //uute mõõtmete leidmine
        $pisi_laius = round($laius*$ratio);
        $pisi_korgus = round($korgus*$ratio);
        
        echo '<h3>Originaal pildi andmed</h3>';
        echo "Laius: $laius<br>";
        echo "Kõrgus: $korgus<br>";
        echo "Formaat: $formaat<br>";
        
        echo '<h3>Uue pildi andmed</h3>';
        echo "Arvutamse suhe: $ratio <br>";
        echo "Laius: $pisi_laius<br>";
        echo "Kõrgus: $pisi_korgus<br>";
        echo "<img width='$pisi_laius' src='$pildi_aadress'><br>";
    }
    ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>