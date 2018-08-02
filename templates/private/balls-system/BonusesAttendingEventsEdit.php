<?php
/* @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *  @var \Zelfi\Model\ZFCities $AppCities
 */
if ($AppRendererHelper != null){
    $FooterScripts = $AppRendererHelper->getFooterScripts();
    $FooterData = $AppRendererHelper->getFooterData();

    $AppRendererHelper->setHeaderTitle($bonus['name']);
}
?>

<?php require_once __DIR__.'/../header.php' ?>

<form id="form-bonus-edit" action="/private/balls-system/bonuses/attending-events/edit" method="post" class="form-horizontal">
    <div class="form-group">
        <div class="col-md-8">
            <input value="<?=$bonus['name']?>" type="text" class="form-control" name="name" placeholder="Название" required>
        </div>

        <div class="col-md-4">
            <input value="<?=$bonus['events_count']?>" type="number" class="form-control" name="events_count" placeholder="Количество мероприятий" required>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <button form="form-bonus-delete" type="submit" class="btn btn-danger pull-left">Удалить</button>
            <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
        </div>
    </div>

    <input type="hidden" value="<?=$bonus['id']?>" name="bonus_id">
</form>
<form id="form-bonus-delete" action="/private/balls-system/bonuses/attending-events/remove" method="post" class="form-horizontal">
    <input type="hidden" value="<?=$bonus['id']?>" name="bonus_id">
</form>

<?php require_once  __DIR__.'/../footer.php' ?>
