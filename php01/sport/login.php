<?php
    include("config.php"); 
    session_start();
    if (isset($_SESSION['tuvastamine'])) {
        header('Location: admin/');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .login-btn {
            width: 100%;
            background-color: #0e1c36;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .checkbox-group {
            margin: 20px 0;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            if (!empty($_POST['user']) && !empty($_POST['password'])) {
                $login = $_POST['user'];
                $str = $_POST['password'];
                
                $paring = "SELECT * FROM users";
                $saada_paring = mysqli_query($yhendus, $paring);
                $rida = mysqli_fetch_assoc($saada_paring);
                $s = $rida["password"];
                
                if ($login == 'admin' && password_verify($str, $s)) {
                    $_SESSION['tuvastamine'] = 'misiganes';
                    header('Location: admin/');
                    exit();
                } else {
                    echo "<div class='error'>Vale kasutajanimi või parool</div>";
                }
            }
        ?>

        <h2>Login sisse</h2>
        <form method="post">
            <div class="form-group">
                <input type="text" name="user" placeholder="Kasutaja" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Parool" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
            <div class="checkbox-group">
                <label>
                    <input type="checkbox" name="remember"> Mäleta mind
                </label>
            </div>
        </form>
    </div>
</body>
</html>