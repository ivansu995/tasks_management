<?php

require_once __DIR__ . '/Tabela.php';
require_once __DIR__ . '/Zadatak.php';

class Prilog extends Tabela
{
    public $id;
    public $naziv_priloga;
    public $zadatak_id;
    public $naziv_fajla;

    public function getZadatak()
    {
        return Zadatak::getById($this->zadatak_id, 'zadaci', 'Zadatak');
    }

    public static function getByIdZadatka($zadatak_id)
    {
        $db = Database::getInstance();
        
        return $db->select('Prilog',
        'SELECT * FROM prilozi WHERE zadatak_id = :zadatak_id',
        [
            ':zadatak_id' => $zadatak_id,
        ]
        );
    }

    public static function getAll()
    {
        $db = Database::getInstance();
        
        return $db->select('Prilog',
        'SELECT * FROM prilozi');  
    }

    public static function dodaj($naziv_priloga, $naziv_fajla, $zadatak_id)
    {
        $db = Database::getInstance();

        $id = $db->insert('Prilog',
            'INSERT INTO prilozi (naziv_priloga, zadatak_id, naziv_fajla) 
            VALUES (:naziv_priloga, :zadatak_id, :naziv_fajla)',
            [
                ':naziv_priloga' => $naziv_priloga,
                ':zadatak_id' => $zadatak_id,
                ':naziv_fajla' => $naziv_fajla
            ]
        );

        $prilozi = $db->select('Prilog',
            'SELECT * FROM prilozi WHERE id = :id',
            [
                ':id' => $id,
            ]
        );
        foreach ($prilozi as $prilog) {
            return $prilog;
        }
        return null;
    }
}