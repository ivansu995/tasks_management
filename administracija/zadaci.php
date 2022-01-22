<?php
require_once __DIR__ . '/../tabele/Zadatak.php';
require_once __DIR__ . '/../tabele/Korisnik.php';
require_once __DIR__ . '/../tabele/GrupaZadataka.php';
require_once __DIR__ . '/../tabele/Prilog.php';
require_once __DIR__ . '/../tabele/Izvrsava.php';

$zadaci = Zadatak::getAll();
$korisnici = Korisnik::getByTip(2); //vraca korisnike koji rukovodioci
$grupe_zadataka = GrupaZadataka::getAll();
$tip_korisnika = TipKorisnika::getByName("izvrsilac");
$obicni_korsinici = Korisnik::getByTip($tip_korisnika->id);
$izvrsioci = Izvrsava::getAll();
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
            var tip_korisnika = red.find('td')[7].getAttribute('data-korisnik');
            var grupe_zadataka = red.find('td')[9].getAttribute('data-grupa-zadataka');
            var zavrsen = red.find('td')[10].innerHTML;
            var otkazan = red.find('td')[11].innerHTML;
            $('#zadatak_id').val(id);
            $('#naslov').val(naslov);
            $('#opis').val(opis);
            $('#prioritet').val(prioritet);
            $('#pocetak_zadatka').val(pocetak_zadatka);
            $('#kraj_zadatka').val(kraj_zadatka);
            $('#tip_korisnika').val(tip_korisnika);
            $('#grupe_zadataka').val(grupe_zadataka);
            $('#zavrsen').val(zavrsen);
            $('#otkazan').val(otkazan);
            $('form').attr('action', '../logika/izmeniZadatak.php');
        });
    })
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="dodavanje_zadatka_container col-6">
            <h4 class="podnaslov">Dodavanje novog zadatka</h4>    
            <form action="../logika/dodajZadatak.php"
                method="post" 
                id="prva_forma" 
                enctype="multipart/form-data">

                <div class="form-group">
                    <label for="naslov"
                        class="form-label">
                            Naziv zadatka
                    </label>   
                    <input type="text" 
                        name="naslov" 
                        id="naslov"
                        maxlength="191"
                        placeholder="Unesite naslov zadatka"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="opis"
                        class="form-label">
                            Opis zadatka
                    </label>
                    <textarea name="opis" 
                        id="opis"
                        placeholder="Unesti opis zadatka"
                        class="form-control"
                    ></textarea>
                </div>
                <div class="form-group">
                    <label for="prioritet"
                        class="form-label">
                            Prioritet zadatka
                    </label>  
                    <select name="prioritet" id="prioritet" class="form-control">
                        <?php for($i = 1; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pocetak_zadatka"
                        class="form-label">
                            Datum pocetka zadatka
                    </label> 
                    <input type="date"
                        name="pocetak_zadatka"
                        id="pocetak_zadatka"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="kraj_zadatka"
                        class="form-label">
                            Datum kraja zadatka
                    </label> 
                    <input type="date"
                        name="kraj_zadatka"
                        id="kraj_zadatka"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="prilog"
                        class="form-label">
                            Izaberite fajlove
                    </label>
                    <input type="file" name="prilog[]" 
                        id="prilog" 
                        placeholder="Dodaj fajl"
                        accept=".pdf,.png,.jpg,.jpeg,.txt,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                        multiple
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="izvrsioci"
                        class="form-label">
                            Izaberite izvrsioce (Ctrl za vise)
                    </label>
                    <select name="izvrsioci[]"
                        multiple
                        id="izvrsoci"
                        class="form-control">
                        <?php foreach($obicni_korsinici as $korisnik): ?>
                            <option value="<?= $korisnik->id?>"><?= $korisnik->ime_prezime?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tip_korisnika"
                        class="form-label">
                            Izaberite rukovodioca
                    </label>
                    <select name="tip_korisnika"
                        id="tip_korisnika"
                        class="form-control">
                        <?php foreach($korisnici as $korisnik): ?>
                            <option value="<?= $korisnik->id?>"><?= $korisnik->ime_prezime ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="grupe_zadataka"
                        class="form-label">
                            Izaberite grupu zadatka
                    </label>
                    <select name="grupe_zadataka"
                        id="grupe_zadataka"
                        class="form-control">
                        <?php foreach($grupe_zadataka as $grupa): ?>
                            <option value="<?= $grupa->id?>"><?= $grupa->naziv ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="zavrsen"
                        class="form-label">
                            Da li je zadatak zavrsen?
                    </label>
                    <select name="zavrsen"
                        id="zavrsen"
                        class="form-control">
                        <option value="Ne">Ne</option>
                        <option value="Da">Da</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="otkazan"
                        class="form-label">
                            Da li je zadatak otkazan?
                    </label>
                    <select name="otkazan"
                        id="otkazan"
                        class="form-control">
                        <option value="Ne">Ne</option>
                        <option value="Da">Da</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit"
                        value="Snimi"
                        class="btnSubmit">
                </div>
                <input type="hidden" name="zadatak_id" id="zadatak_id">
            </form>
        </div>
        <div class="col-6">
            <form method="post" id="forma_filtriranje" action="#tabela">
                <h4 class="podnaslov">Filtriranje zadataka</h4>
                <div class="form-group">
                    <label for="naziv_pretraga"
                        class="form-label">
                            Unesite naziv zadatka za pretragu
                    </label>
                    <input type="text"
                        name="naziv_pretraga"
                        placeholder="Naziv zadatka"
                        id="naziv_pretraga"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="rukovodilac_pretraga"
                        class="form-label">
                            Unesite ime rukoviodioca za pretragu
                    </label>
                    <input type="text"
                        name="rukovodilac_pretraga"
                        placeholder="Ime rukovodioca"
                        id="rukovodilac_pretraga"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="prioritet_pretraga"
                        class="form-label">
                            Odaberite prioritet zadatka
                    </label>
                    <select 
                        name="prioritet_pretraga"
                        id="prioritet_pretraga"
                        class="form-control">
                    <?php for($i = 1; $i <= 10; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pocetak_zadatka_pretraga"
                        class="form-label">
                            Pocetak zadatka
                    </label>
                    <input type="date"
                        name="pocetak_zadatka_pretraga"
                        id="pocetak_zadatka_pretraga"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="kraj_zadatka_pretraga"
                        class="form-label">
                            Kraj zadatka
                    </label>
                    <input type="date"
                        name="kraj_zadatka_pretraga"
                        id="kraj_zadatka_pretraga"
                        class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit"
                        name="pretraga"
                        value="Filtriraj"
                        class="btnSubmit">
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
<hr>
<table class="table table-hover" id="tabela">
    <thead>
        <tr>
            <th>Id</th>
            <th>Naslov</th>
            <th>Opis</th>
            <th>Prioritet</th>
            <th>Pocetak zadatka</th>
            <th>Kraj zadatka</th>
            <th>Prilog</th>
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
            ?>
            <?php if (!empty($filtrirani_zadaci)): ?>
                <?php foreach ($filtrirani_zadaci as $z): ?>
                    <tr>
                        <td><?= $z->id ?></td>
                        <td><?= $z->naslov ?></td>
                        <td><?= $z->opis ?></td>
                        <td><?= $z->prioritet ?></td>
                        <td>
                            <?= date('d.m.Y',
                                strtotime($z->pocetak_zadatka)) ?>
                        </td>
                        <td>
                            <?= date('d.m.Y',
                                strtotime($z->kraj_zadatka)) ?>
                        </td>
                        <td>
                            <?php foreach($prilozi as $p): ?>
                                <a href="../<?= $p->naziv_priloga ?>">
                                    <?= $p->naziv_fajla ?>
                                </a>
                            <?php endforeach ?>
                        </td>
                        <td>
                            <?php foreach($izvrsioci as $i): ?>
                                <?php if($z->id === $i->zadatak_id): ?>
                                    <?= Korisnik::getById($i->korisnik_id, 'korisnici', 'Korisnik')->ime_prezime ?> 
                                <?php endif ?>
                            <?php endforeach ?>
                        </td>
                        <td data-korisnik="<?= $z->getKorisnik()->id ?>">
                            <?= $z->getKorisnik()->ime_prezime ?>
                        </td>
                        <td data-grupa-zadatka="<?= $z->getGrupaZadataka()->id ?>">
                            <?= $z->getGrupaZadataka()->naziv ?>
                        </td>
                        <td><?= $z->zavrsen ?></td>
                        <td><?= $z->otkazan ?></td>
                        <td><button id="izmeni_<?= $z->id ?>" class="izmena">Izmeni</button></td>
                        <td><button id="obrisi_<?= $z->id ?>" class="obrisi">Obrisi</button></td>
                        <td>
                            <button id="otvori_<?= $z->id ?>" 
                                onclick="location.href='./admin.php?strana=zadatak&id=<?= $z->id ?>'"
                                class="btnOtvori">
                                    Otvori
                            </button>
                        </td>
                    </tr>
                <?php endforeach?>
            <?php else: ?>
                <tr><td><?= "Nema pronadjenih podataka" ?></td></tr>
        <?php endif ?>
        <?php else: ?>
        <?php foreach($zadaci as $zadatak): ?> 
            <tr>
                <td><?= $zadatak->id ?></td>
                <td><?= $zadatak->naslov ?></td>
                <td><?= $zadatak->opis ?></td>
                <td><?= $zadatak->prioritet ?></td>
                <td>
                    <?= date('d.m.Y',
                        strtotime($zadatak->pocetak_zadatka)) ?>
                </td>
                <td>
                    <?= date('d.m.Y',
                        strtotime($zadatak->kraj_zadatka)) ?>
                </td>
                <td>
                    <?php $prilozi_zadatka = Prilog::getByIdZadatka($zadatak->id); ?>
                    <?php foreach($prilozi_zadatka as $p): ?>
                        <?php if($zadatak->id === $p->zadatak_id): ?>
                            <a href="../<?= $p->naziv_priloga ?>">
                                <?= $p->naziv_fajla ?>
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
                        onclick="location.href='./admin.php?strana=zadatak&id=<?= $zadatak->id ?>'"
                        class="btnOtvori">
                            Otvori
                    </button>
                </td>
            </tr>
        <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>