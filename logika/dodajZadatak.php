<?php
require_once __DIR__ . '/../tabele/Zadatak.php';

session_start();
if (!isset($_SESSION['korisnik_admin_id'])) {
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


$test = Zadatak::snimi(
    $naslov,
    $opis,
    $prioritet,
    $pocetak_zadatka,
    $kraj_zadatka,
    $tip_korisnika_id,
    $grupa_zadatka_id,
);

header('Location: ../stranice/admin.php?strana=zadaci');