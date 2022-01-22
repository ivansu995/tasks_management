<?php

require_once __DIR__ . '/../tabele/Korisnik.php';

session_start();
if (!isset($_SESSION['korisnik_admin_id'])) {
    header('Location: ../stranice/prijava.php');
    die();
}

$email = $_POST['email'];
$korisnicko_ime = $_POST['korisnicko_ime'];
$lozinka = $_POST['lozinka'];
$ime_prezime = $_POST['ime_prezime'];
$datum_rodjenja = $_POST['datum_rodjenja'];
$telefon = $_POST['telefon'];
$tip_korisnika_id = $_POST['tip_korisnika'];

$lozinka = hash('sha512', $lozinka);

Korisnik::registracija(
    $ime_prezime,
    $korisnicko_ime,
    $lozinka,
    $email,
    $telefon,
    $datum_rodjenja,
    $tip_korisnika_id,
    "",
    1
);

header('Location: ../stranice/admin.php?strana=korisnici');