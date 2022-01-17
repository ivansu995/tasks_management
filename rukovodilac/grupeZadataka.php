<?php
require_once __DIR__ . '/../tabele/GrupaZadataka.php';
$grupeZadataka = GrupaZadataka::getAll();
?>

<script>
    $(function() {
        $('.obrisi').on('click', function() {
            var id = $(this).attr('id').split('_')[1];
            var red = $(this).parent().parent();
            $.ajax({
                'url':'../logika/obrisiGrupuZadataka.php',
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
            $('form').attr('action', '../logika/izmeniGrupuZadataka.php');
        });
    })
</script>

<h2>Grupe zadataka</h2>
<form action="../logika/dodajGrupuZadataka.php" method="post">
    <input type="text" name="naziv" id="naziv" placeholder="Unesite naziv">
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
        <?php foreach($grupeZadataka as $grupaZadataka): ?> 
            <tr>
                <td><?= $grupaZadataka->id ?></td>
                <td><?= $grupaZadataka->naziv ?></td>
                <td><button id="izmeni_<?= $grupaZadataka->id ?>" class="izmena">Izmeni</button></td>
                <td><button id="obrisi_<?= $grupaZadataka->id ?>" class="obrisi">Obrisi</button></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>