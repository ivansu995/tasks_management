<?php

require_once __DIR__ . '/../tabele/Zadatak.php';

session_start();
if (!isset($_SESSION['korisnik_rukovodilac_id'])) {
    header('Location: ../stranice/prijava.php');
    die();
}

$zadatak_id = $_POST['zadatak_id'];

Zadatak::zavrsiZadatak($zadatak_id);

header("Location: ../stranice/rukovodilac.php?strana=zadatak&id=$zadatak_id");
die();