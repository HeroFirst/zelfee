<?php require_once __DIR__ . '/../header.php' ?>

<?php
/**
 * @var \Zelfi\Model\ZFUser $AppUser
 * @var \Zelfi\Model\ZFCities $AppCities
 *
 */

?>

<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <a class="pull-right" href="/private/balls-system/bonuses/attending-events/add" class="text-blue">Добавить бонус</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped data-table-full">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Количество необходимых мероприятий</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($events_suprizes) foreach ($events_suprizes as $index => $events_suprize): ?>
                        <tr>
                            <td><a href="/private/balls-system/bonuses/attending-events/edit/<?=$events_suprize['id'] ?>"><?=$events_suprize['name'] ?></a></td>
                            <td><?=$events_suprize['events_count'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Название</th>
                        <th>Количество необходимых мероприятий</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
