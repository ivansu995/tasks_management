<?php

session_start();
if (isset($_SESSION['korisnik_id'])) {
    header('Location: ./prijava.php');
    die();
}

$error = null;

if (isset($_GET['greska_mail'])) {
    $error = "Ne postoji nalog sa tom email adresom!";
} else if (isset($_GET['greska_podaci'])) {
    $error = "Polje ne moze biti prazno!";
} else if (isset($_GET['poslat_mail'])) {
    $error = "Mail sa linkom za aktivaciju je poslat!";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Aktivacija naloga</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
            crossorigin="anonymous">
        <link rel="stylesheet" href="../stilovi/forme.css">
    </head>
    <body>
        <div class="container login-container">
            <div class="row">
                <div class="col-md-6 login-form-1">
                    <h3>Aktiviraj nalog</h3>
                    <form method="post"
                        action="../logika/slanjePorukeZaAktiviranjeNaloga.php">
                        <div class="form-group">
                            <input type="text"
                                class="form-control"
                                name="email"
                                placeholder="Unesite e-mail adresu">
                        </div>
                        <?php if ($error !== null): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $error ?>
                            </div>
                        <?php endif ?>
                        <div class="form-group">
                            <button class="btnSubmit">
                                Posalji mail
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>