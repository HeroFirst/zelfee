<?php
/**
 *
 */

?>
<div class="modal zf-modal fade" id="modalAvatarChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                <h4 class="modal-title" id="myModalLabel">Изменение аватара</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button href="#" id="openDialogImage" class="button button-pink">Выбрать изображение</button>
                    </div>
                </div>
                <div class="row">
                    <input style="display: none;" type='file' id="imageInput" />
                    <img style="max-width: 100%;" id="image" src="" />
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button id="saveImage" style="display: none;" class="button button-pink margin-top-40">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal zf-modal zf-modal-wide fade" id="modalVideoAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                <h4 class="modal-title" id="myModalLabel">Добавить видео</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="formVideoAdd" action="/users/balls/videos/new" method="post" class="form-horizontal">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type='text' class="form-control" id="title" placeholder="Название" name="title" required />
                                </div>
                            </div>

                            <div class="form-group margin-top-20">
                                <div class="col-md-12">
                                    <input type='url' class="form-control" id="url" placeholder="http://ссылка" name="url" required />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button form="formVideoAdd" type="submit" id="addVideo" class="button button-pink button-fixed-width margin-top-40">Добавить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal zf-modal zf-modal-wide fade" id="modalBalls" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                <h4 class="modal-title" id="myModalLabel">История полученных баллов</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" style="height: 300px;overflow-y: auto;">
                        <?php for ($i=0;$i<count($balls_history); $i++): ?>
                            <div class="row info-item">
                                <div class="col-xs-3">
                                    <div class="info-label"><?=\Zelfi\Utils\DateHelper::getDateFromDateTIme($balls_history[$i]['date_created'])?></div>
                                </div>
                                <div class="col-xs-9">
                                    <div class="info-labeled">
                                        <span class="info-text"><?=$balls_history[$i]['type_name']?><span class="info-balls">+<?=$balls_history[$i]['balls']?></span></span>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button data-dismiss="modal" type="button" class="button button-pink button-fixed-width margin-top-40">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>