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
        <link rel="stylesheet" href="../stilovi/forme.css">
    </head>
    <body>
        <div class="container login-container">
            <div class="row">
                <div class="col-md-6 login-form-1">
                    <h3>Promeni lozinku</h3>
                    <form action='../logika/promeniLozinku.php' method='post'>
                        <!-- TOKEN HIDDEN -->
                        <input type="hidden" name="token" value="<?php echo $token; ?>" >
                        <div class="form-group">
                            <input type="password" 
                                class="form-control" 
                                name="nova_lozinka" 
                                placeholder="Unesite novu lozinku">
                        </div>
                        <div class="form-group">
                            <input type="password" 
                                class="form-control"
                                name="ponovi_novu_lozinku" 
                                placeholder="Unesite ponovo novu lozinku">
                        </div>
                        <?php if ($error !== null): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $error ?>
                            </div>
                        <?php endif ?>
                        <div class="form-group">
                            <input type="submit" 
                                class="btnSubmit"
                                name="resetuj_lozinku" 
                                value="Promeni lozinku">
                        </div>
                        <div class="form-group">
                            <a href="./prijava.php" class="ForgetPwd">
                                Prijavi se
                            </a>
                            <br>
                            <a href="./registracija.php" class="ForgetPwd">
                                Registruj se
                            </a>
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>