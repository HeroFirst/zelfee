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
                <li><a href="/private/news/all">Опубликованные</a></li>
                <li><a href="/private/news/draft">Черновики</a></li>
                <li class="active"><a href="/private/news/trash">Корзина</a></li>
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
                    <?php if ($news) foreach ($news as $index => $news_item): ?>
                        <tr>
                            <td><a href="/private/news/edit/<?=$news_item['id']?>"><?=$news_item['title']?></a></td>
                            <td><?=$news_item['description_short']?></td>
                            <td><?=$news_item['type']?></td>
                            <td><?=$news_item['date_publish']?></td>
                            <td><?=$news_item['author']['first_name']?> <?=$news_item['author']['last_name']?></td>
                            <td><?=$news_item['is_hot'] ? 'Да' : 'Нет'?></td>
                            <td><?=$news_item['is_top'] ? 'Да' : 'Нет'?></td>
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
