<?php
/* @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *  @var \Zelfi\Model\ZFCities $AppCities
 */
if ($AppRendererHelper != null){
    $FooterScripts = $AppRendererHelper->getFooterScripts();
    $FooterData = $AppRendererHelper->getFooterData();
}

$AppRendererHelper->setHeaderTitle($user['first_name'].' '.$user['last_name'], 'Посещенные мероприятия');

require_once __DIR__.'/../header.php'

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
                        <th>Дата</th>
                        <th>Баллы</th>
                        <th>Категория</th>
                        <th>Заявки онлайн</th>
                        <th>Все заявки</th>
                        <th>Пришли</th>
                        <th>Место</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($events) foreach ($events as $index => $event): ?>
                        <tr>
                            <td><a href="/private/events/edit/<?=$event['id']?>"><?=$event['title']?></a></td>
                            <td><?=$event['description_short']?></td>
                            <td><?=$event['date'].' '.$event['time']?></td>
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
                            <td><?=$event['place_name']?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Название</th>
                        <th>Краткое описание</th>
                        <th>Дата</th>
                        <th>Баллы</th>
                        <th>Категория</th>
                        <th>Заявки онлайн</th>
                        <th>Все заявки</th>
                        <th>Пришли</th>
                        <th>Место</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
