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
    public $zavrsen;
    public $otkazan;

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
    
    public static function pretraziZadatak($naslov, $prioritet, $rukovodilac_id, $pocetak_zadatka, $kraj_zadatka)
    {
        $db = Database::getInstance();

        return $db->select('Zadatak',
            'SELECT * FROM zadaci WHERE naslov LIKE :naslov OR prioritet = :prioritet OR rukovodilac_id = :rukovodilac_id
            OR pocetak_zadatka >= :pocetak_zadatka AND kraj_zadatka <= :kraj_zadatka', 
            [
                ':naslov' => $naslov,
                ':prioritet' => $prioritet,
                ':rukovodilac_id' => $rukovodilac_id,
                ':pocetak_zadatka' => $pocetak_zadatka,
                ':kraj_zadatka' => $kraj_zadatka,
            ]
        );

        // foreach($zadaci as $z){
        //     return $z;
        // }
        // return null;

    }

    public static function snimi($naslov, $opis, $prioritet, $pocetak_zadatka, $kraj_zadatka, 
                            $rukovodilac_id, $grupa_zadatka_id, $zavrsen, $otkazan)
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
                    grupa_zadatka_id,
                    zavrsen,
                    otkazan
                )
                VALUES (
                    :naslov,
                    :opis,
                    :prioritet,
                    :pocetak_zadatka,
                    :kraj_zadatka,
                    :rukovodilac_id,
                    :grupa_zadatka_id,
                    :zavrsen,
                    :otkazan
                )',
                [
                    ':naslov' => $naslov,
                    ':opis' => $opis,
                    ':prioritet' => $prioritet,
                    ':pocetak_zadatka' => $pocetak_zadatka,
                    ':kraj_zadatka' => $kraj_zadatka,
                    ':rukovodilac_id' => $rukovodilac_id,
                    ':grupa_zadatka_id' => $grupa_zadatka_id,
                    ':zavrsen' => $zavrsen,
                    ':otkazan' => $otkazan
                ]
            );
        } catch (Exception $e) {
            return $e->getMessage();
            // return false;
        }
        return $id = $db->lastInsertId();

        // $zadaci = $db->select('Zadatak',
        //     'SELECT * FROM zadaci WHERE id = :id',
        //     [
        //         ':id' => $id,
        //     ]
        // );
        // foreach($zadaci as $zadatak) {
        //     return $zadatak;
        // }
        // return null;
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

    public static function izmeni($id, $naslov, $opis, $prioritet, $pocetak_zadatka, 
                            $kraj_zadatka, $rukovodilac_id, $grupa_zadatka_id, $zavrsen, $otkazan)
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
                grupa_zadatka_id = :grupa_zadatka_id,
                zavrsen = :zavrsen,
                otkazan = :otkazan
            WHERE id = :id',
            [
                ':id' => $id,
                ':naslov' => $naslov,
                ':opis' => $opis,
                ':prioritet' => $prioritet,
                ':pocetak_zadatka' => $pocetak_zadatka,
                ':kraj_zadatka' => $kraj_zadatka,
                ':rukovodilac_id' => $rukovodilac_id,
                ':grupa_zadatka_id' => $grupa_zadatka_id,
                ':zavrsen' => $zavrsen,
                ':otkazan' => $otkazan
            ]
        );

    }
}