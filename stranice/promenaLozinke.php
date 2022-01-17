<?php
if(isset($_GET['key'])) {
    $token = $_GET['key'];
}

$error = null;

if (isset($_GET['greska_link'])) {
    $error = "Link za resetovanje lozinke nije validan!";
} else if (isset($_GET['uspesna_promena_lozinke'])) {
    $error = "Lozinka je uspesno resetovana mozete se prijaviti sa novom lozinkom!";
} else if (isset($_GET['greska'])) {
    $error = "Doslo je do greske prilikom promene lozinke!";
} else if (isset($_GET['istekao_token'])) {
    $error = "Link za resetovanje lozinke nije vazeci. Molimo posaljite zahtev za resetovanje lozinke ponovo!";
}

// var_dump($token);
// die();
    
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
        <form action='../logika/promeniLozinku.php' method='post' id="lozinka_forma">
            <input type="hidden" name="token" value="<?php echo $token; ?>" >
            <input type="password" name="nova_lozinka" placeholder="Unesite novu lozinku"><br>
            <input type="password" name="ponovi_novu_lozinku" placeholder="Unesite ponovo novu lozinku"><br>
            <input type="submit" name="resetuj_lozinku" value="Promeni lozinku"><br>

            <p>
                <?= $error ?>
            </p>

            <hr>
            <a href="prijava.php">Prijavi se</a><br>
            <a href="registracija.php">Registruj se</a><br>
        </form>
    </body>
</html>