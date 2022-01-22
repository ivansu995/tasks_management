<?php

require_once __DIR__ . '/../tabele/Korisnik.php';
require_once __DIR__ . '/../stranice/promenaLozinke.php';
require_once __DIR__ . '/../tabele/ResetovanjeLozinke.php';

if (isset($_POST['resetuj_lozinku'])) {

    $token = $_POST['token'];
    $nova_lozinka = $_POST['nova_lozinka'];
    $ponovi_novu_lozinku = $_POST['ponovi_novu_lozinku'];
    $nova_lozinka = hash('sha512', $nova_lozinka);
    $ponovi_novu_lozinku = hash('sha512', $ponovi_novu_lozinku);
    
    if ($nova_lozinka === $ponovi_novu_lozinku) {
        $vreme = date("U");
        $rezultat = ResetovanjeLozinke::proveriToken($token, $vreme);

        if (empty($rezultat)) {
            header('Location: ../stranice/promenaLozinke.php?istekao_token=1');
            die();
        } else {
            $email = $rezultat->email;
            $korisnik = Korisnik::proveriMail($email);
    
            if($korisnik !== null) {
                $korisnil_email = $korisnik->email;
                Korisnik::promeniLozinku($korisnil_email, $nova_lozinka);
                header('Location: ../stranice/promenaLozinke.php?uspesna_promena_lozinke=1');
                die();
            } else {
                header('Location: ../stranice/promenaLozinke?greska=podaci');
                die();
            }
        }
    }
}