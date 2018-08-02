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

<form id="form-place-add" action="/private/places/edit" method="post" class="form-horizontal">
    <div class="form-group">
        <div class="col-md-12">
            <input value="<?=$place['name']?>" type="text" class="form-control" name="title" placeholder="Название" required>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <textarea name="description_short" class="form-control" rows="3" placeholder="Короткое описание"><?=$place['description_short']?></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <textarea name="description" class="form-control textarea-summernote" rows="10" placeholder="Подробное описание"><?=$place['description']?></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-4">
            <select name="city" class="form-control" required>
                <?php if ($AppCities) foreach ($AppCities->getCities() as $index => $item): ?>
                    <option <?=($place['city'] == $item['id']) ? 'selected' : '' ?> value="<?=$item['id']?>"><?=$item['name']?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <input value="<?=$place['cover']?>" name="cover" type="text" class="image-add-box" />
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" form="deleteForm" class="btn btn-danger pull-left">Удалить</button>
            <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
        </div>
    </div>

    <input type="hidden" value="<?=$place['id']?>" name="place_id">


</form>
<form id="deleteForm" action="/private/places/delete" method="post">
    <input type="hidden" value="<?=$place['id']?>" name="place_id">
</form>

<?php require_once  __DIR__.'/../footer.php' ?>
