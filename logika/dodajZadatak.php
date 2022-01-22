<?php

require_once __DIR__ . '/../tabele/Zadatak.php';
require_once __DIR__ . '/../tabele/Izvrsava.php';
require_once __DIR__ . '/../includes/Upload.php';

session_start();
if (!isset($_SESSION['korisnik_admin_id']) &&
    !isset($_SESSION['korisnik_rukovodilac_id'])) {
    header('Location: ../stranice/prijava.php');
    die();
}

//funkcija menja izgled niza koji se dobija kada uploadujemo sliku
//zbog lakseg pristupa 
function reArrayFiles(&$file_post) 
{
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }
    return $file_ary;
}

$niz_fajlova = reArrayFiles($_FILES['prilog']);

$naslov = $_POST['naslov'];
$opis = $_POST['opis'];
$prioritet = $_POST['prioritet'];
$pocetak_zadatka = $_POST['pocetak_zadatka'];
$kraj_zadatka = $_POST['kraj_zadatka'];
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

foreach ($_POST['izvrsioci'] as $izvrsilac){
    Izvrsava::dodaj($izvrsilac, $id);
}

if (!empty($_FILES['prilog'])) {
    foreach ($niz_fajlova as $fajl) {
        $upload = Upload::factory('../../prilog');
        $upload->file($fajl);
        $upload->set_allowed_mime_types(['text/csv',
                'image/png','application/msword', 'image/jpeg', 
                'application/pdf', 'text/plain', 'application/zip',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
        $upload->set_filename($fajl['name']);
        $upload->save();
        $fajl_lokacija = 'prilog/' . $fajl['name'];
        $naziv_fajla = $fajl['name'];
        Prilog::dodaj($fajl_lokacija, $naziv_fajla, $id);
    }
}

if (isset($_SESSION['korisnik_admin_id'])) {
    header('Location: ../stranice/admin.php?strana=zadaci');
    die();
} else if (isset($_SESSION['korisnik_rukovodilac_id'])) {
    header('Location: ../stranice/rukovodilac.php?strana=zadaci');
    die();
}