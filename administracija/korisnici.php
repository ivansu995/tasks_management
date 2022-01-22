<?php
require_once __DIR__ . '/../tabele/Korisnik.php';
require_once __DIR__ . '/../tabele/TipKorisnika.php';
$korisnici = Korisnik::getAll();
$tipovi = TipKorisnika::getAll();
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
            var datum_rodjenja = red.find('td')[4].innerHTML;
            var telefon = red.find('td')[5].innerHTML;
            var tip_korisnika = red.find('td')[6].getAttribute('data-tip');
            $('#korisnik_id').val(id);
            $('#ime_prezime').val(ime_prezime);
            $('#korisnicko_ime').val(korisnicko_ime);
            $('#email').val(email);
            $('#datum_rodjenja').val(datum_rodjenja);
            $('#telefon').val(telefon);
            $('#tip_korisnika').val(tip_korisnika);
            $('form').attr('action', '../logika/izmeniKorisnika.php');
        });
    })
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <form action="../logika/dodajKorisnika.php" method="post">
                <h4 class="podnaslov">Dodaj korisnika</h4>
                <div class="form-group">
                    <label for="ime_prezime"
                        class="form-label">
                            Ime i prezime korisnika
                    </label>
                    <input type="text"
                        name="ime_prezime"
                        id="ime_prezime"
                        placeholder="Unesite ime i prezime"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="korisnicko_ime"
                        class="form-label">
                            Korisnicko ime
                    </label>
                    <input type="text"
                        name="korisnicko_ime"
                        id="korisnicko_ime"
                        placeholder="Unesite korisnicko ime"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="email"
                        class="form-label">
                            Email adresa korisnika
                    </label>
                    <input type="email"
                        name="email"
                        id="email"
                        placeholder="Unesite e-mail adresu"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="lozinka"
                        class="form-label">
                            Lozinka korisnika
                    </label>
                    <input type="password"
                        name="lozinka"
                        id="lozinka"
                        placeholder="Lozinka"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="datum_rodjenja"
                        class="form-label">
                            Datum rodjenja
                    </label>
                    <input type="date"
                        name="datum_rodjenja"
                        id="datum_rodjenja"
                        placeholder="Unesite datum rodjenja"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="telefon"
                        class="form-label">
                            Broj telefona
                    </label>
                    <input type="text"
                        name="telefon"
                        id="telefon"
                        placeholder="Broj telefona"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="telefon"
                        class="form-label">
                            Tip korisnika
                    </label>
                    <select name="tip_korisnika"
                        id="tip_korisnika"
                        class="form-control">
                        <?php foreach($tipovi as $tip): ?>
                            <option value="<?= $tip->id?>"><?= $tip->naziv_tipa ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit"
                        value="Snimi"
                        class="btnSubmit">
                </div>
                <input type="hidden" name="korisnik_id" id="korisnik_id">
            </form>
        </div>
    </div><hr>
    <div class="row justify-content-center">
        <div class="col-12">
            <table class="table table-hover">
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
                            <td>
                                <?= date('d.m.Y',
                                    strtotime($korisnik->datum_rodjenja)) ?>
                            </td>
                            <td><?= $korisnik->telefon ?></td>
                            <td data-tip="<?= $korisnik->getTipKorisnika()->id ?>">
                                <?= $korisnik->getTipKorisnika()->naziv_tipa ?>
                            </td>
                            <td><button id="izmeni_<?= $korisnik->id ?>" class="izmena">Izmeni</button></td>
                            <td><button id="obrisi_<?= $korisnik->id ?>" class="obrisi">Obrisi</button></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>