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

if ($gallery && $gallery['images']){
    $gallery['images'] = unserialize($gallery['images']);
}

?>

<form id="form-gallery-add" action="/private/galleries/edit" method="post" class="form-horizontal">

    <div class="row">
        <div class="col-md-8">
            <div class="row">

                <div class="images-container">
                    <?php if ($gallery['images']) foreach ($gallery['images'] as $image): ?>
                        <input value="<?=$image?>" name="image[]" type="text" class="image-add-box" />
                    <?php endforeach; ?>
                </div>


            </div>
        </div>

        <div class="col-md-4">

            <div class="box box-solid">
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input value="<?=$gallery['name']?>" type="text" class="form-control" name="name" id="name" placeholder="Название" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <textarea name="description" class="form-control textarea-summernote" rows="4" placeholder="Описание" required><?=$gallery['description']?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <select name="city" class="form-control" required>
                                <option <?=($gallery['city'] == 0) ? 'selected' : '' ?> value="0">Все города</option>
                                <?php if ($AppCities) foreach ($AppCities->getCities() as $index => $item): ?>
                                    <div class="col-md-12">
                                        <option <?=($gallery['city'] == $item['id']) ? 'selected' : '' ?> value="<?=$item['id']?>"><?=$item['name']?></option>
                                    </div>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">
                            <input type="checkbox" id="is_main" name="is_main" class="minimal" <?=$gallery['is_main'] ? 'checked' : ''?>>
                            Главная
                        </label>
                    </div>

                    <div class="box-footer">
                        <button form="form-gallery-remove" type="submit" class="btn btn-danger pull-left">Удалить</button>
                        <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" value="<?=$gallery['id']?>" name="gallery_id">
</form>
<form id="form-gallery-remove" action="/private/galleries/delete" method="post" class="form-horizontal">
    <input type="hidden" value="<?=$gallery['id']?>" name="gallery_id">
</form>

<?php require_once  __DIR__.'/../footer.php' ?>
