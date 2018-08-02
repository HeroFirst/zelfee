<?php
/**
 * @var \Zelfi\Model\ZFUser $AppUser
 * @var \Zelfi\Model\ZFUser $AppUser
 * @var \Zelfi\Model\ZFCities $AppCities
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 *
 */

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Starter</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php require_once __DIR__.'/../header_styles.php' ?>
    <?php require_once __DIR__.'/../header_scripts.php' ?>

</head>
<body class="page-service-authorize status-<?=!is_null($user) ? ($user['surprize'] ? 'warning' : 'success') : 'fail'?>">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="title">
                <p><?=!is_null($user) ? ($user['surprize'] ? $user['surprize'] : ($finished_already ? 'Уже зарегистрирован' : 'Зарегистрирован')) : 'Пользователь не найден'?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php if (!is_null($user)){ ?>
                <div class="user-info text-center">
                    <div class="avatar" style="background-image: url(<?=$user['photo']?>)"></div>
                    <p class="name"><?=$user['first_name']?> <?=$user['last_name']?></p>
                    <p class="id">id <?=sprintf('%06d', $user['id']) ?></p>
                    <div class="grid-values">
                        <div class="grid-values-item">
                            <span class="grid-values-item-value"><?=$user['balls_all']['balls'] ? $user['balls_all']['balls'] : 0 ?></span>
                            <span class="grid-values-item-name">Баллов</span>
                        </div>

                        <div class="grid-values-item">
                            <span class="grid-values-item-value"><?=$user['balls_all']['zelfi'] ? $user['balls_all']['zelfi'] : 0 ?></span>
                            <span class="grid-values-item-name">Зелфи</span>
                        </div>

                        <div class="grid-values-item">
                            <span class="grid-values-item-value"><?=$user['events_count'] ? $user['events_count'] : 0 ?></span>
                            <span class="grid-values-item-name">Мероприятий</span>
                        </div>
                        <div class="grid-values-item">
                            <span class="grid-values-item-value"><?=$user['point_team'] ? $user['point_team'] : 0 ?></span>
                            <span class="grid-values-item-name">Командный балл</span>
                        </div>
                    </div>
                    <a target="_blank" class="history button-border-white" href="/private/users/events/<?=$user['id']?>">История мероприятий</a>
                </div>
            <?php } else { ?>
                <div class="user-info text-center">
                    <a target="_blank" class="button-border-white" href="/private/users/all?rfidid=<?=$rfidid?>">Найти пользователя</a>
                    <a target="_blank" class="button-border-white" href="/private/users/new?rfidid=<?=$rfidid?>">Добавить пользователя</a>
                </div>
            <?php } ?>
        </div>

        <div class="col-md-6">
            <div class="event-info text-center">
                <div class="cover" style="background-image: url(<?=$event['cover']?>)"></div>
                <p class="event-name"><?=$event['title']?></p>
                <p class="place-name"><?=$place['name']?></p>
                <div class="grid-values">
                    <div class="grid-values-item">
                        <span class="grid-values-item-value"><?=\Zelfi\Utils\DateHelper::getDateFromDateTIme($event['date_start'])?></span>
                        <span class="grid-values-item-name">Дата</span>
                    </div>

                    <div class="grid-values-item">
                        <span class="grid-values-item-value"><?=\Zelfi\Utils\DateHelper::getTimeFromDateTime($event['date_start'])?></span>
                        <span class="grid-values-item-name">Время</span>
                    </div>

                    <div class="grid-values-item">
                        <span class="grid-values-item-value"><?=$event['balls']?></span>
                        <span class="grid-values-item-name">Баллов</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if ($FooterData != null)
    foreach ($FooterData as $data):
        require_once '/data/'.$data.'.php';
    endforeach; ?>

<script src="/assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="/assets/plugins/jQueryUI/jquery-ui.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/adminlte/js/app.min.js"></script>
<script src='/assets/plugins/elfinder/js/elfinder.min.js'></script>
<script src='/assets/plugins/summernote/summernote.min.js'></script>
<script src="/assets/plugins/summernote/plugin/summernote-ext-elfinder/summernote-ext-elfinder.js"></script>
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="/assets/plugins/select2/select2.full.min.js"></script>
<script src="/assets/plugins/iCheck/icheck.min.js"></script>
<?php
if ($FooterScripts != null)
    foreach ($FooterScripts as $script):?>
        <script src="/assets/js/<?=$script?>.js"></script>
    <?php endforeach; ?>

</body>
</html>
