<?php
require_once __DIR__ . '/../tabele/Korisnik.php';

$link = "http://localhost/tasks_management/stranice/prijava.php";

if (isset($_GET['key'])) {
    $link_za_aktivaciju = $_GET['key'];
    $podaci = Korisnik::pronadjiNalogZaAktivaciju($link_za_aktivaciju);
    if ($podaci > 0) {
        $aktivacija = Korisnik::aktivirajNalog($link_za_aktivaciju);
        echo "Vas nalog je aktiviran, mozete se prijaviti sada! <a href=$link>Prijavi se</a>";
        // if ($aktivacija > 0) {
        //     header('Location: ../stranice/prijava.php');
        //     die();
        // } else {
        //     echo "Greska prilikom aktivacije!";
        // }
    } else {
        echo "Greska prilikom aktivacije!";
    }
}


// var_dump($id);

// try {
//     Korisnik::aktivirajNalog($id, $status_aktivacije);
//     // echo '{"status":"uspesno"}';
// } catch (Exception $ex) {
//     echo '{"status":"'.$ex->getMessage().'"}';
// }