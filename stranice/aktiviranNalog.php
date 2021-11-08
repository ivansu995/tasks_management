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
        <!-- <link rel="stylesheet" href="main.css"> -->
    </head>
    <body>

        <form method="post" action="../logika/slanjePorukeZaAktiviranjeNaloga.php" id="aktivacija_naloga">

            <label for="email">Unesite mail sa kojim ste se registrovali</label>
            <input type="text" name="email" placeholder="Unesite e-mail adresu"><br>

            <br>

            <button id="posalji_mail"> Posalji mail </button>

            <br>
            <p>
                <?= $error ?>
            </p>
        </form>
    </body>
</html>