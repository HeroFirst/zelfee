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

<form id="form-place-add" action="/private/news/edit" method="post" class="form-horizontal">

    <div class="row">
        <div class="col-md-9">
            <div class="form-group">
                <div class="col-md-12">
                    <input type="text" value="<?=$news_item['title']?>" class="form-control" name="title" id="title" placeholder="Название" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <textarea name="description_short" id="description_short" class="form-control" rows="3" placeholder="Короткое описание"><?=$news_item['description_short']?></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <textarea name="description" id="description" class="form-control textarea-summernote" rows="10" placeholder="Подробное описание"><?=$news_item['description']?></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">

                    <div class="row">

                        <div class="col-md-3">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Обложка</h3>
                                </div>
                                <div class="box-body">
                                    <input name="cover" value="<?=$news_item['cover']?>" id="cover" type="text" class="image-add-box" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Большая обложка</h3>
                                </div>
                                <div class="box-body">
                                    <input name="cover_big" value="<?=$news_item['cover_big']?>" id="cover_big" type="text" class="image-add-box" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Обложка соц. сетей</h3>
                                </div>
                                <div class="box-body">
                                    <input name="cover_social" value="<?=$news_item['cover_social']?>" id="cover_social" type="text" class="image-add-box" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-paper-plane"></i>

                    <h3 class="box-title">Публикация</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="form-group">
                        <div class="col-md-5">
                            <div class="bootstrap-timepicker">
                                <div class="input-group">
                                    <input value="<?=\Zelfi\Utils\DateHelper::getTimeFromDateTime($news_item['date_publish'])?>" name="time_publication" type="text" class="form-control timepicker">

                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="input-group date">
                                <input value="<?=\Zelfi\Utils\DateHelper::getDateFromDateTIme($news_item['date_publish'])?>" name="date_publication" type="text" class="form-control" id="datepicker">

                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">
                            <input type="checkbox" name="is_hot" id="is_hot" class="minimal" <?=$news_item['is_hot'] ? 'checked' : ''?> >
                            Пометить "горячей"
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">
                            <input type="checkbox" name="is_top" id="is_top" class="minimal" <?=$paper['is_top'] ? 'checked' : ''?>>
                            В слайдер
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">
                            <input type="checkbox" name="is_draft" id="is_draft" class="minimal" <?=$news_item['is_draft'] ? 'checked' : ''?> >
                            Черновик
                        </label>
                    </div>

                </div>

                <div class="box-footer">
                    <?php if (!$news_item['active']): ?>
                        <button type="submit" form="restoreForm" class="btn btn-success pull-left">Восстановить</button>
                    <?php else: ?>
                        <button type="submit" form="deleteForm" class="btn btn-danger pull-left">Удалить</button>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Город</h3>
                        </div>
                        <div class="box-body">
                            <select name="city[]" class="form-control select2" multiple="multiple" data-placeholder="Все города">
                                <?php if ($AppCities) foreach ($AppCities->getCities() as $index => $item): ?>
                                    <div class="col-md-12">
                                        <option
                                            <?php foreach ($news_item['cities'] as $news_item_city) {
                                                if ($news_item_city == $item['id']) {
                                                    echo 'selected';
                                                    break;
                                                }
                                            } ?>
                                            value="<?=$item['id']?>"><?=$item['name']?></option>
                                    </div>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Тип</h3>
                        </div>
                        <div class="box-body">
                            <select name="type" class="form-control select2" data-placeholder="Тип" required>
                                <?php if ($news_types) foreach ($news_types as $index => $item): ?>
                                    <option <?=$item['id'] == $news_item['type'] ? 'selected': ''?> value="<?=$item['id']?>"><?=$item['name']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <input name="news_item_id" value="<?=$news_item['id']?>" type="hidden" />
</form>
<form id="deleteForm" action="/private/news/delete" method="post">
    <input name="news_item_id" value="<?=$news_item['id']?>" type="hidden" />
</form>
<form id="restoreForm" action="/private/news/restore" method="post">
    <input name="news_item_id" value="<?=$news_item['id']?>" type="hidden" />
</form>

<?php require_once  __DIR__.'/../footer.php' ?>
