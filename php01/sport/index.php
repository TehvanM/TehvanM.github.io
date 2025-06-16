<?php include("config.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HKHK spordipäev 2025</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .admin-btn {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .search-form {
            margin: 20px 0;
        }
        .search-form input, .search-form select {
            padding: 5px;
            margin-right: 5px;
        }
        .search-form input[type="submit"] {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
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
        .pagination {
            margin: 20px 0;
        }
        .page-btn {
            background-color: #007bff;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            margin: 2px;
            display: inline-block;
        }
        .page-info {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>Spordipäev 2025</h1>
    <a href="login.php" class="admin-btn">2ge admini page</a>
    
    <form action="index.php" method="get" class="search-form">
        <input type="text" name="otsi" placeholder="Otsing...">
        <select name="cat">
            <option value="fullname">Nimi</option>
            <option value="category">Spordiala</option>
        </select>
        <input type="submit" value="Otsi...">
    </form>

    <?php
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
            $paring = 'SELECT * FROM sport2025 WHERE '.$cat.' LIKE "%'.$s.'%"';
        } else {
            $paring = "SELECT * from sport2025 LIMIT $start, $uudiseid_lehel";
        }
    ?>

    <div class="pagination">
        <?php
            //kuvame lehekülje lingid
            $eelmine = $leht - 1;
            $jargmine = $leht + 1;
            if ($leht>1) {
                echo "<a class='page-btn' href='?page=$eelmine'>Eelmine</a> ";
            }
            if ($lehti_kokku >= 1) {
                for ($i=1; $i<=$lehti_kokku ; $i++) { 
                    if ($i==$leht) {
                        echo "<a class='page-btn' href='?page=$i' style='background-color: #0056b3;'><b>$i</b></a> ";
                    } else {
                        echo "<a class='page-btn' href='?page=$i'>$i</a> ";
                    }
                }
            }
            if ($leht<$lehti_kokku) {
                echo "<a class='page-btn' href='?page=$jargmine'>Järgmine</a> ";
            }
        ?>
    </div>

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
            </tr>
        </thead>
        <tbody>
            <?php
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
                    echo "<td></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>