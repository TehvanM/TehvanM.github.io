<!-- Tehvan Marjapuu iseseisev -->

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto"></div>
            <h2 class="mb-4">Kontaktandmed</h2>
            <div class="row">
                <div class="col-md-6">
                    <h4>Võta meiega ühendust</h4>
                    <p>Meie meeskond on alati valmis sind aitama.</p>
                    <div class="contact-info">
                        <p><i class="bi bi-telephone"></i> <strong>Telefon:</strong> +372 5555 1234</p>
                        <p><i class="bi bi-envelope"></i> <strong>Email:</strong> info@marjapuu.ee, Tehvan.marjapuu@hkhk.edu.ee</p>
                        <p><i class="bi bi-geo-alt"></i> <strong>Aadress:</strong> Haapsalu, Eesti</p>
                        <p><i class="bi bi-clock"></i> <strong>Lahtiolekuajad:</strong> E-R 9:00-18:00</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4>Saada meile sõnum</h4>
                    <form method="post" class="contact-form">
                        <div class="mb-3">
                            <label class="form-label">Su nimi:</label>
                            <input type="text" name="nimi" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email aadress:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teema:</label>
                            <input type="text" name="teema" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sõnum:</label>
                            <textarea name="sonum" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" name="saada" class="btn btn-primary">Saada sõnum</button>
                    </form>
                    <?php
                    if (isset($_POST['saada'])) {
                        echo '<div class="alert alert-success mt-3">Aitäh! Su sõnum on edukalt saadetud.</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
