<?php
/* @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *  @var \Zelfi\Model\ZFCities $AppCities
 */

if ($AppRendererHelper != null){
    $FooterScripts = $AppRendererHelper->getFooterScripts();
    $FooterData = $AppRendererHelper->getFooterData();
}

$AppRendererHelper->setHeaderTitle(null, $user['first_name'].' '.$user['last_name']);

require_once __DIR__.'/../header.php'
?>

<div class="row">
    <?php if ($balls_seasons) foreach ($balls_seasons as $index => $balls): ?>
        <div class="col-md-4">
            <div class="box">
                <div class="box-body">
                    <form class="form-horizontal" action="/private/balls-system/users/edit" method="post">
                        <div class="box-header">
                            <h3 class="box-title">
                                <?=$balls['season_name']?>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="balls" class="col-sm-2 control-label">Баллы</label>

                                <div class="col-sm-10">
                                    <input value="<?=$balls['balls']?>" type="number" class="form-control" name="balls" id="balls" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="zelfi" class="col-sm-2 control-label">Зелфи</label>

                                <div class="col-sm-10">
                                    <input value="<?=$balls['zelfi']?>" type="number" class="form-control" name="zelfi" id="zelfi" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <input type="hidden" name="user_id" value="<?=$user['id']?>">
                            <input type="hidden" name="season" value="<?=$balls['season']?>">
                            <button type="submit" class="btn btn-success pull-right">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php ?>
    <?php ?>
    <?php ?>
    <?php ?>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">История баллов</h3>
            </div>
            <div class="box-body">
                <table data-order='[[ 5, "desc" ]]' class="table table-bordered table-striped data-table-full">
                    <thead>
                    <tr>
                        <th>Баллы</th>
                        <th>Зелфи</th>
                        <th>Описание</th>
                        <th>Тип</th>
                        <th>Сезон</th>
                        <th>Дата</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($balls_history) foreach ($balls_history as $index => $balls_row): ?>
                        <tr>
                            <td><?=$balls_row['balls'] ?></td>
                            <td><?=$balls_row['zelfi'] ?></td>
                            <td><?=$balls_row['description'] ?></td>
                            <td><?=$balls_row['type_name'] ?></td>
                            <td><?=$balls_row['season_name'] ?></td>
                            <td><?=$balls_row['date_created'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Баллы</th>
                        <th>Зелфи</th>
                        <th>Описание</th>
                        <th>Тип</th>
                        <th>Сезон</th>
                        <th>Дата</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
