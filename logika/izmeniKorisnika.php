<?php
require_once __DIR__ . '/../tabele/Korisnik.php';

session_start();
if (!isset($_SESSION['korisnik_admin_id'])) {
    header('Location: ../stranice/prijava.php');
    die();
}

$id = $_POST['korisnik_id'];
$email = $_POST['email'];
$korisnicko_ime = $_POST['korisnicko_ime'];
$lozinka = $_POST['lozinka'];
$ime_prezime = $_POST['ime_prezime'];
$datum_rodjenja = $_POST['datum_rodjenja'];
$telefon = $_POST['telefon'];
$tip_korisnika_id = $_POST['tip_korisnika'];

if (!empty($lozinka)) {
    $lozinka = hash('sha512', $lozinka);
    Korisnik::izmeni($id, $email, $korisnicko_ime, $lozinka, $ime_prezime, $datum_rodjenja, $telefon, $tip_korisnika_id);
} else {
    Korisnik::izmeniBezLozinke($id, $email, $korisnicko_ime, $ime_prezime, $datum_rodjenja, $telefon, $tip_korisnika_id);
}

header('Location: ../stranice/admin.php?strana=korisnici');