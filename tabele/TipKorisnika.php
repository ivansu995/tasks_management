<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/Tabela.php';

class TipKorisnika extends Tabela
{
    public $id;
    public $naziv_tipa;

    public static function getByName($naziv_tipa)
    {
        $db = Database::getInstance();

        $tipovi = $db->select('TipKorisnika', 
            'SELECT * FROM tipovi_korisnika WHERE naziv_tipa = :naziv_tipa',
            [
                ':naziv_tipa' => $naziv_tipa,
            ]);

        foreach($tipovi as $tip) {
            return $tip;
        }
        return null;
    }

    public static function getAll()
    {
        $db = Database::getInstance();

        return $db->select('TipKorisnika',
        'SELECT * FROM tipovi_korisnika');
    }

    public static function snimi($naziv)
    {
        $db = Database::getInstance();

        $id = $db->insert('TipKorisnika',
            'INSERT INTO tipovi_korisnika (naziv_tipa) VALUES (:naziv)',
            [
                ':naziv' => $naziv,
            ]
        );

        $tipovi = $db->select('TipKorisnika',
            'SELECT * FROM tipovi_korisnika WHERE id = :id',
            [
                ':id' => $id,
            ]
        );
        foreach($tipovi as $tip) {
            return $tip;
        }
        return null;
    }
    
    public static function obrisi($id)
    {
        $db=Database::getInstance();

        $db->delete('DELETE FROM tipovi_korisnika WHERE id=:id',
            [
                ':id' => $id,
            ]
        );
    }

    public static function izmeni($id, $naziv)
    {
        $db=Database::getInstance();

        $db->update('TipKorisnika',
            'UPDATE tipovi_korisnika
            SET naziv_tipa = :naziv
            WHERE id = :id',
            [
                ':id' => $id,
                ':naziv' => $naziv,
            ]
        );

    }
}