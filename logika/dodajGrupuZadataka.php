<?php
require_once __DIR__ . '/../tabele/GrupaZadataka.php';

session_start();
if (!isset($_SESSION['korisnik_admin_id'])) {
    header('Location: ../stranice/prijava.php');
    die();
}

$naziv = $_POST['naziv'];
$tip = GrupaZadataka::getByName($naziv);

if ($tip === null) {
    GrupaZadataka::snimi($naziv);
}

header('Location: ../stranice/admin.php?strana=grupeZadataka');