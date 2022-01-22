<?php

require_once __DIR__ . '/../tabele/Zadatak.php';
require_once __DIR__ . '/../tabele/Komentar.php';
require_once __DIR__ . '/../tabele/Izvrsava.php';

if (!isset($_SESSION['korisnik_admin_id'])) {
    header('Location: prijava.php');
    die();
}

$prilozi = Prilog::getByIdZadatka($_GET['id']);
$zadatak = Zadatak::getById($_GET['id'], 'zadaci', 'Zadatak');
$komentari = Komentar::getKomentarByZadatakId($_GET['id']);

?>

<!DOCTYPE html>
<html>
    <head>
        <title><?= $zadatak->naslov ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
            rel="stylesheet" 
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
            crossorigin="anonymous">
        <link rel="stylesheet" href="../stilovi/main.css">
        <link rel="stylesheet" href="../stilovi/navbar.css">
        <link rel="stylesheet" href="../stilovi/forme.css">
        <link rel="stylesheet" href="../stilovi/zadatakPrikaz.css">
    </head>
    <body>
        <script>
            $(function(){
                $('.obrisi_komentar').on('click', function(e){
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
                                    '<div class="naslov_komentara">' +
                                        '<h5 class="ime_korisnika">' +
                                            komentar.korisnik.ime_prezime + 
                                            ' - ' +
                                            komentar.kreiran +
                                        '</h5>' +
                                    '</div>' +
                                    '<div class="ostatak_komentara">' +
                                        '<p>' +
                                            komentar.opis_komentara +
                                        '</p>' +
                                    '</div>' +
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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-9">
                    <div class="naslov_zadatka">
                        <h2 class="naziv_zadatka"><?= $zadatak->naslov ?></h2>
                    </div>
                    <div class="ostatak_zadatka">
                        <p class="prioritet">
                            Prioritet zadatka: <?= $zadatak->prioritet ?>
                        </p><hr>
                        <p >
                            Opis zadatka: <?= $zadatak->opis ?>
                        </p><hr>
                        <p>
                            Prilog:
                            <?php foreach($prilozi as $p): ?>
                                <?php if($_GET['id'] === $p->zadatak_id): ?> 
                                    <a href="../<?= $p->naziv_priloga ?>">
                                        <?= $p->naziv_fajla . " " ?>
                                    </a>
                                <?php endif ?>
                            <?php endforeach ?>
                        </p>
                    </div>
                </div>
                <div class="col-3 jusify-content-center">
                    <div class="forma">
                        <div class="chart" data-percent="<?= $trenutni_procenat ?>">
                            <div class="percent">
                                <?= $trenutni_procenat ?>
                            </div>
                        </div>
                    </div>
                    <form action="../logika/zavrsiZadatak.php" 
                        method="post" 
                        id="zavrsen_zadatak">
                        Ovde ubaci za zavrsetak zadatka
                    </form> 
                </div>
            </div>
            <hr>
            <div class="row justify-content-center">
                <div class="col-8">
                    <h3>Komentari</h3>
                    <div>
                        <form action="../logika/snimiKomentarKorisnik.php"
                            id="komentar_forma" method="post">
                            <div class="form-group">
                                <textarea name="opis_komentara"
                                    id="opis_komentara"
                                    placeholder="Unesite komentar"
                                    class="form-control"
                                    rows="3">
                                </textarea>                             
                            </div>
                            <input type="hidden"
                                name="zadatak_id"
                                id="zadatak_id"
                                value="<?= $zadatak->id ?>">
                            <input type="hidden"
                                name="korisnik_id"
                                id="korisnik_id" 
                                value='<?= $_SESSION['korisnik_admin_id'] ?>'>
                            <input type="submit"
                                id="postavi_komentar"
                                value="Posalji komentar"
                                class="btnKomentar">
                        </form>
                    </div>
                </div><hr>
            </div>
            <div class="row justify-content-center">
                <div class="col-8">
                    <?php foreach($komentari as $komentar): ?>
                        <div class="komentar">
                            <div class="naslov_komentara">
                                <h5 class="ime_korisnika">
                                    <?= $komentar->getKorisnik()->ime_prezime . 
                                        " - " . 
                                        date('d.m.Y. H:i', 
                                        strtotime($komentar->kreiran)) ?>
                                </h5>
                                <form action="../logika/obrisiKomentarKorisnik.php" 
                                    method="post"
                                    class="obrisi_komentar">
                                    <input type="hidden"
                                        name="komentar_id"
                                        value="<?= $komentar->id ?>">
                                    <input type="submit"
                                        class="obrisi"
                                        value="Obrisi">
                                </form>
                            </div>
                            <div class="ostatak_komentara">
                                <p>
                                    <?= $komentar->opis_komentara ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div> 
    </body>
</html>