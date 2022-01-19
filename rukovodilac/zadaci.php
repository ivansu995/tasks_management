<?php
require_once __DIR__ . '/../tabele/Zadatak.php';
require_once __DIR__ . '/../tabele/Korisnik.php';
require_once __DIR__ . '/../tabele/GrupaZadataka.php';
require_once __DIR__ . '/../tabele/Prilog.php';
require_once __DIR__ . '/../tabele/Izvrsava.php';
require_once __DIR__ . '/../tabele/TipKorisnika.php';
// require_once __DIR__ . '/../stranice/rukovodilac.php';

$zadaci = Zadatak::getAll();
$tip_korisnika = TipKorisnika::getByName("izvrsilac");
$obicni_korsinici = Korisnik::getByTip($tip_korisnika->id);
$korisnici = Korisnik::getByTip(2); //vraca korisnike koji su rukovodioci
$grupe_zadataka = GrupaZadataka::getAll();

$prilozi = Prilog::getAll();

$izvrsioci = Izvrsava::getAll();
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
            //prilozi
            var izvrsioci = red.find('td')[7].innerHTML;
            var tip_korisnika = red.find('td')[8].getAttribute('data-korisnik');
            var grupe_zadataka = red.find('td')[9].getAttribute('data-grupa-zadataka');
            var zavrsen = red.find('td')[10].innerHTML;
            var otkazan = red.find('td')[11].innerHTML;
            $('#zadatak_id').val(id);
            $('#naslov').val(naslov);
            $('#opis').val(opis);
            $('#prioritet').val(prioritet);
            $('#pocetak_zadatka').val(pocetak_zadatka);
            $('#kraj_zadatka').val(kraj_zadatka);
            //prilozi
            $('#izvrsioci').val(izvrsioci);
            $('#tip_korisnika').val(tip_korisnika);
            $('#grupe_zadataka').val(grupe_zadataka);
            $('#zavrsen').val(zavrsen);
            $('#otkazan').val(otkazan);
            $('#prva_forma').attr('action', '../logika/izmeniZadatak.php');
        });

    })
</script>

