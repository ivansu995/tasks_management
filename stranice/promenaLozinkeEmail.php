<?php
session_start();
if (isset($_SESSION['korisnik_id'])) {
    header('Location: ./prijava.php');
    die();
}
$error = null;

if (isset($_GET['poslat_mail'])) {
    $error = "Email sa linkom za promenu lozinke je poslat!";
} else if (isset($_GET['greska_podaci'])) {
    $error = "Polje email je obavezno!";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Promena lozinke</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="../forme.css">
    </head>
    <body>
        <div class="container login-container">
            <div class="row">
                <div class="col-md-6 login-form-1">
                    <h3>Promeni lozinku</h3>
                    <form action='../logika/slanjePorukeZaPromenuLozinke.php' method='post'>
                        <div class="form-group">
                            <input type="text" class="form-control"name="email" placeholder="Unesite e-mail adresu">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btnSubmit" value="Posalji">
                        </div>
                        <div class="form-group">
                            <a href="prijava.php" class="ForgetPwd">Prijavi se</a><br>
                            <a href="registracija.php" class="ForgetPwd">Registruj se</a><br>
                        </div>
                        <p>
                            <?= $error ?>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>