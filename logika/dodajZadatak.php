<?php
require_once __DIR__ . '/../tabele/Zadatak.php';
require_once __DIR__ . '/../tabele/Izvrsava.php';

session_start();
if (!isset($_SESSION['korisnik_admin_id']) && !isset($_SESSION['korisnik_rukovodilac_id'])) {
    header('Location: ../stranice/prijava.php');
    die();
}

$naslov = $_POST['naslov'];
$opis = $_POST['opis'];
$prioritet = $_POST['prioritet'];
$pocetak_zadatka = $_POST['pocetak_zadatka'];
$kraj_zadatka = $_POST['kraj_zadatka'];
$fajl = $_POST['prilog'];
$tip_korisnika_id = $_POST['tip_korisnika'];
$grupa_zadatka_id = $_POST['grupe_zadataka'];
$zavrsen = $_POST['zavrsen'];
$otkazan = $_POST['otkazan'];


$id = Zadatak::snimi(
    $naslov,
    $opis,
    $prioritet,
    $pocetak_zadatka,
    $kraj_zadatka,
    $tip_korisnika_id,
    $grupa_zadatka_id,
    $zavrsen,
    $otkazan
);

foreach($_POST['izvrsioci'] as $izvrsilac){
    Izvrsava::dodaj($izvrsilac, $id);
}

if (isset($_SESSION['korisnik_admin_id'])) {

    header('Location: ../stranice/admin.php?strana=zadaci');
    die();

} else if (isset($_SESSION['korisnik_rukovodilac_id'])) {
    
    header('Location: ../stranice/rukovodilac.php?strana=zadaci');
    die();
}