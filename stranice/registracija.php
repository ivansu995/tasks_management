<!DOCTYPE html>
<html>
<head>
    <title>Registracija</title>
    <!-- <link rel="stylesheet" href="main.css"> -->
</head>
<body>
    <form method="post" action="../logika/registrujSe.php" id="registracija_forma">
        <input type="text" name="email" placeholder="E-mail adresa"><br>
        <input type="text" name="korisnicko_ime" placeholder="Unesite korisnicko ime"><br>
        <input type="password" name="lozinka" placeholder="Lozinka"><br>
        <input type="password" name="ponovi_lozinku" placeholder="Ponovi lozinku"><br>
        <input type="text" name="ime_prezime" placeholder="Unesite ime i prezime"><br>
        <input type="date" name="datum_rodjenja" placeholder="Unesite datum rodjenja"><br>
        <input type="text" name="telefon" placeholder="Broj telefona"><br>

        <?php if(isset($_GET['greska_podaci'])) : ?>
                <p id="greska_postoji_nalog">
                    Polja ne smeju biti prazna!
                </p>
        <?php endif ?>
        <?php if(isset($_GET['greska_mail'])) : ?>
                <p id="greska_postoji_nalog">
                    Vec postoji nalog sa tim korisnickim imenom ili email adresom!
                </p>
        <?php endif ?>
        <?php if(isset($_GET['greska_lozinka'])) : ?>
                <p id="greska_ponovoljene_lozinke">
                    Lozinke se ne podudaraju!
                </p>
        <?php endif ?>
        <?php if(isset($_GET['uspesna_registracija'])) : ?>
                <p id="uspesna_registracija_poruka">
                    Uspesno ste se registrovali. Aktivirajte nalog preko email-a!
                </p>
        <?php endif ?>
        
        <input type="submit" value="Registruj se">
        <hr>
        <a href="prijava.php">Prijavi se</a><br>
        <a href="./promenaLozinkeEmail.php">Promeni lozinku</a><br>
    </form>
</body>
</html>
 