<?php
/**
 * @var \Zelfi\Model\ZFUser $AppUser
 * @var \Zelfi\Model\ZFUser $AppUser
 * @var \Zelfi\Model\ZFCities $AppCities
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 *
 */

require_once __DIR__.'/../header.php' ?>

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
                <?php if ($places_users) foreach ($places_users as $index => $place_users): ?>
                <li <?=$index==0 ? 'class="active"': ''?>><a href="#tab_<?=$index?>" data-toggle="tab"><?=$place_users['title']?> (<?=$place_users['users'] ? count($place_users['users']) : 0?>)</a></li>
                <?php endforeach; ?>
            </ul>
            <div class="tab-content">
                <?php if ($places_users) foreach ($places_users as $index => $place_users):
                $users = $place_users['users'];
                ?>
                    <div class="tab-pane <?=$index==0 ? 'active': ''?>" id="tab_<?=$index?>">
                        <table class="table table-bordered table-striped data-table-full">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Город</th>
                                <th>E-mail</th>
                                <th>Телефон</th>
                                <th>Дети</th>
                                <th>Мероприятий</th>
                                <th>Баллов</th>
                                <th>Зелфи</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($users) foreach ($users as $index => $user): ?>
                                <tr>
                                    <td><?=$user['id']?></td>
                                    <td><a href="/private/users/edit/<?=$user['id']?><?=$_GET['rfidid'] ? '?rfidid='.$_GET['rfidid'] : '' ?>"><?=$user['first_name']?> <?=$user['last_name']?></a></td>
                                    <td><?=$AppCities->getCityById($user['residence'])['name']?></td>
                                    <td><?=$user['email']?></td>
                                    <td><?=$user['phone']?></td>
                                    <td><?=$user['childs'] ? $user['childs'] : 0 ?></td>
                                    <td>
                                        <?php if ($user['events_count']>0): ?>
                                            <a href="/private/users/events/<?=$user['id']?>"><?=$user['events_count']?></a>
                                        <?php else: ?>
                                            <?=$user['events_count']?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?=$user['balls_count'] ? $user['balls_count'] : 0 ?></td>
                                    <td><?=$user['zelfi_count'] ? $user['zelfi_count'] : 0 ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button data-user-id="<?=$user['id']?>" data-user-name="<?=$user['first_name']?> <?=$user['last_name']?>" data-event-id="<?=$event['id']?>" data-toggle="modal" data-target="#modalRemove" type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Город</th>
                                <th>E-mail</th>
                                <th>Телефон</th>
                                <th>Дети</th>
                                <th>Мероприятий</th>
                                <th>Баллов</th>
                                <th>Зелфи</th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                        <div class="box-footer">
                            <div class="btn-group pull-right">
                                <a href="/private/events/members/<?=$event['id']?>/export/excel" class="btn btn-success">Excel таблица</a>
                                <a href="/private/events/members/<?=$event['id']?>/new" class="btn btn-success">Добавить участника</a>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
