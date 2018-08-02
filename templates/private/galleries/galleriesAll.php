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
                        <th>Описание</th>
                        <th>Изображений</th>
                        <th>Город</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($galleries) foreach ($galleries as $index => $gallery): ?>
                        <tr <?= $gallery['is_main'] ? 'class="warning"': ''?>>
                            <td><a href="/private/galleries/edit/<?=$gallery['id']?>"><?=$gallery['name']?></a></td>
                            <td><?=$gallery['description']?></td>
                            <td><?=count(unserialize($gallery['images']))?></td>
                            <td><?=$gallery['city']==0 ? 'Все города' : $AppCities->getCityById($gallery['city'])['name']?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Изображений</th>
                        <th>Город</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="/private/galleries/new" class="btn btn-success pull-right">Добавить</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
