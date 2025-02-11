<!doctype html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>PHP Ülesanded Bootstrapiga</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
  <h1 class="mb-4">PHP Ülesanded Bootstrapiga</h1>
  
  <!-- Nav-tabs vahekaardid -->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <!-- Ülesanne 1: Muutujad ja väljund -->
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="ulesanne1-tab" data-bs-toggle="tab" data-bs-target="#ulesanne1" type="button" role="tab" aria-controls="ulesanne1" aria-selected="true">
        Ülesanne 1
      </button>
    </li>
    <!-- Ülesanne 2: Arvutused ja vormindamine -->
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="ulesanne2-tab" data-bs-toggle="tab" data-bs-target="#ulesanne2" type="button" role="tab" aria-controls="ulesanne2" aria-selected="false">
        Ülesanne 2
      </button>
    </li>
    <!-- Ülesanne 3: Vormid ja andmete töötlemine -->
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="ulesanne3-tab" data-bs-toggle="tab" data-bs-target="#ulesanne3" type="button" role="tab" aria-controls="ulesanne3" aria-selected="false">
        Ülesanne 3
      </button>
    </li>
  </ul>

  <!-- Vahekaardid sisu jaoks -->
  <div class="tab-content" id="myTabContent">
    <!-- Ülesanne 1: Muutujad ja väljund (sinu antud kood) -->
    <div class="tab-pane fade show active p-3" id="ulesanne1" role="tabpanel" aria-labelledby="ulesanne1-tab">
      <?php
      /**
       * PHP
       * 01 - PHP - Muutujad
       * Tehvan Marjapuu
       * Haapsalu Kutsehariduskeskus
       * 11.02.2025
       */
      
      $nimi = "Tanel";
      $sunniaasta = "2015";
      $tahtkuju = "Kaksikud";
      
      echo "Nimi: $nimi" . '<br>';
      echo "Sünniaasta: $sunniaasta" . '<br>';
      echo "Tähtkuju: $tahtkuju" . '<br>';
      
      // Väljasta järgnev lause
      echo "\"It’s My Life\" – Dr. Alban" . '<br>';
      
      // "Joonista" järgmine pilt
      echo "(\(\\" . '<br>';
      echo "( -.-)" . '<br>';
      echo "o_(\")(\")" . '<br>';
      ?>
    </div>
    
    <!-- Ülesanne 2: Arvutused ja vormindamine -->
    <div class="tab-pane fade p-3" id="ulesanne2" role="tabpanel" aria-labelledby="ulesanne2-tab">
      <?php
      // Ülesanne 2 - ChatGPT - 2025-02-11
      
      // 2.1: Kaks täisarvulist muutujat ja nende vahel teostatud tehed
      $a = 15;
      $b = 4;
      $sum = $a + $b;
      $diff = $a - $b;
      $prod = $a * $b;
      $quot = $a / $b;
      $mod = $a % $b;
      
      // 2.2: Millimeetrite teisendamine (mm -> cm ja m)
      $mm = 1234;
      $cm = $mm / 10;
      $m = $mm / 1000;
      
      // 2.3: Täisnurkse kolmnurga arvutused (3-4-5 kolmnurk)
      $sideA = 3;
      $sideB = 4;
      $sideC = sqrt($sideA * $sideA + $sideB * $sideB);
      $triangle_perimeter = $sideA + $sideB + $sideC;
      $triangle_area = ($sideA * $sideB) / 2;
      ?>
      <h2>Arvutused ja vormindamine</h2>
      <h4>Aritmeetilised tehete näited</h4>
      <p><?php echo "$a + $b = $sum"; ?></p>
      <p><?php echo "$a - $b = $diff"; ?></p>
      <p><?php echo "$a * $b = $prod"; ?></p>
      <p><?php echo "$a / $b = $quot"; ?></p>
      <p><?php echo "$a % $b = $mod"; ?></p>
      
      <h4>Millimeetrite teisendamine</h4>
      <p><?php echo "$mm mm = " . number_format($cm, 2) . " cm"; ?></p>
      <p><?php echo "$mm mm = " . number_format($m, 2) . " m"; ?></p>
      
      <h4>Täisnurkse kolmnurga arvutused (3-4-5)</h4>
      <p><?php echo "Kolmnurga ümbermõõt: " . round($triangle_perimeter) . " ühikut"; ?></p>
      <p><?php echo "Kolmnurga pindala: " . round($triangle_area) . " ruutühikut"; ?></p>
    </div>
    
    <!-- Ülesanne 3: Vormid ja andmete töötlemine -->
    <div class="tab-pane fade p-3" id="ulesanne3" role="tabpanel" aria-labelledby="ulesanne3-tab">
      <?php
      // Ülesanne 3 - ChatGPT - 2025-02-11
      // Kontrollime, kas vormi andmed on esitatud; kui mitte, kuvatakse vorm,
      // vastasel juhul töödeldakse sisestatud andmed.
      if (!isset($_GET['submit'])) {
      ?>
      <h2>Sisesta andmed (Trapetsi ja rombi arvutused)</h2>
      <form method="get" action="" class="mt-3">
        <div class="mb-3">
          <label for="a" class="form-label">Trapetsi esimene alus (a):</label>
          <input type="number" step="any" class="form-control" id="a" name="a" required>
        </div>
        <div class="mb-3">
          <label for="b" class="form-label">Trapetsi teine alus (b):</label>
          <input type="number" step="any" class="form-control" id="b" name="b" required>
        </div>
        <div class="mb-3">
          <label for="h" class="form-label">Trapetsi kõrgus (h):</label>
          <input type="number" step="any" class="form-control" id="h" name="h" required>
        </div>
        <div class="mb-3">
          <label for="side" class="form-label">Rombi külje pikkus:</label>
          <input type="number" step="any" class="form-control" id="side" name="side" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Arvuta</button>
      </form>
      <?php
      } else {
          // Andmete vastuvõtt ja töötlemine
          $a = $_GET['a'];
          $b = $_GET['b'];
          $h = $_GET['h'];
          $side = $_GET['side'];
          
          // Trapetsi pindala arvutamine: ((a + b) / 2) * h
          $trapetsi_pindala = round((($a + $b) / 2) * $h, 1);
          
          // Rombi ümbermõõdu arvutamine: 4 * side
          $rombi_umbermoot = round(4 * $side, 1);
          ?>
          <h2>Tulemused</h2>
          <p><?php echo "Trapetsi pindala on $trapetsi_pindala ruutühikut."; ?></p>
          <p><?php echo "Rombi ümbermõõt on $rombi_umbermoot ühikut."; ?></p>
          <?php
      }
      ?>
    </div>
  </div>
</div>

<!-- Bootstrap JS ja sõltuvused -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>