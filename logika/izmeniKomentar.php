<?php
require_once __DIR__ . '/../tabele/Komentar.php';

session_start();
if (!isset($_SESSION['korisnik_admin_id'])) {
    header('Location: ../stranice/prijava.php');
    die();
}

$opis_komentara = $_POST['opis_komentara'];
$id = $_POST['komentar_id'];

Komentar::izmeni($id, $opis_komentara);

header('Location: ../stranice/admin.php?strana=komentari');