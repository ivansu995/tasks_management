<?php
session_start();
if (!isset($_SESSION['korisnik_admin_id'])) {
    header('Location: prijava.php');
    die();
}

// if (isset($_GET['strana'])) {
//     if ($_GET['strana'] === 'tipoviKorisnika') {
//         require_once __DIR__ . '/../administracija/tipoviKorisnika.php';
//     }
// }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
 
        <script src="../js/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <a href="../logika/odjaviSe.php">Odjavi se</a>
        <hr>
        <nav>
            <ul>
                <li>
                    <a href="admin.php?strana=tipoviKorisnika">Tipovi korisnika</a>
                </li>
                <li>
                    <a href="admin.php?strana=korisnici">Korisnici</a>
                </li>
                <li>
                    <a href="admin.php?strana=grupeZadataka">Grupe zadataka</a>
                </li>
                <li>
                    <a href="admin.php?strana=zadaci">Zadaci</a>
                </li>
                <li>
                    <a href="admin.php?strana=komentari">Komentari</a>
                </li>
                <!-- <li>
                    <a href="index.php">Obicni korisnici</a>
                </li>
                <li>
                    <a href="rukovodilac.php">Rukovodioci</a>
                </li> -->
            </ul>
        </nav>
        <hr>
        <?php if (isset($_GET['strana'])): ?> 
            <?php if ($_GET['strana'] === 'tipoviKorisnika'): ?> 
                <?php require_once __DIR__ . '/../administracija/tipoviKorisnika.php'; ?> 
            <?php elseif ($_GET['strana'] === 'korisnici'): ?>
                <?php require_once __DIR__ . '/../administracija/korisnici.php'; ?>    
            <?php elseif ($_GET['strana'] === 'grupeZadataka'): ?>
                <?php require_once __DIR__ . '/../administracija/grupeZadataka.php'; ?>        
            <?php elseif ($_GET['strana'] === 'zadaci'): ?>
                <?php require_once __DIR__ . '/../administracija/zadaci.php'; ?>        
            <?php elseif ($_GET['strana'] === 'komentari'): ?>
                <?php require_once __DIR__ . '/../administracija/komentari.php'; ?>    
            <?php endif ?>     
        <?php endif ?>
    </body>
</html>