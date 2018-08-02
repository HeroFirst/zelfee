<?php
/* @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *  @var \Zelfi\Model\ZFCities $AppCities
 */
if ($AppRendererHelper != null){
    $FooterScripts = $AppRendererHelper->getFooterScripts();
    $FooterData = $AppRendererHelper->getFooterData();
}

$AppRendererHelper->setHeaderTitle('Участники мероприятия', 'Добавить нового');
?>
<?php require_once __DIR__.'/../header.php' ?>

<form id="form-place-add" action="/private/events/members/new" method="post" class="form-horizontal">

    <div class="box">
        <div class="box-body">
            <div class="col-md-4">
                <select name="place_id" class="form-control" required>
                    <option value="" disabled selected>Выберите место</option>
                    <?php if ($places) foreach ($places as $index => $item): ?>
                        <div class="col-md-12">
                            <option value="<?=$item['id']?>"><?=$item['name']?></option>
                        </div>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <input type="text" class="form-control" name="user_id" placeholder="ID пользователя" required>
            </div>
        </div>
        <div class="box-footer">
            <input type="hidden" name="event_id" value="<?=$event['id']?>">
            <button type="submit" class="btn btn-primary pull-right">Добавить</button>
        </div>
    </div>

</form>

<?php require_once  __DIR__.'/../footer.php' ?>
