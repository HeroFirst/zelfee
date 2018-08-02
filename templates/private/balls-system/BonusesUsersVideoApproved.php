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
                <li><a href="/private/balls-system/bonuses/users-video/new">Новые</a></li>
                <li class="active"><a href="/private/balls-system/bonuses/users-video/approved">Проверенные</a></li>
            </ul>

            <div class="tab-content">
                <table class="table table-bordered table-striped data-table-full">
                    <thead>
                    <tr>
                        <th>Пользователь</th>
                        <th>Город</th>
                        <th>Название видео</th>
                        <th>Ссылка</th>
                        <th>Дата публикации</th>
                        <th>Утвердил</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($videos) foreach ($videos as $index => $video): ?>
                        <tr>
                            <td><a href="/private/balls-system/users/edit/<?=$video['user']['id']?>"><?=$video['user']['first_name'].' '.$video['user']['last_name']?></a></td>
                            <td><?=$AppCities->getCityById($video['user']['residence'])['name']?></td>
                            <td><?=$video['name']?></td>
                            <td><a href="<?=$video['url']?>" target="_blank"><?=$video['url']?></a></td>
                            <td><?=\Zelfi\Utils\DateHelper::getDateFromDateTIme($video['date_created'])?></td>
                            <td><?=$video['user_approved']['first_name'].' '.$video['user_approved']['last_name']?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Пользователь</th>
                        <th>Город</th>
                        <th>Название видео</th>
                        <th>Ссылка</th>
                        <th>Дата публикации</th>
                        <th>Утвердил</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
