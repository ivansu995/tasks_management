<?php

require_once __DIR__ . '/../tabele/TipKorisnika.php';

session_start();
if (!isset($_SESSION['korisnik_admin_id'])) {
    header('Location: ../stranice/prijava.php');
    die();
}

$naziv = $_POST['naziv_tipa'];
$tip = TipKorisnika::getByName($naziv);

if ($tip === null) {
    TipKorisnika::snimi($naziv);
}

header('Location: ../stranice/admin.php?strana=tipoviKorisnika');