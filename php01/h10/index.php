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

<nav>
    <ul style="list-style: none; padding: 0; margin: 0; display: flex;">
        <li style="margin-right: 15px;"><a href="index.php">Avaleht</a></li>
        <li style="margin-right: 15px;"><a href="index.php?leht=portfoolio">Portfoolio</a></li>
        <li style="margin-right: 15px;"><a href="index.php?leht=kaart">Kaart</a></li>
        <li style="margin-right: 15px;"><a href="index.php?leht=kontakt">Kontakt</a></li>
        <li><a href="index.php?leht=kontroll">Kontroll</a></li>
    </ul>
</nav>

<?php
$lubatudLehed = ['portfoolio', 'kaart', 'kontakt', ];

if (!empty($_GET['leht'])) {
    $leht = htmlspecialchars($_GET['leht']);
    
    $fail = "{$leht}.php";
    $fail = $leht . '.php';
    
    if (file_exists($fail)) {
        include $fail;
    } else {
        echo "<p>Viga: Faili '$fail' ei leitud.</p>";
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