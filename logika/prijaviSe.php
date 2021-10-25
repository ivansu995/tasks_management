<?php
require_once __DIR__ . '/../tabele/Korisnik.php';

if (!isset($_POST['email'])) {
    header('Location: ../stranice/prijava.php');
    die();
}
 
$email = $_POST['email'];
$lozinka = $_POST['lozinka'];

$lozinka = hash('sha512', $lozinka);

$korisnik = Korisnik::proveri($email, $lozinka);
// var_dump($korisnik);
// die();
if ($korisnik !== null && $korisnik->aktiviran === '1') {
    session_start();
    $_SESSION['korisnik_id'] = $korisnik->id;
    header('Location: ../stranice/stranica.php');
    die();
    // return json_encode($korisnik);
} else if ($korisnik !== null && $korisnik->aktiviran === '0') {
    echo "Vas nalog nije aktiviran. Molimo Vas aktivirajte nalog preko linka u email-u!";
} else {
    header('Location: ../stranice/prijava.php?greska=podaci');
    die();
    // return json_encode(['error' => 'Pogresni podaci za prijavu.']);

}