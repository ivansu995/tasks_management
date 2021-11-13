<?php
session_start();
if (!isset($_SESSION['korisnik_admin_id'])) {
    header('Location: prijava.php');
    die();
}

require_once __DIR__ . '/../tabele/TipKorisnika.php';

try {
    TipKorisnika::obrisi($_POST['id']);
    echo '{"status":"uspesno"}';
} catch (Exception $e) {
    echo '{"status":"'.$e->getMessage().'"}';
}