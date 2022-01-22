<?php

require_once __DIR__ . '/../tabele/TipKorisnika.php';

session_start();
if (!isset($_SESSION['korisnik_admin_id'])) {
    header('Location: ../stranice/prijava.php');
    die();
}

$naziv = $_POST['naziv_tipa'];
$id = $_POST['naziv_id'];

TipKorisnika::izmeni($id, $naziv);

header('Location: ../stranice/admin.php?strana=tipoviKorisnika');