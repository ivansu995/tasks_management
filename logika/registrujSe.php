<?php
require_once __DIR__ . '/../tabele/Korisnik.php';
require_once __DIR__ . '/../env.php';
require 'C:\xampp\htdocs\tasks_management\PHPMailer\src\Exception.php';
require 'C:\xampp\htdocs\tasks_management\PHPMailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\tasks_management\PHPMailer\src\SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


if (empty($_POST['korisnicko_ime']) ||
    empty($_POST['email']) ||
    empty($_POST['ime_prezime']) ||
    empty($_POST['lozinka']) ||
    empty($_POST['ponovi_lozinku'])
    ) {
        header('Location: ../stranice/registracija.php?greska_podaci=1');
        die();
    }


$email = $_POST['email'];
$korisnicko_ime = $_POST['korisnicko_ime'];
$lozinka = $_POST['lozinka'];
$ponovi_lozinku = $_POST['ponovi_lozinku'];
$ime_prezime = $_POST['ime_prezime'];
$datum_rodjenja = $_POST['datum_rodjenja'];
$telefon = $_POST['telefon'];

$lozinka = hash('sha512', $lozinka);
$ponovi_lozinku = hash('sha512', $ponovi_lozinku);

$link_za_aktivaciju = md5($email . $korisnicko_ime);

if ($lozinka !== $ponovi_lozinku) {
    header('Location: ../stranice/registracija.php?greska_lozinka=1');
    die();
}

$korisnik_id = Korisnik::registracija(
    $ime_prezime,
    $korisnicko_ime,
    $lozinka,
    $email,
    $telefon,
    $datum_rodjenja,
    3,
    $link_za_aktivaciju,
    0
);

$link = "http://localhost/tasks_management/logika/aktivirajNalog.php?key=$link_za_aktivaciju";

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.mailtrap.io';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $user;                     //SMTP username
    $mail->Password   = $pass;                               //SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
 

    //Recipients
    $mail->setFrom('noreply@test.com', 'Administrator', 0);
    $mail->addAddress($email);  

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Aktivacija naloga';
    $mail->Body = "Postovani,
        $ime_prezime aktivirajte nalog klikom na link: 
        <a href=$link>
            Link
        </a> ili <br>
        $link" 
        ;
    $mail->AltBody = "Aktivirajte nalog na sledecem linku $link";

    $mail->send();

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


if ($korisnik_id !== false) {
    header('Location: ../stranice/registracija.php?uspesna_registracija=1');
    die();
} else {
    header('Location: ../stranice/registracija.php?greska_mail=1');
    die();
}
