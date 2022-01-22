<?php

require_once __DIR__ . '/../tabele/Izvrsava.php';
require_once __DIR__ . '/../tabele/Zadatak.php';

session_start();
if (!isset($_SESSION['korisnik_rukovodilac_id']) && !isset($_SESSION['korisnik_id'])) {
    header('Location: ../stranice/prijava.php');
    die();
}

$zadatak_id = $_POST['zadatak_id'];
$korisnik_id = $_POST['korisnik_id'];

Izvrsava::zavrsiZadatak($korisnik_id, $zadatak_id);

header("Location: ../stranice/index.php?strana=zadatak&id=$zadatak_id");
die();

