<?php
session_start();
if (isset($_SESSION['korisnik_rukovodilac_id'])) {
    header('Location: ./rukovodilac.php');
    die();
}

$error = null;

if (isset($_GET['aktivacija'])) {
    $error = "Prijavite se kako biste aktivirali nalog!";
} else if(isset($_GET['greska'])) {
    $error = "Pogresni podaci za prijavu!";
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Rukovodilac Prijava</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="../stilovi/forme.css">
    </head>
    <body>
        <div class="container login-container">
            <div class="row">
                <div class="col-md-6 login-form-1">
                    <h3>Prijavi se</h3>
                    <form method="post" action="../logika/prijaviSe.php">
                        <input type="hidden" name="rukovodilac_prijava" value="true">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Unesite e-mail adresu">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="lozinka" placeholder="Unesite lozinku">
                        </div>
                        <?php if ($error !== null): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $error ?>
                            </div>
                        <?php endif ?>
                        <div class="form-group">
                            <input type="submit" class="btnSubmit" value="Prijavi se">
                        </div>
                        <div class="form-group">
                            <a href="./promenaLozinkeEmail.php" class="ForgetPwd">
                                Promeni lozinku
                            </a>
                            <br>
                            <a href="./registracija.php" class="ForgetPwd">
                                Registruj se
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>