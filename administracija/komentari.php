<?php
require_once __DIR__ . '/../tabele/Komentar.php';
require_once __DIR__ . '/../tabele/Zadatak.php';
require_once __DIR__ . '/../tabele/Korisnik.php';
$komentari = Komentar::getAll();
$zadaci = Zadatak::getAll();
$korisnici = Korisnik::getAll();
?>

<script>
    $(function() {
        $('.obrisi').on('click', function() {
            var id = $(this).attr('id').split('_')[1];
            var red = $(this).parent().parent();
            $.ajax({
                'url':'../logika/obrisiKomentar.php',
                'method':'post',
                'data':{
                    'id':id
                },
                'success': function(poruka) {
                    console.log(poruka);
                    var p = JSON.parse(poruka);
                    if(p.status === "uspesno") {
                        red.remove();
                    }
                }
            })
        });

        $('.izmena').on('click', function() {
            var id = $(this).attr('id').split('_')[1];
            var red = $(this).parent().parent();
            var opis_komentara = red.find('td')[1].innerHTML;
            var zadatak_id = red.find('td')[2].getAttribute('data-zadatak');
            var korisnik_id = red.find('td')[3].getAttribute('data-korisnik');
            $('#opis_komentara').val(opis_komentara);
            $('#komentar_id').val(id);
            $('#zadatak_id').val(zadatak_id);
            $('#korisnik_id').val(korisnik_id);
            $('form').attr('action', '../logika/izmeniKomentar.php');
        });
    })
</script>

<h2>Uloge korisnika</h2>
<form action="../logika/dodajKomentar.php" method="post">
    <input type="text" name="opis_komentara" id="opis_komentara" placeholder="Unesite komentar"><br>
    <select name="zadatak_id" id="zadatak_id">
        <?php foreach($zadaci as $zadatak): ?>
            <option value="<?= $zadatak->id?>"><?= $zadatak->naslov ?></option>
        <?php endforeach ?>
    </select><br>
    <select name="korisnik_id" id="korisnik_id">
        <?php foreach($korisnici as $korisnik): ?>
            <option value="<?= $korisnik->id?>"><?= $korisnik->ime_prezime ?></option>
        <?php endforeach ?>
    </select><br>
    <input type="hidden" name="komentar_id" id="komentar_id">
    <input type="submit" value="Snimi">
</form>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Opis komentara</th>
            <th>Zadatak</th>
            <th>Korisnik</th>
            <th>Izmeni</th>
            <th>Obrisi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($komentari as $komentar): ?> 
            <tr>
                <td><?= $komentar->id ?></td>
                <td><?= $komentar->opis_komentara ?></td>
                <td data-zadatak="<?= $komentar->getZadatak()->id ?>">
                    <?= $komentar->getZadatak()->naslov ?>
                </td>
                <td data-korisnik="<?= $komentar->getKorisnik()->id ?>">
                    <?= $komentar->getKorisnik()->ime_prezime ?>
                </td>
                <td><button id="izmeni_<?= $komentar->id ?>" class="izmena">Izmeni</button></td>
                <td><button id="obrisi_<?= $komentar->id ?>" class="obrisi">Obrisi</button></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>