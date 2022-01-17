<?php
require_once __DIR__ . '/../tabele/GrupaZadataka.php';

session_start();
if (!isset($_SESSION['korisnik_admin_id']) && !isset($_SESSION['korisnik_rukovodilac_id'])) {
    header('Location: ../stranice/prijava.php');
    die();
} 

$naziv = $_POST['naziv'];
$id = $_POST['naziv_id'];

GrupaZadataka::izmeni($id, $naziv);

if (isset($_SESSION['korisnik_admin_id'])) {

    header('Location: ../stranice/admin.php?strana=grupeZadataka');

} else if (isset($_SESSION['korisnik_rukovodilac_id'])) {
    
    header('Location: ../stranice/rukovodilac.php?strana=grupeZadataka');
}
