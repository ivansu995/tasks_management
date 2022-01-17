<?php
require_once __DIR__ . '/../tabele/Zadatak.php';
require_once __DIR__ . '/../tabele/Komentar.php';
require_once __DIR__ . '/../tabele/Izvrsava.php';


if(!isset($_SESSION['korisnik_id']) && !isset($_GET['id'])) {
        header('Location: prijava.php');
        die();
}

$zadatak = Zadatak::getById($_GET['id'], 'zadaci', 'Zadatak');
$komentari = Komentar::getKomentarByZadatakId($_GET['id']);
// var_dump($komentari);
// die();
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?= $zadatak->naslov ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    </head>
    <body>
        <script>
            $(function(){
                $('.otvori').on('click', function(){
                    var id = $(this).attr('id').split('_')[1];
                    var red = $(this).parent().parent();
                    $.ajax({
                        'url':'../logika/obrisiKorisnika.php',
                        'method':'post',
                        'data':{
                            'id':id
                        },
                        'success': function(poruka) {
                            var p = JSON.parse(poruka);
                            if (p.status === 'uspesno') {
                                red.remove();
                            } else {
                                alert("Doslo je do greske!");
                            }
                        }
                    })
                });
            })
        </script>
        <!-- <nav>
            <ul>
                <li>
                    <a href="../logika/odjaviSe.php">Odjavi se</a>
                </li>
                <li>
                    <a href="stranica.php">Zadaci</a>
                </li>
            </ul>
        </nav> -->
        <div>
            <h2>Naziv zadatka: <?= $zadatak->naslov ?></h2>
            <h4>Prioritet zadatka: <?= $zadatak->prioritet ?></h4>
            <p><b>Opis zadatka:</b> <?= $zadatak->opis ?> </p>
            <p><b>Prilog:</b></p>
        </div>
        <h3>Komentari:</h3>
        <div>
            <form action="#">
                <textarea name="opis_komentara" id="opis_komentara" placeholder="Unesite komentar"></textarea><br>
                <input type="submit" id="posatavi_komentar" value="Posalji komentar">
            </form>
            <?php foreach($komentari as $komentar): ?>
                <div>
                    <h4><?= $komentar->getKorisnik()->ime_prezime ?></h4>
                    <p><?= $komentar->opis_komentara ?></p>
                </div>
            <?php endforeach ?>
        </div>
    
    </body>
</html>