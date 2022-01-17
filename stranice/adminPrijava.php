<?php
session_start();
if (isset($_SESSION['korisnik_admin_id'])) {
    header('Location: ./admin.php');
    die();
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Admin Prijava</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

 
    </head>
    <body>

        <form method="post" action="../logika/prijaviSe.php" id="prijava_forma">
            <?php if (isset($_GET['aktivacija'])) : ?>
                <p id="greska">
                    Prijavite se kako biste aktivirali nalog!
                </p>
            <?php endif ?>

            <input type="text" name="email" placeholder="Unesite e-mail adresu"><br>
            <input type="password" name="lozinka" placeholder="Unesite lozinku"><br>
            <input type="hidden" name="admin_prijava" value="true">
            <input type="submit" value="Prijavi se"><br>

            <?php if(isset($_GET['greska'])) : ?>
                <p id="greska">
                    Pogresni podaci za prijavu
                </p>
            <?php endif ?>
            <hr>
            <a href="./promenaLozinkeEmail.php">
                Promeni lozinku
            </a>
            <br>
            <a href="./registracija.php">
                Registruj se
            </a>
            <br>
            <a href="./aktiviranNalog.php">
                Posalji mail za aktivaciju naloga
            </a>
            <br>
        </form>
    </body>
</html>