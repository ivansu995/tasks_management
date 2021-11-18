<?php
require_once __DIR__ . '/Tabela.php';
require_once __DIR__ . '/Zadatak.php';
require_once __DIR__ . '/Korisnik.php';

class Izvrsava extends Tabela
{
    public $id;
    public $korisnik_id;
    public $zadatak_id;

    public function getZadatak()
    {
        return Zadatak::getById($this->zadatak_id, 'zadaci', 'Zadatak');
    }

    public function getKorisnik()
    {
        return Korisnik::getById($this->korisnik_id, 'korisnici', 'Korisnik');
    }
}