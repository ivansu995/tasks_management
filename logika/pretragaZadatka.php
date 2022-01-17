<?php
// session_start();
// if (!isset($_SESSION['korisnik_admin_id']) && !isset($_SESSION['korisnik_rukovodilac_id'])) {
//     header('Location: prijava.php');
//     die();
// }

// require_once __DIR__ . '/../tabele/Zadatak.php';
// require_once __DIR__ . '/../tabele/Korisnik.php';

// $naziv = $_POST['naziv_pretraga'];
// $rukovodilac = $_POST['rukovodilac_pretraga'];
// $prioritet = $_POST['prioritet_pretraga'];
// $pocetak_zadatka = $_POST['pocetak_zadatka_pretraga'];
// $kraj_zadatka = $_POST['kraj_zadatka_pretraga'];



// if (!empty($rukovodilac)) {
//     $rukovodilac = Korisnik::getKorisnikByName($rukovodilac)->id;
// }

// try{
//     $filtrirani_zadaci = Zadatak::pretraziZadatak($naziv, $prioritet, $rukovodilac, $pocetak_zadatka, $kraj_zadatka);
//     // echo $filtrirani_zadaci;
//     echo json_encode($filtrirani_zadaci);
    
// }
// catch(Exception $ex){
//     echo '{"status":"'.$ex->getMessage().'"}';
// }
