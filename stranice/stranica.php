<?php
session_start();
if(!isset($_SESSION['korisnik_id'])){
    header('Location: prijava.php');
    die();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Stranica</title>
    </head>
    <body>
        <a href="../logika/odjaviSe.php">Odjavi se</a>
    </body>
</html>