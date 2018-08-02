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

<form id="form-place-add" action="/private/places/new" method="post" class="form-horizontal">
    <div class="form-group">
        <div class="col-md-12">
            <input type="text" class="form-control" name="title" placeholder="Название" required>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <textarea name="description_short" class="form-control" rows="3" placeholder="Короткое описание"></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <textarea name="description" class="form-control textarea-summernote" rows="10" placeholder="Подробное описание"></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-4">
            <select name="city" class="form-control" required>
                <option value="" disabled selected>Выберите город</option>
                <?php if ($AppCities) foreach ($AppCities->getCities() as $index => $item): ?>
                    <div class="col-md-12">
                        <option value="<?=$item['id']?>"><?=$item['name']?></option>
                    </div>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <input name="cover" type="text" class="image-add-box" />
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary pull-right">Добавить</button>
        </div>
    </div>

</form>

<?php require_once  __DIR__.'/../footer.php' ?>
