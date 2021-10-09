<?php
session_start();
if (isset($_SESSION['korisnik_id'])) {
    header('Location: ./prijava.php');
    die();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Aktivacija naloga</title>
        <!-- <link rel="stylesheet" href="main.css"> -->
    </head>
    <body>

        <form method="post" action="../logika/aktivirajNalog.php" id="aktivacija_naloga">
            <?php if (isset($_GET['aktivacija'])) : ?>
                <p id="greska">
                    Uspesno ste aktivirali nalog. Kliknite na dugme da biste se nastavili.
                </p>
            <?php endif ?>

            <br>

            <button id="nastavi"> Nastavi </button>

            <br>

        </form>
    </body>
</html>