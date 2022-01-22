<?php

require_once __DIR__ . '/Tabela.php';
require_once __DIR__ . '/Zadatak.php';
require_once __DIR__ . '/Korisnik.php';

class Izvrsava extends Tabela
{
    public $id;
    public $korisnik_id;
    public $zadatak_id;
    public $izvrsio;

    public function getZadatak()
    {
        return Zadatak::getById($this->zadatak_id, 'zadaci', 'Zadatak');
    }

    public function getKorisnik()
    {
        return Korisnik::getById($this->korisnik_id, 'korisnici', 'Korisnik');
    }

    public static function getAll()
    {
        $db = Database::getInstance();

        return $db->select('Izvrsava',
        'SELECT * FROM izvrsava');
    }

    public static function getZadatakByKorisnikId($korisnik_id)
    {
        $db=Database::getInstance();

        $izvrsava = $db->select('Izvrsava', 
            'SELECT * FROM izvrsava
            WHERE korisnik_id = :korisnik_id',
            [
                ':korisnik_id'=>$korisnik_id
            ]
        );
        
        return $izvrsava;
    }

    public static function getKorisnikByZadatakId($zadatak_id)
    {
        $db=Database::getInstance();

        $izvrsava = $db->select('Izvrsava', 
            'SELECT * FROM izvrsava
            WHERE zadatak_id = :zadatak_id',
            [
                ':zadatak_id'=>$zadatak_id
            ]
        );
        
        return $izvrsava;
    }

    public static function dodaj($korisnik_id, $zadatak_id)
    {
        $db = Database::getInstance();

        $db->insert('Izvrsava',
            'INSERT INTO izvrsava (korisnik_id, zadatak_id) VALUES (:korisnik_id, :zadatak_id)',
            [
                ':korisnik_id' => $korisnik_id,
                ':zadatak_id' => $zadatak_id
            ]
        );
    }

    public static function ukupnoIzvrsiocaPoZadatku($zadatak_id)
    {
        $db = Database::getInstance();

        return $db->select('Izvrsava',
                'SELECT * FROM izvrsava WHERE zadatak_id = :zadatak_id',
            [
                ':zadatak_id' => $zadatak_id
            ]
        );
    }

    public static function korisniciKojiNisuZavrsiliZadatak($zadatak_id, $izvrsio)
    {
        $db = Database::getInstance();

        return $db->select('Izvrsava',
            'SELECT * FROM izvrsava 
            WHERE zadatak_id = :zadatak_id AND izvrsio = :izvrsio',
            [
                ':zadatak_id' => $zadatak_id,
                ':izvrsio' => $izvrsio
            ]
        );
    }

    public static function zavrsiZadatak($korisnik_id, $zadatak_id)
    {
        $db = Database::getInstance();

        $db->update('Izvrsava',
            'UPDATE izvrsava
            SET izvrsio = 1
            WHERE korisnik_id = :korisnik_id AND zadatak_id = :zadatak_id',
            [
                ':korisnik_id' => $korisnik_id,
                ':zadatak_id' => $zadatak_id,
            ]
        );
    }

    public static function proveriDaLiJeIzvrsen($korisnik_id, $zadatak_id)
    {
        $db = Database::getInstance();

        $izvrsava = $db->select('Izvrsava',
            'SELECT * FROM izvrsava 
            WHERE zadatak_id = :zadatak_id AND korisnik_id = :korisnik_id',
            [
                ':zadatak_id' => $zadatak_id,
                ':korisnik_id' => $korisnik_id
            ]
        );
        foreach ($izvrsava as $i) {
            return $i;
        }
        return null;
    }
}