<h2>Zadaci</h2>
<form action="../logika/dodajZadatak.php"
    method="post" 
    id="prva_forma" 
    enctype="multipart/form-data">

    <input type="text" name="naslov" id="naslov" maxlength="191" placeholder="Unesite naslov"><br>
    <textarea name="opis" id="opis" placeholder="Unesti opis zadatka"></textarea><br>
    <select name="prioritet" id="prioritet">
        <?php for($i = 1; $i <= 10; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
        <?php endfor ?>
    </select><br>
    <input type="date" name="pocetak_zadatka" id="pocetak_zadatka"><br>
    <input type="date" name="kraj_zadatka" id="kraj_zadatka"><br>
    <label for="prilog">Izaberite fajlove:</label>
    <input type="file" name="prilog[]" 
        id="prilog" 
        placeholder="Dodaj fajl"
        accept="image/jpeg,image/png,image/gif"
        multiple><br>
    <select name="izvrsioci[]" multiple="multiple" id="izvrsoci">
        <?php foreach($obicni_korsinici as $korisnik): ?>
            <option value="<?= $korisnik->id?>"><?= $korisnik->ime_prezime?></option>
        <?php endforeach ?>
    </select>
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
    <select name="zavrsen" id="zavrsen">
        <option value="Ne">Ne</option>
        <option value="Da">Da</option>
    </select>
    <select name="otkazan" id="otkazan">
        <option value="Ne">Ne</option>
        <option value="Da">Da</option>
    </select>
    <input type="hidden" name="zadatak_id" id="zadatak_id">
    <input type="submit" value="Snimi">
</form>

<!-- Pretraga forma -->
<form method="post" id="forma_filtriranje" action="#tabela">
    <h3>Filtriranje zadataka</h3>
    <input type="text" name="naziv_pretraga" placeholder="Naziv zadatka" id="naziv_pretraga">
    <input type="text" name="rukovodilac_pretraga" placeholder="Ime rukovodioca" id="rukovodilac_pretraga">
    <select name="prioritet_pretraga" id="prioritet_pretraga">
        <?php for($i = 1; $i <= 10; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
        <?php endfor ?>
    </select>
    <input type="date" name="pocetak_zadatka_pretraga" id="pocetak_zadatka_pretraga"><br>
    <input type="date" name="kraj_zadatka_pretraga" id="kraj_zadatka_pretraga"><br>
    <input type="submit" name="pretraga" value="Filtriraj">
</form>

<table class="table table-hover" id="tabela">
    <thead>
        <tr>
            <th>Id</th>
            <th>Naslov</th>
            <th>Opis</th>
            <th>Prioritet</th>
            <th>Pocetak zadatka</th>
            <th>Kraj zadatka</th>
            <th>Prilozi</th>
            <th>Izvrsioci</th>
            <th>Rukovodilac</th>
            <th>Grupa zadatka</th>
            <th>Zavrsen</th>
            <th>Otkazan</th>
            <th>Izmeni</th>
            <th>Obrisi</th>
            <th>Otvori</th>
        </tr>
    </thead>
    <tbody id="tabela_podaci">
        <?php if (isset($_POST['pretraga'])): ?>
            <?php
                $naziv = $_POST['naziv_pretraga'];
                $rukovodilac = $_POST['rukovodilac_pretraga'];
                $prioritet = $_POST['prioritet_pretraga'];
                $pocetak_zadatka = $_POST['pocetak_zadatka_pretraga'];
                $kraj_zadatka = $_POST['kraj_zadatka_pretraga'];
                if (!empty($rukovodilac)) {
                    $rukovodilac = Korisnik::getKorisnikByName($rukovodilac)->id;
                }
                $filtrirani_zadaci = Zadatak::pretraziZadatak($naziv, $prioritet, 
                                                $rukovodilac, $pocetak_zadatka, $kraj_zadatka);
                // var_dump($filtrirani_zadaci);
                // echo '<tr><td></td></tr>';
                // die()
            ?>
            <?php if ($filtrirani_zadaci !== null): ?>
                <?php foreach($filtrirani_zadaci as $z): ?>
                    <tr>
                        <td><?= $z->id ?></td>
                        <td><?= $z->naslov ?></td>
                        <td><?= $z->opis ?></td>
                        <td><?= $z->prioritet ?></td>
                        <td><?= $z->pocetak_zadatka ?></td>
                        <td><?= $z->kraj_zadatka ?></td>
                        <td>
                            <?php foreach($prilozi as $p): ?>
                                <?php if($z->id === $p->zadatak_id): ?> 
                                    <!-- zadatak -->
                                    <?= $p->naziv_priloga ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        </td>
                        <td>
                            <?php foreach($izvrsioci as $i): ?>
                                <?php if($z->id === $i->zadatak_id): ?>
                                    <!-- zadatak -->
                                    <?= Korisnik::getById($i->korisnik_id, 'korisnici', 'Korisnik')->ime_prezime ?> 
                                <?php endif ?>
                            <?php endforeach ?>
                        </td>
                        <!-- Prilog izmeni nije dobro -->
                        <td data-korisnik="<?= $z->getKorisnik()->id ?>">
                        <!-- zadatak -->
                            <?= $z->getKorisnik()->ime_prezime ?>
                        </td>
                        <td data-grupa-zadatka="<?= $z->getGrupaZadataka()->id ?>">
                        <!-- zadatak -->
                            <?= $z->getGrupaZadataka()->naziv ?>
                        </td>
                        <td><?= $z->zavrsen ?></td>
                        <td><?= $z->otkazan ?></td>
                        <td><button id="izmeni_<?= $z->id ?>" class="izmena">Izmeni</button></td>
                        <td><button id="obrisi_<?= $z->id ?>" class="obrisi">Obrisi</button></td>
                        <td>
                            <button id="otvori_<?= $z->id ?>" 
                                onclick="location.href='./rukovodilac.php?strana=zadatak&id=<?= $z->id ?>'">
                                    Otvori
                            </button>
                        </td>
                    </tr>
                <?php endforeach?>
            <?php endif ?>
        <?php else: ?>
    
        <?php foreach($zadaci as $zadatak): ?> 
            <tr>
                <td><?= $zadatak->id ?></td>
                <td><?= $zadatak->naslov ?></td>
                <td><?= $zadatak->opis ?></td>
                <td><?= $zadatak->prioritet ?></td>
                <td><?= $zadatak->pocetak_zadatka ?></td>
                <td><?= $zadatak->kraj_zadatka ?></td>
                <td>
                    <?php $prilozi_zadatka = Prilog::getByIdZadatka($zadatak->id); ?>
                    <?php foreach($prilozi_zadatka as $p): ?>
                        <?php if($zadatak->id === $p->zadatak_id): ?>
                            <a href="../<?= $p->naziv_priloga ?>">
                                <?= $p->naziv_priloga ?>
                            </a>
                        <?php endif ?>
                    <?php endforeach ?>
                </td>
                <td>
                    <?php foreach($izvrsioci as $i): ?>
                        <?php if($zadatak->id === $i->zadatak_id): ?>
                            <?= Korisnik::getById($i->korisnik_id, 'korisnici', 'Korisnik')->ime_prezime ?>  
                        <?php endif ?>
                    <?php endforeach ?>
                </td>
                <!-- Prilog izmeni nije dobro -->
                <td data-korisnik="<?= $zadatak->getKorisnik()->id ?>">
                    <?= $zadatak->getKorisnik()->ime_prezime ?>
                </td>
                <td data-grupa-zadatka="<?= $zadatak->getGrupaZadataka()->id ?>">
                    <?= $zadatak->getGrupaZadataka()->naziv ?>
                </td>
                <td><?= $zadatak->zavrsen ?></td>
                <td><?= $zadatak->otkazan ?></td>
                <td><button id="izmeni_<?= $zadatak->id ?>" class="izmena">Izmeni</button></td>
                <td><button id="obrisi_<?= $zadatak->id ?>" class="obrisi">Obrisi</button></td>
                <td>
                    <button id="otvori_<?= $zadatak->id ?>" 
                        onclick="location.href='./rukovodilac.php?strana=zadatak&id=<?= $zadatak->id ?>'">
                            Otvori
                    </button>
                </td>
            </tr>
        <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>