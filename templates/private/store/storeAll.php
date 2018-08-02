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
                        <th>ID</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Цена (Баллы / Рубли)</th>
                        <th>Количество</th>
                        <th>Категория</th>
                        <th>Город</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($store_items) foreach ($store_items as $index => $store_item): ?>
                        <tr>
                            <td><?=$store_item['id']?></td>
                            <td><a href="/private/store/edit/<?=$store_item['id']?>"><?=$store_item['name']?></a></td>
                            <td><?=$store_item['description']?></td>
                            <td><?=$store_item['balls']?> / <?=$store_item['price']?></td>
                            <td><?=$store_item['count']?></td>
                            <td><?=$store_item['category_name']?></td>
                            <td><?=$store_item['city'] == 0 ? 'Все города' : $AppCities->getCityById($store_item['city'])['name']?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Цена (Баллы / Рубли)</th>
                        <th>Количество</th>
                        <th>Категория</th>
                        <th>Город</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="/private/store/new" class="btn btn-success pull-right">Добавить</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
