 <!-- Tehvan Marjapuu 
Harjutus IS  -->

<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Harjutused</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <form action="" method="post" name="Login_Form" class="border p-4 rounded shadow-sm bg-white">

            <div class="mb-3">
                <label class="form-label">Kasutajanimi</label>
                <input name="Username" type="text" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Parool</label>
                <input name="Password" type="password" class="form-control">
            </div>

            <button name="submit" type="submit" value="login" class="btn btn-primary w-100">Logi sisse</button>
        
            <?php 
            session_start();   
            if(isset($_POST['submit'])){
                $logins = array('admin' => 'Passw0rd');
                $Username = isset($_POST['Username']) ? $_POST['Username'] : '';
                $Password = isset($_POST['Password']) ? $_POST['Password'] : '';        
                if (isset($logins[$Username]) && $logins[$Username] == $Password){
                    $_SESSION['UserData']['Username']=$logins[$Username];
                    header("location:../admin.php");
                    exit;
                }
            }
            ?>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>