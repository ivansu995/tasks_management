<?php
session_start();
if (!isset($_SESSION['korisnik_admin_id']) && !isset($_SESSION['korisnik_rukovodilac_id'])) {
    header('Location: prijava.php');
    die();
}

require_once __DIR__ . '/../tabele/GrupaZadataka.php';

try {
    GrupaZadataka::obrisi($_POST['id']);
    echo '{"status":"uspesno"}';
} catch (Exception $e) {
    echo '{"status":"'.$e->getMessage().'"}';
}