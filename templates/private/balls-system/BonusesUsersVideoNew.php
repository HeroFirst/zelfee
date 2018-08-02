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
                <li class="active"><a href="/private/balls-system/bonuses/users-video/new">Новые</a></li>
                <li><a href="/private/balls-system/bonuses/users-video/approved">Проверенные</a></li>
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
                        <th></th>
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
                            <td class="text-center">
                                <div class="btn-group">
                                    <button data-user-id="<?=$video['user']['id']?>" data-user-video-name="<?=$video['name']?>" data-user-video-id="<?=$video['id']?>" data-toggle="modal" data-target="#modalApprove" type="button" class="btn btn-warning"><i class="fa fa-check"></i></button>
                                    <button data-user-id="<?=$video['user']['id']?>" data-user-video-name="<?=$video['name']?>" data-user-video-id="<?=$video['id']?>" data-toggle="modal" data-target="#modalRemove" type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button>
                                </div>
                            </td>
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
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
