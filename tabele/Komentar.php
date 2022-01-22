<?php

require_once __DIR__ . '/Tabela.php';
require_once __DIR__ . '/Korisnik.php';
require_once __DIR__ . '/Zadatak.php';

class Komentar extends Tabela
{
    public $id;
    public $opis_komentara;
    public $zadatak_id;
    public $korisnik_id;
    public $kreiran;

    public function getKorisnik()
    {
        return Korisnik::getById($this->korisnik_id, 'korisnici', 'Korisnik');
        //ako ima greska dodaj $korsnik_id umestno korisnik_id
    }

    public function getZadatak()
    {
        return Zadatak::getById($this->zadatak_id, 'zadaci', 'Zadatak');
    }

    public static function getAll()
    {
        $db = Database::getInstance();
        
        return $db->select('Komentar',
        'SELECT * FROM komentari');  
    }

    public static function getKomentarByZadatakId($zadatak_id)
    {
        $db = Database::getInstance();
        
        return $db->select('Komentar',
        'SELECT * FROM komentari 
        WHERE zadatak_id = :zadatak_id ORDER BY kreiran DESC',
        [
            ':zadatak_id' => $zadatak_id,
        ]); 
    }

    public static function snimi($opis_komentara, $zadatak_id, $korisnik_id)
    {
        $db = Database::getInstance();

        $id = $db->insert('Komentar',
            'INSERT INTO komentari (opis_komentara, zadatak_id, korisnik_id)
            VALUES (:opis_komentara, :zadatak_id, :korisnik_id)',
            [
                ':opis_komentara' => $opis_komentara,
                ':zadatak_id' => $zadatak_id,
                ':korisnik_id' => $korisnik_id
            ]
        );

        $komentari = $db->select('Komentar',
            'SELECT * FROM komentari WHERE id = :id',
            [
                ':id' => $id,
            ]
        );
        foreach ($komentari as $komentar) {
            return $komentar;
        }
        return null;
    }
    
    public static function obrisi($id)
    {
        $db=Database::getInstance();

        $db->delete('DELETE FROM komentari WHERE id=:id',
            [
                ':id' => $id,
            ]
        );
    }

    public static function izmeni($id, $opis_komentara)
    {
        $db=Database::getInstance();

        $db->update('Komentar',
            'UPDATE komentari
            SET opis_komentara = :opis_komentara
            WHERE id = :id',
            [
                ':id' => $id,
                ':opis_komentara' => $opis_komentara,
            ]
        );
    }

    public static function snimiKomentar($opis_komentara, $zadatak_id, $korisnik_id)
    {
        $db = Database::getInstance();

        $db->insert('Komentar',
            'INSERT INTO komentari (opis_komentara, zadatak_id, korisnik_id) 
            VALUES (:opis_komentara, :zadatak_id, :korisnik_id)',
            [
                ':opis_komentara' => $opis_komentara,
                ':zadatak_id' => $zadatak_id,
                ':korisnik_id' => $korisnik_id
            ]
        );
        return $id = $db->lastInsertId();
    }

    public static function getKomentarById($id) {
        $db = Database::getInstance();
        
        $komentari = $db->select('Komentar',
            'SELECT * FROM komentari WHERE id = :id',
            [
                ':id' => $id,
            ]
        );
        foreach ($komentari as $komentar) {
            return $komentar;
        }
        return null;
    }
}