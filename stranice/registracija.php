<?php

$error = null;

if (isset($_GET['greska_podaci'])) {
    $error = "Polja ne smeju biti prazna!";
} else if (isset($_GET['greska_mail'])) {
    $error = "Vec postoji nalog sa tim korisnickim imenom ili email adresom!";
} else if (isset($_GET['greska_lozinka'])) {
    $error = "Lozinke nisu iste!";
} else if (isset($_GET['uspesna_registracija'])) {
    $error = "Uspesno ste se registrovali. Aktivirajte nalog preko email-a!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registracija</title>
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
                <h3>Registruj se</h3>
                <form method="post" action="../logika/registrujSe.php">
                    <div class="form-group">
                        <input type="email" 
                            class="form-control" 
                            name="email" 
                            placeholder="E-mail adresa">
                    </div>
                    <div class="form-group">
                        <input type="text"
                            class="form-control"
                            name="korisnicko_ime"
                            placeholder="Unesite korisnicko ime">
                    </div>
                    <div class="form-group">
                        <input type="password"
                            class="form-control"
                            name="lozinka"
                            placeholder="Lozinka">
                    </div>
                    <div class="form-group">
                        <input type="password"
                            class="form-control"
                            name="ponovi_lozinku"
                            placeholder="Ponovi lozinku">
                    </div>
                    <div class="form-group">
                        <input type="text"
                            class="form-control"
                            name="ime_prezime"
                            placeholder="Unesite ime i prezime">
                    </div>
                    <div class="form-group">
                        <input type="date"
                            class="form-control"
                            name="datum_rodjenja"
                            placeholder="Unesite datum rodjenja">
                    </div>
                    <div class="form-group">
                        <input type="text"
                            class="form-control"
                            name="telefon"
                            placeholder="Broj telefona">
                    </div>
                    <?php if ($error !== null): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $error ?>
                        </div>
                    <?php endif ?>
                    <div class="form-group">
                        <input type="submit"
                            class="btnSubmit"
                            value="Registruj se">
                    </div>
                    <div class="form-group">
                        <a href="./promenaLozinkeEmail.php" class="ForgetPwd">
                            Promeni lozinku
                        </a>
                        <br>
                        <a href="./prijava.php" class="ForgetPwd">
                            Prijavi se
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>