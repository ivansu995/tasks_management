<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/Tabela.php';
require_once __DIR__ . '/TipKorisnika.php';

class Korisnik extends Tabela
{
    public $id;
    public $ime_prezime;
    public $korisnicko_ime;
    public $lozinka;
    public $telefon;
    public $email;
    public $datum_rodjenja;
    public $tip_korisnika_id;
    public $link_za_aktivaciju;
    public $aktiviran;

    public function getTipKorisnika()
    {
        return TipKorisnika::getById($this->tip_korisnika_id, 'tipovi_korisnika', 'TipKorisnika');
    }

    public static function registracija(
        $ime_prezime,
        $korisnicko_ime,
        $lozinka,
        $email,
        $telefon,
        $datum_rodjenja,
        $tip_korisnika_id,
        $link_za_aktivaciju,
        $aktiviran
    ) {
        $db = Database::getInstance();

        try
        {
            $db->insert('Korisnik',
                'INSERT INTO korisnici (
                    ime_prezime,
                    korisnicko_ime,
                    lozinka,
                    email,
                    telefon,
                    datum_rodjenja,
                    tip_korisnika_id,
                    link_za_aktivaciju,
                    aktiviran
                ) 
                VALUES (
                    :ime_prezime,
                    :korisnicko_ime,
                    :lozinka,
                    :email,
                    :telefon,
                    :datum_rodjenja,
                    :tip_korisnika_id,
                    :link_za_aktivaciju,
                    :aktiviran
                )',
                [
                    ':ime_prezime' => $ime_prezime,
                    ':korisnicko_ime' => $korisnicko_ime,
                    ':lozinka' => $lozinka,
                    ':telefon' => $telefon,
                    ':email' => $email,
                    ':datum_rodjenja' => $datum_rodjenja,
                    ':tip_korisnika_id' => $tip_korisnika_id,
                    ':link_za_aktivaciju' => $link_za_aktivaciju,
                    ':aktiviran' => $aktiviran
                ]
            );
        }
        catch(Exception $e)
        {
            return false;
        }
        return $id = $db->lastInsertId();
    }

    public static function getByTip($tip_korisnika_id)
    {
        $db=Database::getInstance();

        $korisnici = $db->select('Korisnik', 
            'SELECT * FROM korisnici WHERE tip_korisnika_id = :tip_korisnika_id',
            [
                ':tip_korisnika_id' => $tip_korisnika_id,
            ]
        );
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
            'SELECT * FROM korisnici 
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

    public static function getKorisnikByToken($link_za_aktivaciju)
    {
        $db=Database::getInstance();

        $korisnici = $db->select('Korisnik', 
            'SELECT * FROM korisnici 
            WHERE link_za_aktivaciju LIKE :link_za_aktivaciju',
            [
                ':link_za_aktivaciju'=>$link_za_aktivaciju,
            ]
        );

        foreach($korisnici as $korisnik){
            return $korisnik;
        }
        return null;
    }

    public static function resetujLozinku($link_za_aktivaciju, $nova_lozinka)
    {
        $db=Database::getInstance();

        $db->update('Korisnik',
            'UPDATE korisnici
            SET lozinka = :nova_lozinka
            WHERE link_za_aktivaciju = :link_za_aktivaciju',
            [
                ':link_za_aktivaciju'=>$link_za_aktivaciju,
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

    public static function pronadjiNalogZaAktivaciju($link_za_aktivaciju) 
    {
        $db=Database::getInstance();

        $korisnik = $db->select(
            'Korisnik',
            'SELECT link_za_aktivaciju, aktiviran 
            FROM korisnici 
            WHERE aktiviran = 0 AND link_za_aktivaciju=:link_za_aktivaciju LIMIT 1',
            [
                'link_za_aktivaciju' => $link_za_aktivaciju,
            ]
        );
        return $korisnik;
    }

    public static function aktivirajNalog($link_za_aktivaciju)
    {
        $db=Database::getInstance();

        $aktivacija = $db->update('Korisnik',
            'UPDATE korisnici
            SET aktiviran = 1
            WHERE link_za_aktivaciju=:link_za_aktivaciju LIMIT 1',
            [
                ':link_za_aktivaciju' => $link_za_aktivaciju,
            ]
        );
        return $aktivacija;
    }

    public static function getAll()
    {
        $db = Database::getInstance();

        return $db->select('Korisnik',
        'SELECT * FROM korisnici');
    }

    public static function obrisi($id)
    {
        $db = Database::getInstance();
        $db->delete('DELETE FROM korisnici WHERE id=:id', 
        [
            ':id' => $id,
        ]);
    }

    public static function izmeni($id, $email, $korisnicko_ime, $lozinka, $ime_prezime, $datum_rodjenja, $telefon, $tip_korisnika_id)
    {
        $db=Database::getInstance();

        $db->update('Korisnik',
            'UPDATE korisnici
            SET email = :email,
                korisnicko_ime = :korisnicko_ime,
                lozinka = :lozinka,
                ime_prezime = :ime_prezime,
                datum_rodjenja = :datum_rodjenja,
                telefon = :telefon,
                tip_korisnika_id = :tip_korisnika_id
            WHERE id = :id',
            [
                ':id' => $id,
                ':email' => $email,
                ':korisnicko_ime' => $korisnicko_ime,
                ':lozinka' => $lozinka,
                ':ime_prezime' => $ime_prezime,
                ':datum_rodjenja' => $datum_rodjenja,
                ':telefon' => $telefon,
                ':tip_korisnika_id' => $tip_korisnika_id,
            ]
        );

        // return self::getById($id, 'korisnici', 'Korisnik');
    }

    public static function izmeniBezLozinke($id, $email, $korisnicko_ime, $ime_prezime, $datum_rodjenja, $telefon, $tip_korisnika_id)
    {
        $db=Database::getInstance();

        $db->update('Korisnik',
            'UPDATE korisnici
            SET email = :email,
                korisnicko_ime = :korisnicko_ime,
                ime_prezime = :ime_prezime,
                datum_rodjenja = :datum_rodjenja,
                telefon = :telefon,
                tip_korisnika_id = :tip_korisnika_id
            WHERE id = :id',
            [
                ':id' => $id,
                ':email' => $email,
                ':korisnicko_ime' => $korisnicko_ime,
                ':ime_prezime' => $ime_prezime,
                ':datum_rodjenja' => $datum_rodjenja,
                ':telefon' => $telefon,
                ':tip_korisnika_id' => $tip_korisnika_id,
            ]
        );

        // return self::getById($id, 'korisnici', 'Korisnik');
    }
}