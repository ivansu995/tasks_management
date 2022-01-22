<?php

require_once __DIR__ . '/../tabele/Korisnik.php';

$link = "http://localhost/tasks_management/stranice/prijava.php";

if (isset($_GET['key'])) {
    $link_za_aktivaciju = $_GET['key'];
    $podaci = Korisnik::pronadjiNalogZaAktivaciju($link_za_aktivaciju);
    if ($podaci > 0) {
        $aktivacija = Korisnik::aktivirajNalog($link_za_aktivaciju);
        echo "Vas nalog je aktiviran, mozete se prijaviti sada! <a href=$link>Prijavi se</a>";
    } else {
        echo "Greska prilikom aktivacije!";
    }
}
