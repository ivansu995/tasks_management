<?php
require_once __DIR__ . '/Tabela.php';
require_once __DIR__ . '/Korisnik.php';
require_once __DIR__ . '/GrupaZadataka.php';
require_once __DIR__ . '/Prilog.php';

class Zadatak extends Tabela
{
    public $id;
    public $naslov;
    public $opis;
    public $prioritet;
    public $pocetak_zadatka;
    public $kraj_zadatka;
    public $rukovodilac_id;
    public $grupa_zadatka_id;

    public function dateTimeFormat()
    {
        //dodaj formatirani datum i vreme
    }

    public function getKorisnik()
    {
        return Korisnik::getById($this->rukovodilac_id, 'korisnici', 'Korisnik');
    }

    public function getGrupaZadataka()
    {
        return GrupaZadataka::getById($this->grupa_zadatka_id, 'grupe_zadataka', 'GrupaZadataka');
    }
    

    // public static function getByName($naziv_tipa)
    // {
    //     $db = Database::getInstance();

    //     $tipovi = $db->select('Zadatak', 
    //         'SELECT * FROM zadaci WHERE naziv_tipa = :naziv_tipa',
    //         [
    //             ':naziv_tipa' => $naziv_tipa,
    //         ]);

    //     foreach($tipovi as $tip) {
    //         return $tip;
    //     }
    //     return null;
    // }

    public static function getAll()
    {
        $db = Database::getInstance();

        return $db->select('Zadatak',
        'SELECT * FROM zadaci');
    }

    public static function snimi($naslov, $opis, $prioritet, $pocetak_zadatka, $kraj_zadatka, $rukovodilac_id, $grupa_zadatka_id)
    {
        $db = Database::getInstance();
        try {
            $id = $db->insert('Zadatak',
                'INSERT INTO zadaci (
                    naslov,
                    opis,
                    prioritet,
                    pocetak_zadatka,
                    kraj_zadatka,
                    rukovodilac_id,
                    grupa_zadatka_id
                )
                VALUES (
                    :naslov,
                    :opis,
                    :prioritet,
                    :pocetak_zadatka,
                    :kraj_zadatka,
                    :rukovodilac_id,
                    :grupa_zadatka_id
                )',
                [
                    ':naslov' => $naslov,
                    ':opis' => $opis,
                    ':prioritet' => $prioritet,
                    ':pocetak_zadatka' => $pocetak_zadatka,
                    ':kraj_zadatka' => $kraj_zadatka,
                    ':rukovodilac_id' => $rukovodilac_id,
                    ':grupa_zadatka_id' => $grupa_zadatka_id
                ]
            );
        } catch (Exception $e) {
            return $e->getMessage();
            // return false;
        }
        return $id = $db->lastInsertId();

        $zadaci = $db->select('Zadatak',
            'SELECT * FROM zadaci WHERE id = :id',
            [
                ':id' => $id,
            ]
        );
        foreach($zadaci as $zadatak) {
            return $zadatak;
        }
        return null;
    }
    
    public static function obrisi($id)
    {
        $db=Database::getInstance();

        $db->delete('DELETE FROM zadaci WHERE id=:id',
            [
                ':id' => $id,
            ]
        );
    }

    public static function izmeni($id, $naslov, $opis, $prioritet, $pocetak_zadatka, $kraj_zadatka, $rukovodilac_id, $grupa_zadatka_id)
    {
        $db=Database::getInstance();

        $db->update('Zadatak',
            'UPDATE zadaci
            SET naslov = :naslov,
                opis = :opis,
                prioritet = :prioritet,
                pocetak_zadatka = :pocetak_zadatka,
                kraj_zadatka = :kraj_zadatka,
                rukovodilac_id = :rukovodilac_id,
                grupa_zadatka_id = :grupa_zadatka_id
            WHERE id = :id',
            [
                ':id' => $id,
                ':naslov' => $naslov,
                ':opis' => $opis,
                ':prioritet' => $prioritet,
                ':pocetak_zadatka' => $pocetak_zadatka,
                ':kraj_zadatka' => $kraj_zadatka,
                ':rukovodilac_id' => $rukovodilac_id,
                ':grupa_zadatka_id' => $grupa_zadatka_id
            ]
        );

    }
}