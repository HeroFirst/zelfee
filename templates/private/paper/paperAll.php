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
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="/private/paper/all">Опубликованные</a></li>
                <li><a href="/private/paper/draft">Черновики</a></li>
                <li><a href="/private/paper/trash">Корзина</a></li>
            </ul>

            <div class="tab-content">
                <table data-order='[[ 3, "desc" ]]' class="table table-bordered table-striped data-table-full">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Короткое описание</th>
                        <th>Тип</th>
                        <th>Дата публикации</th>
                        <th>Автор</th>
                        <th>Топ</th>
                        <th>Слайдер</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($papers) foreach ($papers as $index => $paper): ?>
                        <tr>
                            <td><a href="/private/paper/edit/<?=$paper['id']?>"><?=$paper['title']?></a></td>
                            <td><?=$paper['description_short']?></td>
                            <td><?=$paper['type_name']?></td>
                            <td><?=$paper['date_publish']?></td>
                            <td><?=$paper['author']['first_name']?> <?=$paper['author']['last_name']?></td>
                            <td><?=$paper['is_hot'] ? 'Да' : 'Нет'?></td>
                            <td><?=$paper['is_top'] ? 'Да' : 'Нет'?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Название</th>
                        <th>Короткое описание</th>
                        <th>Категория</th>
                        <th>Дата публикации</th>
                        <th>Автор</th>
                        <th>Топ</th>
                        <th>Слайдер</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
