<?php

session_start();
if (!isset($_SESSION['korisnik_admin_id'])) {
    header('Location: prijava.php');
    die();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
            crossorigin="anonymous">
        <script src="../js/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="../stilovi/navbar.css">
        <link rel="stylesheet" href="../stilovi/forme.css">
        <link rel="stylesheet" href="../stilovi/main.css">
        <link rel="stylesheet" href="../stilovi/zadatakPrikaz.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarText"
                    aria-controls="navbarText"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" 
                            aria-current="page" 
                            href="admin.php">
                            Pocetna strana
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" 
                            href="admin.php?strana=zadaci">
                            Zadaci
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="admin.php?strana=grupeZadataka">
                            Grupe zadataka
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="admin.php?strana=korisnici">
                            Korisnici
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="admin.php?strana=tipoviKorisnika">
                            Tipovi korisnika
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="admin.php?strana=komentari">
                            Komentari
                        </a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <a class="nav-link" href="../logika/odjaviSe.php">Odjavi se</a>
                </span>
                </div>
            </div>
        </nav>
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
            <?php elseif ($_GET['strana'] === 'zadatak' && isset($_GET['id'])): ?>
                <?php require_once __DIR__ . '/../administracija/zadatak.php'; ?> 
            <?php endif ?>       
        <?php endif ?>
    </body>
</html>