<?php
require_once __DIR__ . '/../tabele/Zadatak.php';
require_once __DIR__ . '/../tabele/Korisnik.php';
require_once __DIR__ . '/../tabele/Izvrsava.php';
require_once __DIR__ . '/../tabele/Prilog.php';

if(!isset($_SESSION['korisnik_id']) && !isset($_SESSION['korisnik_admin_id'])) {
    header('Location: prijava.php');
    die();
}

$rukovodioci = Korisnik::getByTip(2);
$clanovi = Korisnik::getByTip(3);

$zadaci = [];
$izvrsava = Izvrsava::getZadatakByKorisnikId($_SESSION['korisnik_id']);
foreach($izvrsava as $i) {
    //Push-uje sve zadatke koji se uzimju po ID-u za korisnika koji ih izvrsava
    //Iz tabele izvrsava jer je veza vise prema vise
    array_push($zadaci, Zadatak::getById($i->getZadatak()->id, 'zadaci', 'Zadatak'));
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Stranica</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body>
    <script>
        // $(function(){
        //     $('.otvori').on('click', function(){
        //         var id = $(this).attr('id').split('_')[1];
        //         var red = $(this).parent().parent();
        //         $.ajax({
        //             'url':'../logika/obrisiKorisnika.php',
        //             'method':'post',
        //             'data':{
        //                 'id':id
        //             },
        //             'success': function(poruka) {
        //                 var p = JSON.parse(poruka);
        //                 if (p.status === 'uspesno') {
        //                     red.remove();
        //                 } else {
        //                     alert("Doslo je do greske!");
        //                 }
        //             }
        //         })
        //     });
        // })
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
        <!-- <hr> -->
        <div>
            <h4>Filtriranje</h4>
            <form method="post" action="../logika/filtrirajStranicu.php">
                <select name="rukovodilac" id="rukovodilac">
                    <?php foreach($rukovodioci as $rukovodilac): ?>
                        <option value="<?= $rukovodilac->id?>"><?= $rukovodilac->ime_prezime ?></option>
                    <?php endforeach ?>
                </select>
                <select name="izvrsilac" id="izvrsilac">
                    <?php foreach($clanovi as $clan): ?>
                        <option value="<?= $clan->id?>"><?= $clan->ime_prezime ?></option>
                    <?php endforeach ?>
                </select>
            </form>
        </div>
        <h2>Lista zadataka</h2>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Naslov</th>
                    <th>Opis</th>
                    <th>Prioritet</th>
                    <th>Pocetak zadatka</th>
                    <th>Kraj zadatka</th>
                    <!-- <th>Prilozi</th> -->
                    <th>Rukovodilac</th>
                    <th>Grupa zadatka</th>
                    <th>Zavrsen</th>
                    <th>Otkazan</th>
                    <th>Otvori zadatak</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($zadaci as $zadatak): ?> 
                    <tr>
                        <td><?= $zadatak->id ?></td>
                        <td><?= $zadatak->naslov ?></td>
                        <td><?= $zadatak->opis ?></td>
                        <td><?= $zadatak->prioritet ?></td>
                        <td><?= $zadatak->pocetak_zadatka ?></td>
                        <td><?= $zadatak->kraj_zadatka ?></td>
                        <td data-korisnik="<?= $zadatak->getKorisnik()->id ?>">
                            <?= $zadatak->getKorisnik()->ime_prezime ?>
                        </td>
                        <td data-grupa-zadatka="<?= $zadatak->getGrupaZadataka()->id ?>">
                            <?= $zadatak->getGrupaZadataka()->naziv ?>
                        </td>
                        <td><?= $zadatak->zavrsen ?></td>
                        <td><?= $zadatak->otkazan ?></td>
                        <td>
                            <button 
                                id="otvori_<?= $zadatak->id ?>" 
                                onclick="location.href='./index.php?strana=zadatak&id=<?= $zadatak->id ?>'">
                                    Otvori
                            </button>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        
    </body>
</html>