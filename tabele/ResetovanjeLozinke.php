<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/Tabela.php';

class ResetovanjeLozinke
{
    public $id;
    public $email;
    public $token;
    public $istice;

    public static function ubaciToken($email, $token, $istice)
    {
        
        $db = Database::getInstance();

        try
        {
            $id_lozinke = $db->insert('ResetovanjeLozinke',
                'INSERT INTO resetovanje_lozinke (
                    email,
                    token,
                    istice
                ) 
                VALUES (:email, :token, :istice)',
                [
                    ':email' => $email,
                    ':token' => $token,
                    ':istice' => $istice,
                ]
            );
        }
        catch(Exception $e)
        {
            return false;
        }
        return $id_lozinke;
    }

    public static function obrisiToken($email)
    {
        $db=Database::getInstance();

        $db->delete('DELETE FROM resetovanje_lozinke WHERE email=:email',
            [
                ':email' => $email,
            ]
        );
    }

    public static function proveriToken($token, $vreme)
    {
        $db=Database::getInstance();

        $rezultati = $db->select('ResetovanjeLozinke', 
            'SELECT * FROM resetovanje_lozinke 
            WHERE token=:token AND istice >= :vreme LIMIT 1',
            [
                ':token' => $token,
                ':vreme' => $vreme
            ]
        );

        foreach ($rezultati as $rezultat) {
            return $rezultat;
        }
        return null;
    }
}