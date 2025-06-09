<div class="container mt-5">
<div class="row">
<div class="col-12">
<h2 class="text-center mb-4">Kõik meie tooted</h2>
<p class="text-center text-muted">Sirvige läbi meie tootevaliku ja leidke endale sobivaid asju!</p>
</div>
</div>

<div class="row">
<?php
// Kõikide toodete kuvamine
$csv_fail = fopen("tooted.csv", "r");
if ($csv_fail) {
fgetcsv($csv_fail); // päise rida maha
$tooted_kokku = 0;
while ($toote_info = fgetcsv($csv_fail)) {
echo "
<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
<div class='card h-100'>
<img src='{$toote_info[0]}' class='card-img-top' alt='{$toote_info[1]}' style='height: 200px; object-fit: cover;'>
<div class='card-body d-flex flex-column'>
<h5 class='card-title'>{$toote_info[1]}</h5>
<p class='card-text text-success fw-bold fs-5'>{$toote_info[2]}€</p>
<div class='mt-auto'>
<button class='btn btn-primary btn-sm me-2'>Lisa korvi</button>
<button class='btn btn-outline-secondary btn-sm'>Vaata lähemalt</button>
</div>
</div>
</div>
</div>";
$tooted_kokku++;
}
fclose($csv_fail);

if($tooted_kokku == 0) {
echo '<div class="col-12"><div class="alert alert-info text-center">Praegu pole ühtegi toodet saadaval.</div></div>';
}

} else {
echo '<div class="col-12"><div class="alert alert-danger text-center">Viga toodete laadimisel!</div></div>';
}
?>
</div>

<?php if($tooted_kokku > 0): ?>
<div class="row mt-4">
<div class="col-12 text-center">
<p class="text-muted">Kokku leitud <?php echo $tooted_kokku; ?> toodet</p>
</div>
</div>
<?php endif; ?>

</div>