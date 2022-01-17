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