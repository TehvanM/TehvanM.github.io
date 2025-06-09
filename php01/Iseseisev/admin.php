<?php 
session_start();
// Kontroll kas sisse logitud
if(!isset($_SESSION['UserData']['Username'])){
header("location:login.php");
exit;
}
?>
<!doctype html>
<html lang="et">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin leht</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<div class="d-flex justify-content-between align-items-center mb-4">
<h1>Administraatori paneel</h1>
<a href="logout.php" class="btn btn-secondary">Välja logida</a>
</div>

<form method="POST" enctype="multipart/form-data" class="mb-5">
<h2>Uue toote lisamine</h2>
<div class="mb-3">
<label class="form-label">
Toote nimetus:
<input type="text" name="toote_nimi" class="form-control" required>
</label>
</div>
<div class="mb-3">
<label class="form-label">
Toote maksumus:
<input type="number" name="toote_hind" class="form-control" required>
</label>
</div>
<div class="mb-3">
<label class="form-label">
Toote pilt (ainult PNG):
<input type="file" name="toote_pilt" class="form-control" accept=".png" required>
</label>
</div>
<button type="submit" name="lisa" class="btn btn-primary">Lisa uus toode</button>
</form>

<div class="row">
<?php
// Funktsioon andmete lugemiseks
function loeAndmed() {
$toodete_list = [];
$fail = fopen("tooted.csv", "r");
if($fail !== false) {
fgetcsv($fail); // päis rida
while ($rida = fgetcsv($fail)) {
$toodete_list[] = $rida;
}
fclose($fail);
}
return $toodete_list;
}

// Salvestamise funktsioon
function salvestaAndmed($tooted_array) {
$fail = fopen("tooted.csv", "w");
if($fail !== false) {
fputcsv($fail, ["pilt", "toode", "hind"]);
foreach ($tooted_array as $toode_rida) {
fputcsv($fail, $toode_rida);
}
fclose($fail);
}
}

// Kustutamine
if(isset($_GET['kustuta'])) {
$kustuta_id = $_GET['kustuta'];
$praegused_tooted = loeAndmed();
if (isset($praegused_tooted[$kustuta_id])) {
unset($praegused_tooted[$kustuta_id]);
salvestaAndmed($praegused_tooted);
echo "<div class='alert alert-success'>Toode kustutatud!</div>";
}
}

// Uue toote lisamine
if(isset($_POST['lisa'])) {
$nimi = $_POST['toote_nimi'];
$hind = $_POST['toote_hind'];
$pilt_info = $_FILES['toote_pilt'];

$piltide_kaust = "pildid/";
$uus_pildi_nimi = $piltide_kaust . basename($pilt_info['name']);

if(move_uploaded_file($pilt_info['tmp_name'], $uus_pildi_nimi)) {
$olemasolevad_tooted = loeAndmed();
$olemasolevad_tooted[] = [$uus_pildi_nimi, $nimi, $hind];
salvestaAndmed($olemasolevad_tooted);
echo "<div class='alert alert-success'>Toode edukalt lisatud!</div>";
} else {
echo "<div class='alert alert-danger'>Viga pildi üleslaadimisel!</div>";
}
}

echo '<h2>Kõik praegused tooted</h2>';
$koik_tooted = loeAndmed();

foreach($koik_tooted as $indeks => $toode_info) {
echo "
<div class='col-md-4 mb-4'>
<div class='card'>
<img src='{$toode_info[0]}' class='card-img-top' alt='{$toode_info[1]}' style='height: 200px; object-fit: cover;'>
<div class='card-body'>
<h5 class='card-title'>{$toode_info[1]}</h5>
<p class='card-text'>{$toode_info[2]}€</p>
<a href='?kustuta={$indeks}' class='btn btn-danger' onclick='return confirm(\"Kas oled kindel?\")'>Kustuta toode</a>
</div>
</div>
</div>";
}
?>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>