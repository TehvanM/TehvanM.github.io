<!-- Tehvan Marjapuu iseseisev -->

<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sisselogimine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .login-konteiner {
            min-height: 100vh;
        }
        .login-kaart {
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container-fluid login-konteiner d-flex justify-content-center align-items-center">
        <div class="login-kaart">
            <div class="card shadow-lg">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-circle fs-1 text-primary"></i>
                        <h3 class="mt-2">admin sisselogimine</h3>
                        <p class="text-muted">sisesta oma andmed</p>
                    </div>

                    <form action="" method="post" name="Login_Form">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-person me-2"></i>Kasutajanimi
                            </label>
                            <input name="Username" type="text" class="form-control" placeholder="Sisesta kasutajanimi" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-lock me-2"></i>Parool
                            </label>
                            <input name="Password" type="password" class="form-control" placeholder="Sisesta parool" required>
                        </div>

                        <button name="submit" type="submit" value="login" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Logi sisse
                        </button>

                        <?php 
                        session_start();

                        if (isset($_POST['submit'])) {
                            // Kasutajate nimekiri
                            $kasutajad = array(
                                'admin'    => 'Passw0rd',
                                'juhataja' => '12345',
                                'test'     => 'test123'
                            );

                            $kasutajanimi = isset($_POST['Username']) ? $_POST['Username'] : '';
                            $parool = isset($_POST['Password']) ? $_POST['Password'] : '';

                            // Kontrollimine
                            if (isset($kasutajad[$kasutajanimi]) && $kasutajad[$kasutajanimi] == $parool) {
                                $_SESSION['UserData']['Username'] = $kasutajanimi;
                                header("location:admin.php");
                                exit;
                            } else {
                                echo '<div class="alert alert-danger mt-3">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Vale kasutajanimi või parool!
                                </div>';
                            }
                        }
                        ?>

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <a href="index.php" class="text-decoration-none">← Tagasi avalehele</a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>