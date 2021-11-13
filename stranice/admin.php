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
                    <a href="stranica.php">Obicni korisnici</a>
                </li>
                <li>
                    <a href="rukovodilac.php">Rukovodioci</a>
                </li>
            </ul>
        </nav>
        <hr>
        <?php
            if (isset($_GET['strana'])) {
                if ($_GET['strana'] === 'tipoviKorisnika') {
                    require_once __DIR__ . '/../administracija/tipoviKorisnika.php';
                }
            }
        ?>
    </body>
</html>