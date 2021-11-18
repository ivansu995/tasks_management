<?php
require_once __DIR__ . '/../tabele/Komentar.php';

session_start();
if (!isset($_SESSION['korisnik_admin_id'])) {
    header('Location: ../stranice/prijava.php');
    die();
}

$opis_komentara = $_POST['opis_komentara'];
$zadatak_id = $_POST['zadatak_id'];
$korisnik_id = $_POST['korisnik_id'];

Komentar::snimi($opis_komentara, $zadatak_id, $korisnik_id);

header('Location: ../stranice/admin.php?strana=komentari');