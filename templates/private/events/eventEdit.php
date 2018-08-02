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

<form id="form-place-edit" action="/private/events/edit" method="post" class="form-horizontal">
    <div class="row">
        <div class="col-md-9">

            <div class="form-group">
                <div class="col-md-12">
                    <input value="<?=$event['title']?>" type="text" class="form-control" name="title" placeholder="Название" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <textarea name="description_short" class="form-control" rows="3" placeholder="Короткое описание"><?=$event['description_short']?></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <textarea name="description" class="form-control textarea-summernote" rows="10" placeholder="Подробное описание"><?=$event['description']?></textarea>
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
                                    <input name="cover" value="<?=$event['cover']?>" id="cover" type="text" class="image-add-box" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Большая обложка</h3>
                                </div>
                                <div class="box-body">
                                    <input name="cover_big" value="<?=$event['cover_big']?>" id="cover_big" type="text" class="image-add-box" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Обложка соц. сетей</h3>
                                </div>
                                <div class="box-body">
                                    <input name="cover_social" value="<?=$event['cover_social']?>" id="cover_social" type="text" class="image-add-box" />
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
                                    <input value="<?=\Zelfi\Utils\DateHelper::getTimeFromDateTime($event['date_start'])?>" name="time" type="text" class="form-control timepicker">

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
                                    <input value="<?=\Zelfi\Utils\DateHelper::getTimeFromDateTime($event['date_end'])?>" name="time_end" type="text" class="form-control timepicker">

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
                                <input value="<?=\Zelfi\Utils\DateHelper::getDateFromDateTIme($event['date_start'], 'Y-m-d')?>" name="date" type="text" class="form-control pull-right" id="datepicker">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Тип:</label>
                            <select name="type" class="form-control select2" data-placeholder="Тип">
                                <option>Без типа</option>
                                <?php if ($events_types) foreach ($events_types as $index => $item): ?>
                                    <option <?=$item['id'] == $event['type'] ? 'selected': ''?> value="<?=$item['id']?>"><?=$item['name']?></option>
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
                                        <option <?=($event['city'] == $item['id']) ? 'selected' : '' ?> value="<?=$item['id']?>"><?=$item['name']?></option>
                                    </div>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Место проведения:</label>
                            <select name="places[]" class="form-control select2-dynamic" multiple="multiple" data-placeholder="Выберите места проведения">
                                <?php if ($places) foreach ($places as $index => $item): ?>
                                    <?php if ($event['places']) foreach ($event['places'] as $event_place) {
                                        if ($event_place == $item['id'] && $item['city'] == $event['city']) { ?>
                                            <option value="<?=$item['id']?>" selected="selected"><?=$item['name']?></option>
                                            <?php break;
                                        }
                                    } ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Количество баллов:</label>
                            <input name="balls" type="number" value="<?=$event['balls']?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Категория:</label>
                            <select name="category" class="form-control select2" data-placeholder="Категория">
                                <?php if ($events_categories) foreach ($events_categories as $index => $item): ?>
                                    <option <?=$item['id'] == $event['category'] ? 'selected': ''?> value="<?=$item['id']?>"><?=$item['name']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Галерея:</label>
                            <select name="gallery" class="form-control select2" data-placeholder="Галерея">
                                <option <?=$event['gallery_id'] ? '' : 'selected'?>>Нет</option>
                                <?php if ($galleries) foreach ($galleries as $index => $item): ?>
                                    <option <?= $event['gallery_id'] == $item['id'] ? 'selected' : ''?> value="<?=$item['id']?>"><?=$item['name']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">
                            <input type="checkbox" id="subscribe" name="subscribe" class="minimal" <?=$event['subscribe'] ? 'checked' : ''?>>
                            Можно подписываться
                        </label>
                    </div>
                </div>
                <div class="box-footer">
                    <?php if (!$event['active']): ?>
                        <button type="submit" form="restoreForm" class="btn btn-success pull-left">Восстановить</button>
                    <?php else: ?>
                        <button type="submit" form="deleteForm" class="btn btn-danger pull-left">Удалить</button>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
                </div>
            </div>

        </div>
    </div>

    <input type="hidden" value="<?=$event['id']?>" name="event_id">

</form>
    <form id="deleteForm" action="/private/events/delete" method="post">
        <input type="hidden" value="<?=$event['id']?>" name="event_id">
    </form>
    <form id="restoreForm" action="/private/events/restore" method="post">
        <input type="hidden" name="event_id" value="<?=$event['id']?>">
    </form>


<?php require_once  __DIR__.'/../footer.php' ?>