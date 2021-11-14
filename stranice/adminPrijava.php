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
        <!-- <link rel="stylesheet" href="main.css"> -->
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