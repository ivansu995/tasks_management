<?php

require_once __DIR__ . '/../tabele/Korisnik.php';
require_once __DIR__ . '/../env.php';

require 'C:\xampp\htdocs\tasks_management\PHPMailer\src\Exception.php';
require 'C:\xampp\htdocs\tasks_management\PHPMailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\tasks_management\PHPMailer\src\SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if (empty($_POST['email'])) {
    header('Location: ../stranice/aktiviranNalog.php?greska_podaci=1');
    die();
}

$email = $_POST['email'];
$korisnik = Korisnik::proveriMail($email);

if ($korisnik === null) {
    header('Location: ../stranice/aktiviranNalog.php?greska_mail=1');
    die();
}

$token = $korisnik->link_za_aktivaciju;
$link = "http://localhost/tasks_management/logika/aktivirajNalog.php?key=$token";

if ($korisnik !== false) {
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
        <a href='$link'>
        Link
        </a> ili <br>
        $link";
        $mail->AltBody = "Aktivirajte nalog na sledecem linku $link";
        
        $mail->send();
        header('Location: ../stranice/aktiviranNalog.php?poslat_mail=1');
        die();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }   
} 