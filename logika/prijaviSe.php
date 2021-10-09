<?php
if(!isset($_POST['email'])){
    header('Location: ../stranice/prijava.php');
    die();
}

 
$email = $_POST['email'];
$lozinka = $_POST['lozinka'];

$lozinka = hash('sha512', $lozinka);

require_once __DIR__ . '/../tabele/Korisnik.php';
$korisnik = Korisnik::proveri($email, $lozinka);

if($korisnik !== null){
    session_start();
    $_SESSION['korisnik_id'] = $korisnik->id;
    header('Location: ../stranice/stranica.php');
} else {
    header('Location: ../stranice/prijava.php?greska=podaci');
}