<?php
require_once __DIR__ . '/../tabele/Zadatak.php';
require_once __DIR__ . '/../tabele/Korisnik.php';
require_once __DIR__ . '/../tabele/Izvrsava.php';
require_once __DIR__ . '/../tabele/Prilog.php';

session_start();
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
        <title>Pocetna stranica</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../js/jquery-3.6.0.min.js"></script>
        <script src="../js/jquery-easypiechart.js"></script>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body>
        <a href="../logika/odjaviSe.php">Odjavi se</a>
        <hr>
        <nav>
            <ul>
                <li>
                    <a href="index.php?strana=zadaci">Zadaci</a>
                </li>
            </ul>
        </nav>
        <hr>
        <?php if (isset($_GET['strana'])): ?> 
            <?php if ($_GET['strana'] === 'zadaci'): ?> 
                <?php require_once __DIR__ . '/stranica.php'; ?>        
            <?php elseif ($_GET['strana'] === 'zadatak' && isset($_GET['id'])): ?>
                <?php require_once __DIR__ . '/zadatak.php'; ?> 
            <?php endif ?>     
        <?php endif ?>
    </body>
</html>