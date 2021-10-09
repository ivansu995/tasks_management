<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/Tabela.php';

class Korisnik
{
    public $id;
    public $ime_prezime;
    public $korisnicko_ime;
    public $lozinka;
    public $telefon;
    public $email;
    public $datum_rodjenja;
    public $da_li_je_aktivan;

    public static function registracija($ime_prezime, $korisnicko_ime, $lozinka, $email, $telefon, $datum_rodjenja)
    {
        $db = Database::getInstance();

        try
        {   
            $db->insert('Korisnik', 
                'INSERT INTO korisnici (ime_prezime, korisnicko_ime, lozinka, email, telefon, datum_rodjenja) 
                VALUES (:ime_prezime, :korisnicko_ime, :lozinka, :email, :telefon, :datum_rodjenja)',
                [
                    ':ime_prezime' => $ime_prezime,
                    ':korisnicko_ime' => $korisnicko_ime,
                    ':lozinka' => $lozinka,
                    ':telefon' => $telefon,
                    ':email' => $email,
                    ':datum_rodjenja' => $datum_rodjenja,
                ]
            );
        }
        catch(Exception $e)
        {
            return false;
        }
        return $id = $db->lastInsertId();
    }

    public static function getKorisnik()
    {
        $db=Database::getInstance();

        $korisnici = $db->select('Korisnik', 
            'SELECT * FROM korisnici');

        return $korisnici;
    }

    public static function proveri($email, $lozinka)
    {
        //$lozinka=hash('sha512', $lozinka);
        $db=Database::getInstance();

        $korisnici = $db->select('Korisnik', 
            'SELECT * FROM korisnici 
            WHERE email = :email AND lozinka = :lozinka',
            [
                ':email'=>$email,
                ':lozinka'=>$lozinka
            ]
        );

        foreach($korisnici as $korisnik){
            return $korisnik;
        }
        return null;
    }

    public static function proveriMail($email)
    {
        $db=Database::getInstance();

        $korisnici = $db->select('Korisnik', 
            'SELECT email FROM korisnici 
            WHERE email LIKE :email',
            [
                ':email'=>$email,
            ]
        );

        foreach($korisnici as $korisnik){
            return $korisnik;
        }
        return null;
    }

    public static function promeniLozinku($email, $nova_lozinka)
    {
        $db=Database::getInstance();

        $db->update('Korisnik',
            'UPDATE korisnici
            SET lozinka = :nova_lozinka
            WHERE email = :email',
            [
                ':email'=>$email,
                ':nova_lozinka'=>$nova_lozinka,
            ]
        );
    }

    public static function getKorisnikById($id)
    {
        $db=Database::getInstance();

        $korisnici = $db->select('Korisnik', 
            'SELECT * FROM korisnici
            WHERE id = :id',
            [
                ':id'=>$id
            ]
        );
        foreach($korisnici as $korisnik){
            return $korisnik;
        }
        return null;
    }

    public static function aktivirajNalog($id, $status_aktivacije) 
    {
        $db=Database::getInstance();

        $db->update('Korisnik',
            'UPDATE korisnici SET da_li_je_aktivan=:aktivan WHERE id=:id',
            [
                ':id' => $id,
                'aktivan' => $status_aktivacije,
            ]
        );
    }
}