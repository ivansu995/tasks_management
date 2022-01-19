<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once __DIR__ . '/../tabele/Korisnik.php';
require_once __DIR__ . '/../tabele/TipKorisnika.php';

if (!isset($_POST['email'])) {
    header('Location: ../stranice/prijava.php');
    die();
}
 
$email = $_POST['email'];
$lozinka = $_POST['lozinka'];

$lozinka = hash('sha512', $lozinka);

$korisnik = Korisnik::proveri($email, $lozinka);
$admin = TipKorisnika::getByName('administrator');
$rukovodilac = TipKorisnika::getByName('rukovodilac');

if ($korisnik !== null && $korisnik->aktiviran === '1') {
    //ako je korisnik administrator 
    if ($korisnik->tip_korisnika_id === $admin->id && isset($_POST['admin_prijava'])) { 
        session_start();
        $_SESSION['korisnik_admin_id'] = $korisnik->id;
        header('Location: ../stranice/admin.php');
        die();
    } elseif ($korisnik->tip_korisnika_id === $rukovodilac->id && 
            isset($_POST['rukovodilac_prijava'])) { 
        //ako je rukovodilac
        session_start();
        $_SESSION['korisnik_rukovodilac_id'] = $korisnik->id;
        header('Location: ../stranice/rukovodilac.php');
        die();
    } else {
        //ako je obican korisnik
        session_start();
        $_SESSION['korisnik_id'] = $korisnik->id;
        header('Location: ../stranice/index.php');
        die();
        // echo json_encode($korisnik);
    }
} elseif ($korisnik !== null && $korisnik->aktiviran === '0') {
    echo "Vas nalog nije aktiviran. Molimo Vas aktivirajte nalog preko linka u email-u!";
} else {
    header('Location: ../stranice/prijava.php?greska=podaci');
    die();
    // return json_encode(['error' => 'Pogresni podaci za prijavu.']);

}