<?php
require_once __DIR__ . '/../tabele/Zadatak.php';
require_once __DIR__ . '/../tabele/Komentar.php';
require_once __DIR__ . '/../tabele/Izvrsava.php';

// session_start();
if(!isset($_SESSION['korisnik_rukovodilac_id'])) {
        header('Location: prijava.php');
        die();
}
// var_dump($_GET['id']);
// die();

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
                $('.obrisi').on('click', function(e){
                    e.preventDefault();
                    var form = $(this);
                    $.ajax({
                        'url': form.attr('action'),
                        'method': form.attr('method'),
                        'data':{
                            'komentar_id': form.find('[name=komentar_id]').val()
                        },
                        'success': function(poruka) {
                            form.parent().parent().remove();
                        },
                        'error': function(poruka) {
                            console.log(poruka);
                        }
                    })
                });

                $('#komentar_forma').on('submit', function(e){
                    e.preventDefault();
                    var form = $(this);
                                
                    $.ajax({
                        'url': form.attr('action'),
                        'method': form.attr('method'),
                        'data':{
                            'opis_komentara': $('[name="opis_komentara"]').val(),
                            'zadatak_id': $('[name="zadatak_id"]').val(),
                            'korisnik_id': $('[name="korisnik_id"]').val()
                        },
                        'dataType': 'json',
                        'success': function(komentar) {                 
                            $('.komentar:first-of-type').before(
                                '<div class="komentar">' + 
                                    '<h4>' +
                                        komentar.korisnik.ime_prezime +
                                    '</h4>' +
                                    '<p>' +
                                        komentar.opis_komentara +
                                    '</p>' +
                                    // '<button id="obrisi_' + komentar.id + '"' + 
                                    //     'class="obrisi">Obrisi' +
                                    // '</button>' +
                                '</div>'
                            );
                            form.find('textarea').val('');
                        },
                        'error': function(poruka) {
                            console.log(poruka);
                        }
                    })
                });
            })
        </script>
        <div>
            <h2>Naziv zadatka: <?= $zadatak->naslov ?></h2>
            <h4>Prioritet zadatka: <?= $zadatak->prioritet ?></h4>
            <p><b>Opis zadatka:</b> <?= $zadatak->opis ?> </p>
            <p><b>Prilog:</b></p>
            <form action="#">
                <input type="submit" id="zavrsen_zadatak" value="Zavrsen zadatak">
            </form>
        </div>
        <h3>Komentari:</h3>
        <div>
            <form action="../logika/snimiKomentarKorisnik.php" id="komentar_forma" method="post">
                <input type="hidden" name="zadatak_id" id="zadatak_id" value="<?= $zadatak->id ?>">
                <input type="hidden" name="korisnik_id" id="korisnik_id" 
                    value="<?= $_SESSION['korisnik_rukovodilac_id'] ?>">
                <textarea name="opis_komentara" id="opis_komentara" placeholder="Unesite komentar"></textarea><br>
                <input type="submit" id="postavi_komentar" value="Posalji komentar">
            </form>
            <?php foreach($komentari as $komentar): ?>
                <div class="komentar">
                    <h4>
                        <?= $komentar->getKorisnik()->ime_prezime ?>
                        <form action="../logika/obrisiKomentarKorisnik.php" method="post" class="obrisi">
                            <input type="hidden" name="komentar_id" value="<?= $komentar->id ?>">
                            <input type="submit" value="Obrisi">
                        </form>
                    </h4>
                    <p><?= $komentar->opis_komentara ?></p>
                </div>
            <?php endforeach ?>
        </div>
    
    </body>
</html>