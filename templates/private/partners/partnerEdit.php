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

<form id="form-place-add" action="/private/partners/edit" method="post" class="form-horizontal">
    <div class="row">
        <div class="col-md-9">

            <div class="form-group">
                <div class="col-md-12">
                    <input value="<?=$partner['title']?>" type="text" class="form-control" name="title" placeholder="Название" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <textarea name="description" class="form-control textarea-summernote" rows="4" placeholder="Описание" required><?=$partner['description']?> </textarea>
                </div>
            </div>

        </div>
        <div class="col-md-3">

            <div class="box box-solid">
                <div class="box-body">

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Ссылка:</label>
                            <input value="<?=$partner['url']?>" name="url" type="text" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Тип:</label>
                            <select name="type" class="form-control select2" data-placeholder="Тип">
                                <?php if ($partners_types) foreach ($partners_types as $index => $item): ?>
                                    <option <?=($partner['type'] == $item['id']) ? 'selected' : '' ?> value="<?=$item['id']?>"><?=$item['name']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Город:</label>
                            <select name="city" class="form-control select2" required>
                                <option value="0" <?=($partner['city'] == 0) ? 'selected' : '' ?>>Все города</option>
                                <?php if ($AppCities) foreach ($AppCities->getCities() as $index => $item): ?>
                                    <div class="col-md-12">
                                        <option <?=($partner['city'] == $item['id']) ? 'selected' : '' ?> value="<?=$item['id']?>"><?=$item['name']?></option>
                                    </div>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">
                            <input type="checkbox" id="is_main" name="is_main" class="minimal" <?=$partner['is_main'] ? 'checked' : ''?>>
                            На главную
                        </label>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="box-footer">
                        <button type="submit" form="deleteForm" class="btn btn-danger pull-left">Удалить</button>
                        <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
                    </div>
                </div>
            </div>

            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Обложка (1:1)</h3>
                </div>
                <div class="box-body">
                    <input value="<?=$partner['cover']?>" name="cover" type="text" class="image-add-box" />
                </div>
            </div>

        </div>
    </div>

    <input type="hidden" value="<?=$partner['id']?>" name="partner_id">
</form>
<form id="deleteForm" action="/private/partners/delete" method="post">
    <input type="hidden" value="<?=$partner['id']?>" name="partner_id">
</form>


<?php require_once  __DIR__.'/../footer.php' ?>
