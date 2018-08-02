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

<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-info"></i> Внимание!</h4>
   Для главной галереи необходимо минимум <b>6</b> изображений
</div>


<form id="form-place-add" action="/private/galleries/new" method="post" class="form-horizontal">

    <div class="row">
        <div class="col-md-8">
            <div class="row">

                <div class="images-container">

                </div>


            </div>
        </div>

        <div class="col-md-4">

            <div class="box box-solid">
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Название" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <textarea name="description" class="form-control textarea-summernote" rows="4" placeholder="Описание" required></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <select name="city" class="form-control" required>
                                <option selected value="0">Все города</option>
                                <?php if ($AppCities) foreach ($AppCities->getCities() as $index => $item): ?>
                                    <div class="col-md-12">
                                        <option value="<?=$item['id']?>"><?=$item['name']?></option>
                                    </div>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">
                            <input type="checkbox" id="is_main" name="is_main" class="minimal">
                            Главная
                        </label>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Добавить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<?php require_once  __DIR__.'/../footer.php' ?>
