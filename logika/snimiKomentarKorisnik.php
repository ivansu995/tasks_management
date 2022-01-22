<?php
require_once __DIR__ . '/../tabele/Komentar.php';

session_start();
if (!isset($_SESSION['korisnik_rukovodilac_id']) && 
    !isset($_SESSION['korisnik_id']) &&
    !isset($_SESSION['korisnik_admin_id'])) {
    header('Location: ../stranice/prijava.php');
    die();
}

$opis_komentara = $_POST['opis_komentara'];
$zadatak_id = $_POST['zadatak_id'];
$korisnik_id = $_POST['korisnik_id'];

$id = Komentar::snimiKomentar($opis_komentara, $zadatak_id, $korisnik_id);
if ($id > 0) {
    $komentar = Komentar::getKomentarById($id);
    $komentar->korisnik = $komentar->getKorisnik();
    $komentar->kreiran = date('d.m.Y. H:i', strtotime($komentar->kreiran));
    echo json_encode($komentar);
} else {
    echo "Doslo je do greske!";
}