<?php
    include("../config.php"); 
    session_start();
    if (!isset($_SESSION['tuvastamine'])) {
        header('Location: ../login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin area</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }
        h1 {
            color: #333;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .form-group {
            margin: 10px 0;
        }
        .form-group label {
            display: inline-block;
            width: 100px;
            font-weight: bold;
        }
        .form-group input {
            padding: 5px;
            width: 200px;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px 2px;
        }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-danger { background-color: #dc3545; color: white; }
        .search-form {
            margin: 20px 0;
        }
        .search-form input, .search-form select {
            padding: 5px;
            margin-right: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #e9ecef;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .page-info {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <a class="logout-btn" href="../logout.php?logout">Logi välja</a>
    <h1>Eriti salajane</h1>
    
    <?php
        if(isset($_GET["muuda"]) && isset($_GET["id"])){
            $id = $_GET["id"];
            $kuvaparing = "SELECT * FROM sport2025 WHERE id=".$id."";
            $saada_paring = mysqli_query($yhendus, $kuvaparing);
            $rida = mysqli_fetch_assoc($saada_paring);
        }

        if(isset($_GET["salvesta_muudatus"]) && isset($_GET["id"])){
            $id = $_GET["id"];
            $fullname = $_GET["fullname"];
            $email = $_GET["email"];
            $age = $_GET["age"];
            $gender = $_GET["gender"];
            $category = $_GET["category"];

            $muuda_paring="UPDATE sport2025 SET fullname='".$fullname."', email='".$email."',age='".$age."',gender='".$gender."',category='".$category."' WHERE id = ".$id.""; 

            $saada_paring = mysqli_query($yhendus, $muuda_paring);
            $tulemus = mysqli_affected_rows($yhendus);
            if($tulemus == 1){
                header('Location: index.php?msg=Andmed uuendatud');
            } else {
                echo "Andmeid ei uuendatud";
            }
        }
    ?>
    
    <form action="index.php" method="get">
        <input type="hidden" name="id" value="<?php !empty($rida['id']) ? print_r($rida['id']) : '' ?>">
        <div class="form-group">
            <label>Nimi:</label>
            <input type="text" name="fullname" required value="<?php !empty($rida['fullname']) ? print_r($rida['fullname']) : '' ?>">
        </div>
        <div class="form-group">
            <label>E-mail:</label>
            <input type="email" name="email" required value="<?php !empty($rida['email']) ? print_r($rida['email']) : '' ?>">
        </div>
        <div class="form-group">
            <label>Vanus:</label>
            <input type="number" name="age" min="16" max="88" step="1" required value="<?php !empty($rida['age']) ? print_r($rida['age']) : '' ?>">
        </div>
        <div class="form-group">
            <label>Sugu:</label>
            <input type="text" name="gender" required value="<?php !empty($rida['gender']) ? print_r($rida['gender']) : '' ?>">
        </div>
        <div class="form-group">
            <label>Spordiala:</label>
            <input type="text" name="category" required value="<?php !empty($rida['category']) ? print_r($rida['category']) : '' ?>">
        </div>
        <?php if(isset($_GET["muuda"]) && isset($_GET["id"])){ ?>
            <input type="submit" value="Salvesta_muudatus" name="salvesta_muudatus" class="btn btn-success">
        <?php } else { ?>
            <input type="submit" value="Salvesta" name="salvesta" class="btn btn-primary">
        <?php } ?>
    </form>
    
    <?php
        if(isset($_GET['msg'])){
            echo "<div class='alert'>".$_GET['msg']."</div>";
        }
        if(isset($_GET["salvesta"]) && !empty($_GET["fullname"])){
            $fullname = $_GET["fullname"];
            $email = $_GET["email"];
            $age = $_GET["age"];
            $gender = $_GET["gender"];
            $category = $_GET["category"];

            $lisa_paring = "INSERT INTO sport2025 (fullname,email,age,gender,category) 
            VALUES ('".$fullname."', '".$email."', '".$age."', '".$gender."', '".$category."')";

            $saada_paring = mysqli_query($yhendus, $lisa_paring);
            $tulemas = mysqli_affected_rows($yhendus);
            if($tulemas == 1){
                echo "Kirje edukalt lisatud";
            } else {
                echo "Kirjet ei lisatud";
            }
        }
    ?>

    <form action="index.php" method="get" class="search-form">
        <input type="text" name="otsi">
        <select name="cat">
            <option value="fullname">Nimi</option>
            <option value="category">Spordiala</option>
        </select>
        <input type="submit" value="Otsi...">
    </form>

    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>firstname</th>
                <th>email</th>
                <th>age</th>
                <th>gender</th>
                <th>category</th>
                <th>reg_time</th>
                <th>muuda</th>
                <th>kustuta</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(isset($_GET['kustuta']) && isset($_GET['id'])){
                    $id = $_GET['id'];
                    $kparing = "DELETE FROM sport2025 WHERE id=".$id."";
                    $saada_paring = mysqli_query($yhendus, $kparing);
                    $tulemus = mysqli_affected_rows($yhendus);
                    if($tulemus == 1){
                        header('Location: index.php?msg=Rida kustutatud');
                    } else {
                        echo "Kirjet ei kustutatud";
                    }
                }

                // Leheküljenumber
                $uudiseid_lehel = 50;

                $uudiseid_kokku_paring = "SELECT COUNT('id') FROM sport2025";
                $lehtede_vastus = mysqli_query($yhendus, $uudiseid_kokku_paring);
                $uudiseid_kokku = mysqli_fetch_array($lehtede_vastus);
                $lehti_kokku = $uudiseid_kokku[0];
                $lehti_kokku = ceil($lehti_kokku/$uudiseid_lehel);
                
                echo '<div class="page-info">Lehekülgi kokku: '.$lehti_kokku.'<br>';
                echo 'Uudiseid lehel: '.$uudiseid_lehel.'</div>';

                //kasutaja valik
                if (isset($_GET['page'])) {
                    $leht = $_GET['page'];
                } else {
                    $leht = 1;
                }
                //millest näitamist alustatakse
                $start = ($leht-1)*$uudiseid_lehel;

                if(isset($_GET['otsi']) && !empty($_GET["otsi"])){
                    $s = $_GET['otsi'];
                    $cat = $_GET['cat'];
                    echo "<tr><td colspan='9'>Otsing: ".$s."</td></tr>";
                    $paring = 'SELECT * FROM sport2025 WHERE '.$cat.' LIKE "%'.$s.'%"';
                } else {
                    $paring = "SELECT * from sport2025 LIMIT $start, $uudiseid_lehel";
                }
                
                $saada_paring = mysqli_query($yhendus, $paring);
                while($rida = mysqli_fetch_assoc($saada_paring)){
                    echo "<tr>";
                    echo "<td>".$rida['id']."</td>";
                    echo "<td>".$rida['fullname']."</td>";
                    echo "<td>".$rida['email']."</td>";
                    echo "<td>".$rida['age']."</td>";
                    echo "<td>".$rida['gender']."</td>";
                    echo "<td>".$rida['category']."</td>";
                    echo "<td>".$rida['reg_time']."</td>";
                    echo "<td><a class='btn btn-success' href='?muuda&id=".$rida['id']."'>Muuda</a></td>";
                    echo "<td><a class='btn btn-danger' href='?kustuta&id=".$rida['id']."'>Kustuta</a></td>";
                    echo "</tr>";
                }

                //kuvame lehekülje lingid
                $eelmine = $leht - 1;
                $jargmine = $leht + 1;
                if ($leht>1) {
                    echo "<a class='btn btn-primary' href='?page=$eelmine'>Eelmine</a> ";
                }
                if ($lehti_kokku >= 1) {
                    for ($i=1; $i<=$lehti_kokku ; $i++) { 
                        if ($i==$leht) {
                            echo "<a class='btn btn-primary' href='?page=$i' style='background-color: #0056b3;'><b>$i</b></a> ";
                        } else {
                            echo "<a class='btn btn-primary' href='?page=$i'>$i</a> ";
                        }
                    }
                }
                if ($leht<$lehti_kokku) {
                    echo "<a class='btn btn-primary' href='?page=$jargmine'>Järgmine</a> ";
                }
            ?>
        </tbody>
    </table>
</body>
</html>