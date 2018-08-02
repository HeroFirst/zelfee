<?php
/**
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *
 */

include 'header-simple.php'; ?>

        <div class="page-content">
            <div class="container">

                <div class="row">
                    <div class="col-xs-12">
                        <div class="cover" style="background: url(<?=($event['cover_big']!='' ? $event['cover_big'] : $event['cover'])?>)">
                            <div class="overlay"></div>

                            <span class="balls-count"><?=$event['balls']?> баллов</span>

                            <?php if ($event['type'] ):?>
                                <span class="icon-category icon-category-<?=$event['type_icon']?>"></span>
                            <?php endif; ?>

                            <div class="zf-social-buttons-container">
                                <div class='zf-social-button zf-social-button-vk share s_vk'>
                                    <div class='counter c_vk'>0</div>
                                    <div class='icon'>
                                        <img />
                                    </div>
                                </div>

                                <div class='zf-social-button zf-social-button-fb share s_facebook'>
                                    <div class='counter c_facebook'>0</div>
                                    <div class='icon'>
                                        <img />
                                    </div>
                                </div>

                                <div class='zf-social-button zf-social-button-ok share s_odnoklassniki'>
                                    <div class='counter c_odnoklassniki'>0</div>
                                    <div class='icon'>
                                        <img />
                                    </div>
                                </div>

                                <div class='zf-social-button zf-social-button-mailru share s_myworld'>
                                    <div class='counter c_myworld'>0</div>
                                    <div class='icon'>
                                        <img />
                                    </div>
                                </div>

                                <div class='zf-social-button zf-social-button-gplus share s_plus'>
                                    <div class='counter c_plus'>0</div>
                                    <div class='icon'>
                                        <img />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="event-info margin-top-10">
                            <div class="item">
                                Дата: <span><?=\Zelfi\Utils\DateHelper::getDateFromDateTIme($event['date_start'])?></span>
                            </div>

                            <div class="item">
                                Время: <span><?=\Zelfi\Utils\DateHelper::getTimeFromDateTime($event['date_start'])?> - <?=\Zelfi\Utils\DateHelper::getTimeFromDateTime($event['date_end'])?></span>
                            </div>

                            <div class="item">
                                Место проведения: <span>
                                    <?php foreach ($event['places'] as $index => $place) {
                                        echo ($index > 0 ? ', ' : '').$place['name'];
                                    }?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($AppUser->getRole()<5 ):?>
                    <div class="admin-action margin-top-10">
                        <div class="col-zs-12">
                            <div class="item">
                                <a href="/private/events/edit/<?=$event['id']?>" class="button-to-private">Редактировать</a>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>

                <div class="row margin-top-40">
                    <div class="col-xs-9">
                        <h1 class="event-title">
                            <?=$event['title']?>
                        </h1>
                    </div>
<?php if ($event['date_end']>=date("Y-m-d")): ?>
                    <div class="col-xs-3">
                        <?php if ($AppUser->getRole()<6): ?>
                            <form action="/events/unsubscribe" method="post">
                                <input type="hidden" value="<?=$event['id']?>" name="event_id">
                                <?php if ($event['subscribe']){
                                    if ($event['isSubscribed']){ ?>
                                    <button type="submit" class="button button-pink-solid button-full-width event-action-button">Участвую</button>
                                <?php } else {?>
                                        <div class="button-event">
                                            <button type="button" data-toggle="modal" data-target="#modalPlaceSelect" class="button button-pink-solid button-full-width event-action-button">Участвовать</button>
                                            <div class="button-event-footer">
                                                +5 баллов за онлайн-регистрацию
                                            </div>
                                        </div>
                                <?php }
                                    } ?>

                                </form>
                        <?php else: ?>
                            <div class="button-event">
                                <button type="button" data-toggle="modal" data-target="#modalAuth" class="button button-pink-solid button-full-width event-action-button">Участвовать</button>
                                <div class="button-event-footer">
                                    +5 баллов за онлайн-регистрацию
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
<?php endif; ?>
                </div>

                <div class="row margin-top-40">
                    <div class="col-xs-9">
                        <?=$event['description']?>
                    </div>
                </div>

                <?php if ($event['gallery']): ?>

                    <div class="row margin-top-40">
                        <div class="col-xs-12">
                            <h1 class="event-subtitle">
                                Фотоотчет с мероприятия
                            </h1>
                        </div>
                    </div>

                    <div class="row margin-top-40">
                        <div class="col-xs-12">
                            <div class="event-slider">
                                <a class="control-left" href="#"></a>
                                <a class="control-right" href="#"></a>

                                <ul id="lightSlider">

                                    <?php
                                    $images = unserialize($event['gallery']['images']);
                                    if ($images) foreach ($images as $index =>$image):
                                    ?>

                                        <li>
                                            <a data-slide-to="<?=$index?>" href="#carousel-gallery" >
                                                <div class="square" data-toggle="modal" data-target="#modalGallery">
                                                    <div class="square-content">
                                                        <div class="content" style="background-image: url(<?= $image ?>);"></div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>

                                    <?php endforeach; ?>

                                </ul>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

                <div class="row margin-top-40 hide">
                    <div class="col-xs-12">
                        <div class="box-title">
                            <h1>Ближайшие мероприятия</h1>
                        </div>
                    </div>
                </div>

                <div class="row margin-top-40 materials-items hide">
                    <div class="material-item col-xs-3 item">
                        <div class="square">
                            <div class="square-content" style="background-image: url(/assets/images/hot_stuff_item.png);background-size: cover;">
                                <div class="body-bottom">
                                    <p class="title">
                                        Тренировочный полу-марафон по набережным города Казани
                                    </p>
                                    <div class="info">
                                        <span class="zf-icon zf-icon-calendar">17.11.16</span>
                                        <span class="zf-icon zf-icon-comment">10 комментариев</span>
                                    </div>
                                </div>

                                <div class="overlay"></div>
                            </div>
                        </div>
                    </div>

                    <div class="material-item col-xs-3 item">
                        <div class="square">
                            <div class="square-content" style="background-image: url(/assets/images/hot_stuff_item.png);background-size: cover;">
                                <div class="body-bottom">
                                    <p class="title">
                                        Тренировочный полу-марафон по набережным города Казани
                                    </p>
                                    <div class="info">
                                        <span class="zf-icon zf-icon-calendar">17.11.16</span>
                                        <span class="zf-icon zf-icon-comment">10 комментариев</span>
                                    </div>
                                </div>

                                <div class="overlay"></div>
                            </div>
                        </div>
                    </div>

                    <div class="material-item col-xs-3 item">
                        <div class="square">
                            <div class="square-content" style="background-image: url(/assets/images/hot_stuff_item.png);background-size: cover;">
                                <div class="body-bottom">
                                    <p class="title">
                                        Тренировочный полу-марафон по набережным города Казани
                                    </p>
                                    <div class="info">
                                        <span class="zf-icon zf-icon-calendar">17.11.16</span>
                                        <span class="zf-icon zf-icon-comment">10 комментариев</span>
                                    </div>
                                </div>

                                <div class="overlay"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

<?php include 'footer.php' ?>