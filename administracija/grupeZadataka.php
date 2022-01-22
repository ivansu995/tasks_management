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

<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <form action="../logika/dodajGrupuZadataka.php" method="post">
                <h4 class="podnaslov">Dodaj grupu zadatka</h4>
                <div class="form-group">
                    <label for="naziv"
                        class="form-label">
                            Naziv grupe zadataka
                    </label>
                    <input type="text"
                        name="naziv"
                        id="naziv"
                        placeholder="Unesite naziv"
                        class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit"
                        value="Snimi"
                        class="btnSubmit">
                </div>
                <input type="hidden" name="naziv_id" id="naziv_id">
            </form>
        </div>
    </div><hr>
    <div class="row justify-content-center">
        <div class="col-6">
            <table class="table table-hover">
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
        </div>
    </div>
</div>