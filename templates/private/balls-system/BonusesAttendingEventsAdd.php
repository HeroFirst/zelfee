<?php require_once __DIR__.'/../header.php' ?>
<?php
/* @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *  @var \Zelfi\Model\ZFCities $AppCities
 */
if ($AppRendererHelper != null){
    $FooterScripts = $AppRendererHelper->getFooterScripts();
    $FooterData = $AppRendererHelper->getFooterData();
}

?>

<form id="form-bonuse-add" action="/private/balls-system/bonuses/attending-events/add" method="post" class="form-horizontal">
    <div class="form-group">
        <div class="col-md-8">
            <input type="text" class="form-control" name="name" placeholder="Название" required>
        </div>

        <div class="col-md-4">
            <input type="number" class="form-control" name="events_count" placeholder="Количество мероприятий" required>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary pull-right">Добавить</button>
        </div>
    </div>

</form>

<?php require_once  __DIR__.'/../footer.php' ?>
