<?php
/* @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *  @var \Zelfi\Model\ZFCities $AppCities
 */

if ($AppRendererHelper != null){
    $FooterScripts = $AppRendererHelper->getFooterScripts();
    $FooterData = $AppRendererHelper->getFooterData();
}

require_once __DIR__.'/../header.php'
?>

<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="/private/users/all">Все</a></li>
                <li><a href="/private/users/disabled">Отключенные</a></li>
            </ul>

            <div class="tab-content">
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
                        <th>RFIDID</th>
                        <th>Тип</th>
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
                            <td><?=$user['rfidid']?></td>
                            <td><?=$user['role_name']?></td>
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
                        <th>RFIDID</th>
                        <th>Тип</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
