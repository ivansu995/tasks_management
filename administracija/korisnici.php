<?php
require_once __DIR__ . '/../tabele/Korisnik.php';
$korisnici = Korisnik::getAll();
?>

<script>
    $(function() {
        $('.obrisi').on('click', function() {
            var id = $(this).attr('id').split('_')[1];
            var red = $(this).parent().parent();
            $.ajax({
                'url':'../logika/obrisiKorisnika.php',
                'method':'post',
                'data':{
                    'id':id
                },
                'success': function(poruka) {
                    var p = JSON.parse(poruka);
                    if (p.status === 'uspesno') {
                        red.remove();
                    } else {
                        alert("Doslo je do greske!");
                    }
                }
            })
        });

        $('.izmena').on('click', function() {
            var id = $(this).attr('id').split('_')[1];
            var red = $(this).parent().parent();
            var ime_prezime = red.find('td')[1].innerHTML;
            var korisnicko_ime = red.find('td')[2].innerHTML;
            var email = red.find('td')[3].innerHTML;
            var tip_korisnika = red.find('td')[6].innerHTML;
            $('#ime_prezime').val(ime_prezime);
            $('#korisnicko_ime').val(korisnicko_ime);
            $('#tip_korisnika').val(tip_korisnika);
            $('form').attr('action', '../logika/izmeniKorisnika.php');
        });
    })
</script>

<h2>Korisnici</h2>
<form action="../logika/dodajKorisnika.php" method="post">
    <input type="text" name="ime_prezime" id="ime_prezime" placeholder="Unesite ime i prezime"><br>
    <input type="text" name="korisnicko_ime" id="korisnicko_ime" placeholder="Unesite korisnicko ime"><br>
    <input type="email" name="email" id="email" placeholder="Unesite e-mail adresu"><br>
    <input type="password" name="lozinka" id="lozinka" placeholder="Lozinka"><br>
    <input type="date" name="datum_rodjenja" id="datum_rodjenja" placeholder="Unesite datum rodjenja"><br>
    <input type="text" name="telefon" id="telefon" placeholder="Broj telefona"><br>
    <input type="text" name="tip_korisnika" id="tip_korisnika" placeholder="Unesite tip korisnika"><br>
    <input type="hidden" name="korisnik_id" id="korisnik_id">
    <input type="submit" value="Snimi">
</form>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Ime prezime</th>
            <th>Korisnicko ime</th>
            <th>Email</th>
            <th>Datum rodjenja</th>
            <th>Telefon</th>
            <th>Tip korisnika</th>
            <th>Izmeni</th>
            <th>Obrisi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($korisnici as $korisnik): ?> 
            <tr>
                <td><?= $korisnik->id ?></td>
                <td><?= $korisnik->ime_prezime ?></td>
                <td><?= $korisnik->korisnicko_ime ?></td>
                <td><?= $korisnik->email ?></td>
                <td><?= $korisnik->datum_rodjenja ?></td>
                <td><?= $korisnik->telefon ?></td>
                <td><?= $korisnik->tip_korisnika_id ?></td>
                <td><button id="izmeni_<?= $korisnik->id ?>" class="izmena">Izmeni</button></td>
                <td><button id="obrisi_<?= $korisnik->id ?>" class="obrisi">Obrisi</button></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>