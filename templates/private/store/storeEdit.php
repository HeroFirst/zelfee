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

<form id="form-place-add" action="/private/store/edit" method="post" class="form-horizontal">
    <div class="row">
        <div class="col-md-9">

            <div class="form-group">
                <div class="col-md-12">
                    <input value="<?=$store_item['name']?>" type="text" class="form-control" name="name" placeholder="Название" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <textarea name="description" class="form-control textarea-summernote" rows="4" placeholder="Описание" required><?=$store_item['description']?></textarea>
                </div>
            </div>

        </div>
        <div class="col-md-3">

            <div class="box box-solid">
                <div class="box-body">

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Баллы:</label>
                            <input value="<?=$store_item['balls']?>" name="balls" type="number" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Рубли:</label>
                            <input value="<?=$store_item['price']?>" name="price" type="number" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Количество:</label>
                            <input min="0" step="1" value="<?=$store_item['count']?>" name="count" type="number" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Категория:</label>
                            <select name="category" class="form-control select2" data-placeholder="Категория" required>
                                <?php if ($store_categories) foreach ($store_categories as $index => $item): ?>
                                    <option <?=$store_item['category']==$item['id'] ? 'selected' : ''?> value="<?=$item['id']?>"><?=$item['name']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Город:</label>
                            <select name="city" class="form-control select2" required>
                                <option value="0" <?=$store_item['city']==0 ? 'selected' : ''?>>Все города</option>
                                <?php if ($AppCities) foreach ($AppCities->getCities() as $index => $item): ?>
                                    <div class="col-md-12">
                                        <option <?=$store_item['city']==$item['id'] ? 'selected' : ''?> value="<?=$item['id']?>"><?=$item['name']?></option>
                                    </div>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Обновить</button>
                </div>
            </div>

            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Обложка (1:1)</h3>
                </div>
                <div class="box-body">
                    <input value="<?=$store_item['cover']?>" name="cover" type="text" class="image-add-box" />
                </div>
            </div>

        </div>
    </div>

    <input type="hidden" value="<?=$store_item['id']?>" name="store_item_id">
</form>

<?php require_once  __DIR__.'/../footer.php' ?>
