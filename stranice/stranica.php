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

foreach($zadaci as $zadatak) {
    $prilozi = Prilog::getByIdZadatka($zadatak->id);
}

$izvrsioci = Izvrsava::getAll();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Stranica</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
            rel="stylesheet" 
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
            crossorigin="anonymous">
    </head>
    <body>
        <div>
            <h4>Filtriranje</h4>
            <form method="post" action="#tabela">
            <input type="text" name="rukovodilac_pretraga" placeholder="Ime rukovodioca" id="rukovodilac_pretraga">
                <select name="izvrsilac_pretraga" id="izvrsilac">
                    <option value="">Nije izabrano</option>
                    <?php foreach($clanovi as $clan): ?>
                        <option value="<?= $clan->ime_prezime?>">
                            <?= $clan->ime_prezime ?>
                        </option>
                    <?php endforeach ?>
                </select>
                <input type="date" name="kraj_zadatka_pretraga" id="kraj_zadatka_pretraga"><br>
                <input type="submit" name="pretraga" value="Filtriraj">
            </form>
        </div>
        <h2>Lista zadataka</h2>
        <table class="table table-hover" id="tabela">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Naslov</th>
                    <th>Opis</th>
                    <th>Prioritet</th>
                    <th>Pocetak zadatka</th>
                    <th>Kraj zadatka</th>
                    <th>Prilozi</th>
                    <th>Izvrsioci</th>
                    <th>Rukovodilac</th>
                    <th>Grupa zadatka</th>
                    <th>Zavrsen</th>
                    <th>Otkazan</th>
                    <th>Otvori zadatak</th>
                </tr>
            </thead>
            <tbody id="tabela_podaci">
                <?php if (isset($_POST['pretraga'])): ?>
                    <?php
                        $izvrsilac = $_POST['izvrsilac_pretraga'];
                        $rukovodilac = $_POST['rukovodilac_pretraga'];
                        $kraj_zadatka = $_POST['kraj_zadatka_pretraga'];
                        $filtrirani_zadaci = [];

                        if (!empty($rukovodilac)) {
                            $rukovodilac = Korisnik::getKorisnikByName($rukovodilac)->id;
                            foreach($zadaci as $zadatak) {
                                if ($zadatak->rukovodilac_id === $rukovodilac) {
                                    array_push($filtrirani_zadaci, $zadatak);
                                }
                            }
                        } elseif (!empty($kraj_zadatka)) {
                            foreach($zadaci as $zadatak) {
                                if ($zadatak->kraj_zadatka === $kraj_zadatka) {
                                    array_push($filtrirani_zadaci, $zadatak);
                                }
                            }
                        } 
                    ?>
                    <?php if (!empty($filtrirani_zadaci)): ?>
                        <?php foreach($filtrirani_zadaci as $z): ?>
                            <tr>
                                <td><?= $z->id ?></td>
                                <td><?= $z->naslov ?></td>
                                <td><?= $z->opis ?></td>
                                <td><?= $z->prioritet ?></td>
                                <td><?= $z->pocetak_zadatka ?></td>
                                <td><?= $z->kraj_zadatka ?></td>
                                <td>
                                    <?php foreach($prilozi as $p): ?>
                                        <?php if($z->id === $p->zadatak_id): ?> 
                                            <?= $p->naziv_priloga ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </td>
                                <td>
                                    <?php foreach($izvrsioci as $i): ?>
                                        <?php if($z->id === $i->zadatak_id): ?>
                                            <?= Korisnik::getById($i->korisnik_id,
                                                    'korisnici', 'Korisnik')->ime_prezime ?> 
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </td>
                                <!-- Prilog izmeni nije dobro -->
                                <td data-korisnik="<?= $z->getKorisnik()->id ?>">                             
                                    <?= $z->getKorisnik()->ime_prezime ?>
                                </td>
                                <td data-grupa-zadatka="<?= $z->getGrupaZadataka()->id ?>">
                                    <?= $z->getGrupaZadataka()->naziv ?>
                                </td>
                                <td><?= $z->zavrsen ?></td>
                                <td><?= $z->otkazan ?></td>
                                <td>
                                    <button id="otvori_<?= $z->id ?>" 
                                        onclick="location.href='./rukovodilac.php?strana=zadatak&id=<?= $z->id ?>'">
                                            Otvori
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach?>
                    <?php else: ?>
                        <tr><td><?= "Nema pronadjenih podataka" ?></td></tr>
                    <?php endif ?>
                <?php else: ?>
                <?php foreach($zadaci as $zadatak): ?> 
                    <tr>
                        <td><?= $zadatak->id ?></td>
                        <td><?= $zadatak->naslov ?></td>
                        <td><?= $zadatak->opis ?></td>
                        <td><?= $zadatak->prioritet ?></td>
                        <td><?= $zadatak->pocetak_zadatka ?></td>
                        <td><?= $zadatak->kraj_zadatka ?></td>
                        <td>
                            <?php foreach($prilozi as $p): ?>
                                <?php if($zadatak->id === $p->zadatak_id): ?> 
                                    <?= $p->naziv_priloga ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        </td>
                        <td>
                            <?php foreach($izvrsioci as $i): ?>
                                <?php if($zadatak->id === $i->zadatak_id): ?>
                                    <?= Korisnik::getById($i->korisnik_id, 'korisnici', 'Korisnik')->ime_prezime ?>  
                                <?php endif ?>
                            <?php endforeach ?>
                        </td>
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
                <?php endif ?>
            </tbody>
        </table>     
    </body>
</html>