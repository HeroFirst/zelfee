<?php require_once __DIR__.'/../header.php' ?>

<?php
/**
 * @var \Zelfi\Model\ZFUser $AppUser
 * @var \Zelfi\Model\ZFCities $AppCities
 *
 */

?>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered table-striped data-table-full">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Краткое описание</th>
                        <th>Город</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($places) foreach ($places as $index => $place): ?>
                        <tr>
                            <td><a href="/private/places/edit/<?=$place['id']?>"><?=$place['name']?></a></td>
                            <td><?=$place['description_short']?></td>
                            <td><?=$AppCities->getCityById($place['city'])['name']?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Название</th>
                        <th>Краткое описание</th>
                        <th>Город</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="/private/places/new" class="btn btn-success pull-right">Добавить</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
