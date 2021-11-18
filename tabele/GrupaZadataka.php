<?php
require_once __DIR__ . '/Tabela.php';

class GrupaZadataka extends Tabela
{
    public $id;
    public $naziv;

    public static function getAll()
    {
        $db = Database::getInstance();
        
        return $db->select('GrupaZadataka',
        'SELECT * FROM grupe_zadataka');  
    }

    public static function snimi($naziv)
    {
        $db = Database::getInstance();

        $id = $db->insert('GrupaZadataka',
            'INSERT INTO grupe_zadataka (naziv) VALUES (:naziv)',
            [
                ':naziv' => $naziv,
            ]
        );

        $grupeZadataka = $db->select('GrupaZadataka',
            'SELECT * FROM grupe_zadataka WHERE id = :id',
            [
                ':id' => $id,
            ]
        );
        foreach($grupeZadataka as $grupa) {
            return $grupa;
        }
        return null;
    }
    
    public static function obrisi($id)
    {
        $db=Database::getInstance();

        $db->delete('DELETE FROM grupe_zadataka WHERE id=:id',
            [
                ':id' => $id,
            ]
        );
    }

    public static function izmeni($id, $naziv)
    {
        $db=Database::getInstance();

        $db->update('GrupaZadataka',
            'UPDATE grupe_zadataka
            SET naziv = :naziv
            WHERE id = :id',
            [
                ':id' => $id,
                ':naziv' => $naziv,
            ]
        );
    }

    public static function getByName($naziv)
    {
        $db = Database::getInstance();

        $grupeZadataka = $db->select('GrupaZadataka', 
            'SELECT * FROM grupe_zadataka WHERE naziv = :naziv',
            [
                ':naziv' => $naziv,
            ]);

        foreach($grupeZadataka as $grupa) {
            return $grupa;
        }
        return null;
    }
}