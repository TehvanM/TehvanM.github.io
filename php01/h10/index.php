<!-- Tehvan Marjapuu 
Harjutus 10 -->

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Harjutus 10</title>
    <style>
        menu {
            display: block;
            margin-bottom: 20px;
        }
        menu a {
            margin-right: 15px;
            text-decoration: none;
            color: #333;
        }
        menu a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<menu>
    <a href="index.php">Avaleht</a> |
    <a href="index.php?leht=portfoolio">Portfoolio</a> |
    <a href="index.php?leht=kaart">Kaart</a> |
    <a href="index.php?leht=kontakt">Kontakt</a> |
	<a href="index.php?leht=kontroll">Kontroll</a>

</menu>

<?php
$lubatudLehed = ['portfoolio', 'kaart', 'kontakt', ];

if (!empty($_GET['leht'])) {
    $leht = htmlspecialchars($_GET['leht']);
    
    if (in_array($leht, $lubatudLehed)) {
        $fail = $leht . '.php';
        
        if (file_exists($fail)) {
            include $fail;
        } else {
            echo "<p>Viga: Faili '$fail' ei leitud.</p>";
        }
    } else {
        echo "<p>Valitud lehte ei eksisteeri!</p>";
    }
} else {
    ?>
    <h2>Avaleht</h2>
    <p>
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illo porro eos placeat sit tempora voluptatum? Asperiores dicta praesentium voluptas enim ipsa doloribus cupiditate modi. Quas exercitationem voluptates quod sunt provident.
    </p>
    <?php
}
?>

</body>
</html>