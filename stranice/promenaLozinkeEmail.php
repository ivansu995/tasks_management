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
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <form action='../logika/slanjePorukeZaPromenuLozinke.php' method='post' id="lozinka_forma">
            <input type="text" name="email" placeholder="Unesite e-mail adresu"><br>

            <input type="submit" value="Posalji"><br>

            <p>
                <?= $error ?>
            </p>

            <hr>
            <a href="prijava.php">Prijavi se</a><br>
            <a href="registracija.php">Registruj se</a><br>
        </form>
    </body>
</html>