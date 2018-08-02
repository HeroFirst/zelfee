<?php
/* @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *  @var \Zelfi\Model\ZFCities $AppCities
 */
if ($AppRendererHelper != null){
    $FooterScripts = $AppRendererHelper->getFooterScripts();
    $FooterData = $AppRendererHelper->getFooterData();
}

?>
<?php require_once __DIR__.'/../header.php' ?>

<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="/private/events/all">Опубликованные</a></li>
                <li><a href="/private/events/trash">Корзина</a></li>
            </ul>

            <div class="tab-content">
                <table data-order='[[ 2, "desc" ]]' class="table table-bordered table-striped data-table-full">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Краткое описание</th>
                        <th>Дата</th>
                        <th>Дата окончания</th>
                        <th>Баллы</th>
                        <th>Категория</th>
                        <th>Заявки онлайн</th>
                        <th>Все заявки</th>
                        <th>Пришли</th>
                        <th>Город</th>
                        <th>Места</th>
                        <th>Галерея</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($events) foreach ($events as $index => $event): ?>
                        <tr>
                            <td><a href="/private/events/edit/<?=$event['id']?>"><?=$event['title']?></a></td>
                            <td><?=$event['description_short']?></td>
                            <td><?=$event['date_start']?></td>
                            <td><?=$event['date_end']?></td>
                            <td><?=$event['balls']?></td>
                            <td><?=($event['category_name']) ? $event['category_name'] : '' ?></td>
                            <td>
                                <a href="/private/events/members/<?=$event['id']?>/online"><?=$event['members_count_online']?></a>
                            </td>
                            <td>
                                <a href="/private/events/members/<?=$event['id']?>/all"><?=$event['members_count_all']?></a>
                            </td>
                            <td>
                                <a href="/private/events/members/<?=$event['id']?>/finished"><?=$event['members_count_finished']?></a>
                            </td>
                            <td><?=$AppCities->getCityById($event['city'])['name']?></td>
                            <td>
                                <?php if ($event['places']) foreach ($event['places'] as $index2 => $place): ?>
                                    <p><?=$place['name']?></p>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php if ($event['gallery']): ?>
                                    <a href="/private/galleries/edit/<?=$event['gallery']?>">Есть</a>
                                <?php else: ?>
                                    Нет
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Название</th>
                        <th>Краткое описание</th>
                        <th>Дата</th>
                        <th>Дата окончания</th>
                        <th>Баллы</th>
                        <th>Категория</th>
                        <th>Заявки онлайн</th>
                        <th>Все заявки</th>
                        <th>Пришли</th>
                        <th>Город</th>
                        <th>Места</th>
                        <th>Галерея</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
