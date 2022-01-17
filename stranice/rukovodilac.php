<?php
session_start();
if (!isset($_SESSION['korisnik_rukovodilac_id'])) {
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
        <title>Rukovodilac</title>
        <script src="../js/jquery-3.6.0.min.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body>
        <a href="../logika/odjaviSe.php">Odjavi se</a>
        <hr>
        <nav>
            <ul>
                <li>
                    <a href="rukovodilac.php?strana=zadaci">Zadaci</a>
                </li>
                <li>
                    <a href="rukovodilac.php?strana=grupeZadataka">Grupe zadataka</a>
                </li>
            </ul>
        </nav>
        <hr>
        <?php if (isset($_GET['strana'])): ?> 
            <?php if ($_GET['strana'] === 'zadaci'): ?> 
                <?php require_once __DIR__ . '/../rukovodilac/zadaci.php'; ?> 
            <?php elseif ($_GET['strana'] === 'grupeZadataka'): ?>
                <?php require_once __DIR__ . '/../rukovodilac/grupeZadataka.php'; ?>          
            <?php elseif ($_GET['strana'] === 'zadatak' && isset($_GET['id'])): ?>
                <?php require_once __DIR__ . '/../rukovodilac/zadatak.php'; ?> 
            <?php endif ?>     
        <?php endif ?>
    </body>
</html>