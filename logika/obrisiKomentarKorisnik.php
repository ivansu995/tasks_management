<?php

require_once __DIR__ . '/../tabele/Komentar.php';

session_start();
if (!isset($_SESSION['korisnik_rukovodilac_id']) &&
    !isset($_SESSION['korisnik_admin_id'])) {
    header('Location: prijava.php');
    die();
}

try {
    Komentar::obrisi($_POST['komentar_id']);
    echo '{"status":"uspesno"}';
} catch (Exception $e) {
    echo '{"status":"'.$e->getMessage().'"}';
}