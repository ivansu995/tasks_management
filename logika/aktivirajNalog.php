<?php
require_once __DIR__ . '/../tabele/Korisnik.php';

// session_start();

// if (!isset($_SESSION['korisnik_id'])) {
//     header('Location: ../stranice/prijava.php');
//     die();
// }

$id = $_GET['aktivacija'];
$status_aktivacije = 'Da';

var_dump($id);

try {
    Korisnik::aktivirajNalog($id, $status_aktivacije);
    // echo '{"status":"uspesno"}';
} catch (Exception $ex) {
    echo '{"status":"'.$ex->getMessage().'"}';
}