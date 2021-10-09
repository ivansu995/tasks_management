<?php

$email = $_POST['email'];
$stara_lozinka = $_POST['stara_lozinka'];
$nova_lozinka = $_POST['nova_lozinka'];
$ponovi_novu_lozinku = $_POST['ponovi_novu_lozinku'];

$stara_lozinka = hash('sha512', $stara_lozinka);
$nova_lozinka = hash('sha512', $nova_lozinka);

require_once __DIR__ . '/../tabele/Korisnik.php';
$korisnik = Korisnik::proveri($email, $stara_lozinka);

if($korisnik !== null)
{
    Korisnik::promeni_lozinku($email, $nova_lozinka);
    header('Location: ../stranice/prijava.php');
}
else
{
    header('Location: ../stranice/promenaLozinke?greska=podaci');
}
