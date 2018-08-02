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
                <li class="active"><a>Все</a></li>
            </ul>

            <div class="tab-content">
                <table class="table table-bordered table-striped data-table-full">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Город</th>
                        <th>Баллов</th>
                        <th>Зелфи</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($users) foreach ($users as $index => $user): ?>
                        <tr>
                            <td><?=$user['id']?></td>
                            <td><a href="/private/balls-system/users/edit/<?=$user['id']?>"><?=$user['first_name']?> <?=$user['last_name']?></a></td>
                            <td><?=$AppCities->getCityById($user['residence'])['name']?></td>
                            <td><?=$user['balls_count'] ? $user['balls_count'] : 0 ?></td>
                            <td><?=$user['zelfi_count'] ? $user['zelfi_count'] : 0 ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Город</th>
                        <th>Баллов</th>
                        <th>Зелфи</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
