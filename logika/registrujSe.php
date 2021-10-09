<?php
require_once __DIR__ . '/../tabele/Korisnik.php';
require 'C:\xampp\htdocs\ppp2_zadatak1\PHPMailer\src\Exception.php';
require 'C:\xampp\htdocs\ppp2_zadatak1\PHPMailer\src\PHPMailer.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$email = $_POST['email'];
$korisnicko_ime = $_POST['korisnicko_ime'];
$lozinka = $_POST['lozinka'];
$ponovi_lozinku = $_POST['ponovi_lozinku'];
$ime_prezime = $_POST['ime_prezime'];
$datum_rodjenja = $_POST['datum_rodjenja'];
$telefon = $_POST['telefon'];

$lozinka = hash('sha512', $lozinka);

$korisnik_id = Korisnik::registracija($ime_prezime, $korisnicko_ime, $lozinka, $email, $telefon, $datum_rodjenja);

if ($korisnik_id !== false) {
    header('Location: ../stranice/registracija.php?uspesna_registracija=1');
} else {
    header('Location: ../starnice/registracija.php?greska_mail=1');
}

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Recipients
    $mail->setFrom('no-replay@test.com', 'Administrator', 0);
    $mail->addAddress($email);  

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Aktivacija naloga';
    $mail->Body = "Postovani,
        $ime_prezime aktivirajte nalog klikom na sledeci link: 
        <a href='http://localhost/ppp2_zadatak1/stranice/aktiviranNalog.php?aktivacija=$korisnik_id'>Link</a>";
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}