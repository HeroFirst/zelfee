<?php
/**
 * @var \Zelfi\Model\ZFUser $AppUser
 * @var \Zelfi\Model\ZFCities $AppCities
 *
 */

?>
<?php require_once __DIR__.'/../header.php' ?>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered table-striped data-table-full">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Ссылка</th>
                        <th>Тип</th>
                        <th>Город</th>
                        <th>На главной?</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($partners) foreach ($partners as $index => $partner): ?>
                        <tr <?= $partner['is_main'] ? 'class="warning"': ''?>>
                            <td><a href="/private/partners/edit/<?=$partner['id']?>"><?=$partner['title']?></a></td>
                            <td><?=$partner['description']?></td>
                            <td><a href="<?=$partner['url']?>" target="_blank"><?=$partner['url']?></a></td>
                            <td><?=$partner['type_name']?></td>
                            <td><?=$partner['city']==0 ? 'Все города' : $AppCities->getCityById($partner['city'])['name']?></td>
                            <td><?=$partner['is_main'] ? 'Да': 'Нет' ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Ссылка</th>
                        <th>Тип</th>
                        <th>Город</th>
                        <th>На главной?</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="/private/partners/new" class="btn btn-success pull-right">Добавить</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
