<!DOCTYPE html>
<html>
    <head>
        <title>Promena lozinke</title>
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <form action='../logika/promeni_lozinku.php' method='post' id="lozinka_forma">
            <input type="text" name="email" placeholder="Unesite e-mail adresu"><br>
            <input type="password" name="stara_lozinka" placeholder="Unesite staru lozinku"><br>
            <input type="password" name="nova_lozinka" placeholder="Unesite novu lozinku"><br>
            <input type="password" name="ponovi_novu_lozinku" placeholder="Unesite ponovo novu lozinku"><br>
            <input type="submit" value="Promeni lozinku"><br>

            <?php if(isset($_GET['greska'])) : ?>
                <p id="greska_lozinka">Pogresni podaci za prijavu</p>
            <?php endif ?>

            <?php if(isset($_GET['greska_lozinka'])) : ?>
                <p id="greska_nova_lozinka">Nove lozinke se ne podudaraju</p>
            <?php endif ?>

            <hr>
            <a href="prijava.php">Prijavi se</a><br>
            <a href="registracija.php">Registruj se</a><br>
        </form>
    </body>
</html>