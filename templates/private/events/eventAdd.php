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
<?php require_once __DIR__.'/../header.php' ?>

<form id="form-place-add" action="/private/events/new" method="post" class="form-horizontal">
    <div class="row">
        <div class="col-md-9">

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
                <div class="col-md-12">

                    <div class="row">

                        <div class="col-md-3">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Обложка</h3>
                                </div>
                                <div class="box-body">
                                    <input name="cover" id="cover" type="text" class="image-add-box" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Большая обложка</h3>
                                </div>
                                <div class="box-body">
                                    <input name="cover_big" id="cover_big" type="text" class="image-add-box" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Обложка соц. сетей</h3>
                                </div>
                                <div class="box-body">
                                    <input name="cover_social" id="cover_social" type="text" class="image-add-box" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-md-3">

            <div class="box box-solid">
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Время начала:</label>
                            <div class="bootstrap-timepicker">
                                <div class="input-group">
                                    <input name="time" type="text" class="form-control timepicker">

                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Время окончания:</label>
                            <div class="bootstrap-timepicker">
                                <div class="input-group">
                                    <input name="time_end" type="text" class="form-control timepicker">

                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Дата:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input value="<?=\Zelfi\Utils\DateHelper::getEnDate()?>" name="date" type="text" class="form-control pull-right" id="datepicker">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Тип:</label>
                            <select name="type" class="form-control select2" data-placeholder="Тип">
                                <option>Без типа</option>
                                <?php if ($events_types) foreach ($events_types as $index => $item): ?>
                                    <option value="<?=$item['id']?>"><?=$item['name']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Город проведения:</label>
                            <select id="city" name="city" class="form-control select2" data-placeholder="Выберите город проведения">
                                <?php if ($AppCities) foreach ($AppCities->getCities() as $index => $item): ?>
                                    <div class="col-md-12">
                                        <option value="<?=$item['id']?>"><?=$item['name']?></option>
                                    </div>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Место проведения:</label>
                            <select name="places[]" class="form-control select2-dynamic" multiple="multiple" data-placeholder="Выберите места проведения">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Количество баллов:</label>
                            <input name="balls" type="number" value="0" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Категория:</label>
                            <select name="category" class="form-control select2" data-placeholder="Категория">
                                <?php if ($events_categories) foreach ($events_categories as $index => $item): ?>
                                    <option value="<?=$item['id']?>"><?=$item['name']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Галерея:</label>
                            <select name="gallery" class="form-control select2" data-placeholder="Галерея">
                                <option selected>Нет</option>
                                <?php if ($galleries) foreach ($galleries as $index => $item): ?>
                                    <option value="<?=$item['id']?>"><?=$item['name']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">
                            <input type="checkbox" id="subscribe" name="subscribe" class="minimal" checked>
                            Можно подписываться
                        </label>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Добавить</button>
                </div>
            </div>

        </div>
    </div>

</form>

<?php require_once  __DIR__.'/../footer.php' ?>
