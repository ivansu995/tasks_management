<?php
require_once __DIR__ . '/../tabele/Zadatak.php';
require_once __DIR__ . '/../tabele/Korisnik.php';
require_once __DIR__ . '/../tabele/GrupaZadataka.php';
require_once __DIR__ . '/../tabele/Prilog.php';

$zadaci = Zadatak::getAll();
$korisnici = Korisnik::getByTip(2); //vraca korisnike koji rukovodioci
$grupe_zadataka = GrupaZadataka::getAll();
foreach($zadaci as $zadatak) {
    $prilozi = Prilog::getByIdZadatka($zadatak->id);
}
?>

<script>
    $(function() {
        $('.obrisi').on('click', function() {
            var id = $(this).attr('id').split('_')[1];
            var red = $(this).parent().parent();
            $.ajax({
                'url':'../logika/obrisiZadatak.php',
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
            var naslov = red.find('td')[1].innerHTML;
            var opis = red.find('td')[2].innerHTML;
            var prioritet = red.find('td')[3].innerHTML;
            var pocetak_zadatka = red.find('td')[4].innerHTML;
            var kraj_zadatka = red.find('td')[5].innerHTML;
            var tip_korisnika = red.find('td')[6].getAttribute('data-korisnik');
            var grupe_zadataka = red.find('td')[7].getAttribute('data-grupa-zadataka');
            $('#zadatak_id').val(id);
            $('#naslov').val(naslov);
            $('#opis').val(opis);
            $('#prioritet').val(prioritet);
            $('#pocetak_zadatka').val(pocetak_zadatka);
            $('#kraj_zadatka').val(kraj_zadatka);
            $('#tip_korisnika').val(tip_korisnika);
            $('#grupe_zadataka').val(grupe_zadataka);
            $('form').attr('action', '../logika/izmeniZadatak.php');
        });
    })
</script>

<h2>Zadaci</h2>
<form action="../logika/dodajZadatak.php" method="post">
    <input type="text" name="naslov" id="naslov" maxlength="191" placeholder="Unesite naslov"><br>
    <textarea name="opis" id="opis" placeholder="Unesti opis zadatka"></textarea><br>
    <select name="prioritet" id="prioritet">
        <?php for($i = 1; $i <= 10; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
        <?php endfor ?>
    </select><br>
    <input type="date" name="pocetak_zadatka" id="pocetak_zadatka"><br>
    <input type="date" name="kraj_zadatka" id="kraj_zadatka"><br>
    <input type="file" name="prilog" id="prilog" placeholder="Dodaj fajl"><br>
    <select name="tip_korisnika" id="tip_korisnika">
        <?php foreach($korisnici as $korisnik): ?>
            <option value="<?= $korisnik->id?>"><?= $korisnik->ime_prezime ?></option>
        <?php endforeach ?>
    </select><br>
    <select name="grupe_zadataka" id="grupe_zadataka">
        <?php foreach($grupe_zadataka as $grupa): ?>
            <option value="<?= $grupa->id?>"><?= $grupa->naziv ?></option>
        <?php endforeach ?>
    </select><br>
    <input type="hidden" name="zadatak_id" id="zadatak_id">
    <input type="submit" value="Snimi">
</form>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Naslov</th>
            <th>Opis</th>
            <th>Prioritet</th>
            <th>Pocetak zadatka</th>
            <th>Kraj zadatka</th>
            <!-- <th>Prilozi</th> -->
            <th>Rukovodilac</th>
            <th>Grupa zadatka</th>
            <th>Izmeni</th>
            <th>Obrisi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($zadaci as $zadatak): ?> 
            <tr>
                <td><?= $zadatak->id ?></td>
                <td><?= $zadatak->naslov ?></td>
                <td><?= $zadatak->opis ?></td>
                <td><?= $zadatak->prioritet ?></td>
                <td><?= $zadatak->pocetak_zadatka ?></td>
                <td><?= $zadatak->kraj_zadatka ?></td>
                <?php foreach($prilozi as $p): ?>
                    <?php if($zadatak->id === $p->zadatak_id): ?>
                        <td><?= $p->naziv_priloga ?></td>
                    <?php else: ?>
                        <td></td>    
                    <?php endif ?>
                <?php endforeach ?>
                <!-- Prilog izmeni nije dobro -->
                <td data-korisnik="<?= $zadatak->getKorisnik()->id ?>">
                    <?= $zadatak->getKorisnik()->ime_prezime ?>
                </td>
                <td data-grupa-zadatka="<?= $zadatak->getGrupaZadataka()->id ?>">
                    <?= $zadatak->getGrupaZadataka()->naziv ?>
                </td>
                <td><button id="izmeni_<?= $zadatak->id ?>" class="izmena">Izmeni</button></td>
                <td><button id="obrisi_<?= $zadatak->id ?>" class="obrisi">Obrisi</button></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>