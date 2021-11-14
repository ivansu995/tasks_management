<?php
require_once __DIR__ . '/../tabele/TipKorisnika.php';
$tipovi = TipKorisnika::getAll();
?>

<script>
    $(function() {
        $('.obrisi').on('click', function() {
            var id = $(this).attr('id').split('_')[1];
            var red = $(this).parent().parent();
            $.ajax({
                'url':'../logika/obrisi.php',
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
            var naziv = red.find('td')[1].innerHTML;
            $('#naziv').val(naziv);
            $('#naziv_id').val(id);
            $('form').attr('action', '../logika/izmeniTipKorisnika.php');
        });
    })
</script>

<h2>Uloge korisnika</h2>
<form action="../logika/dodajTipKorisnika.php" method="post">
    <input type="text" name="naziv_tipa" id="naziv" placeholder="Unesite naziv">
    <input type="hidden" name="naziv_id" id="naziv_id">
    <input type="submit" value="Snimi">
</form>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Naziv</th>
            <th>Izmeni</th>
            <th>Obrisi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tipovi as $tip): ?> 
            <tr>
                <td><?= $tip->id ?></td>
                <td><?= $tip->naziv_tipa ?></td>
                <td><button id="izmeni_<?= $tip->id ?>" class="izmena">Izmeni</button></td>
                <td><button id="obrisi_<?= $tip->id ?>" class="obrisi">Obrisi</button></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>