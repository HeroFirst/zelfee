<?php
/**
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *
 */

include 'header-simple.php'; ?>

        <div class="page-content">
            <div class="container">

                <div class="row margin-top-30">
                    <div class="col-xs-12">
                        <div class="flex flex-vertical-center flex-left-right">
                            <div class="zf-tabs-big">
                                <ul>
                                    <?php if ($categories) foreach ($categories as $index => $category): ?>
                                        <li <?=($category_active == $category['id']) ? 'class="active"' : ''?>><a href="?category=<?=$category['id']?>"><?=$category['name']?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div class="zf-tabs pull-right hide">
                                <ul>
                                    <?php if ($types) foreach ($types as $index => $type): ?>
                                        <li <?=($type_active == $type['id']) ? 'class="active"' : ''?>><a href="?category=<?=$category_active?>&type=<?=$type['id']?>"><?=$type['name']?></a></li>
                                    <?php endforeach; ?>
                                    <li <?=(!$type_active) ? 'class="active"' : ''?>><a href="?category=<?=$category_active?>">Все</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row margin-top-30">
                    <div class="col-xs-12">
                       <div class="zf-toggle zf-toggle-text pull-right">
                           <span class="label-left">Актуальные</span>
                           <input type="checkbox" <?=(!$events_now) ? 'checked' : ''?>>
                           <span class="label-right">Прошедшие</span>
                       </div>
                    </div>
                </div>

                <div class="row events-gallery margin-top-20">
                    <ul class="nav nav-tabs hide" role="tablist">
                        <li role="presentation" <?=($events_now && count($events_now)>0) ? 'class="active"' : ''?>><a href="#now" aria-controls="now" role="tab" data-toggle="tab">Now</a></li>
                        <li role="presentation" <?=(!$events_now) ? 'class="active"' : ''?>><a href="#recent" aria-controls="recent" role="tab" data-toggle="tab">Recent</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in <?=($events_now && count($events_now)>0) ? 'active' : ''?>" id="now">
                            <div class="row">

                                <?php
                                if ($events_now):
                                foreach ($events_now as $index => $item): ?>
                                    <div class="col-xs-6">
                                    <?php
                                    if ($index == 0) require 'events/item-events-big.php';
                                    else require 'events/item-events.php'

                                    ?>
                                    </div>
                                <?php
                                endforeach;
                                else:  ?>
                                    <div class="col-xs-12 text-center">
                                        <p>На данный момент нет актуальных мероприятий, Вы можете ознакомиться со списком прошедших мероприятий</p>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in <?=(!$events_now) ? 'active' : ''?>" id="recent">
                            <div class="row">

                                <?php
                                if ($events_recent):
                                    foreach ($events_recent as $index => $item): ?>
                                        <div class="col-xs-6">
                                            <?php
                                            if ($index == 0) require 'events/item-events-big.php';
                                            else require 'events/item-events.php'

                                            ?>
                                        </div>
                                        <?php
                                    endforeach;
                                else:  ?>
                                    <div class="col-xs-12 text-center">
                                        <p>На данный момент нет актуальных мероприятий, Вы можете ознакомиться со списком прошедших мероприятий</p>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row margin-top-40 hide">
                    <div class="col-xs-12 text-center">
                        <a href="#" class="button button-pink button-fixed-width">Еще мероприятия</a>
                    </div>
                </div>

<?php
if ($gallery && $gallery['images']) $gallery_images = unserialize($gallery['images']);

if ($gallery_images && count($gallery_images)>5): ?>

                <div class="row margin-top-40">
                    <div class="col-xs-12">
                        <div class="box-title-page">
                            <h1>Моменты зеленого фитнеса</h1>
                        </div>
                    </div>
                </div>

                <div class="row gallery-moments margin-top">
                    <div class="col-xs-12">

                        <div class="row">
                            <div class="col-xs-6">
                                <a data-slide-to="0" href="#carousel-gallery" >
                                    <div class="square rectangle" data-toggle="modal" data-target="#modalGallery">
                                        <div class="square-content">
                                            <div class="content" style="background-image: url(<?=$gallery_images[0]?>);"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xs-3">
                                <a data-slide-to="1" href="#carousel-gallery" >
                                    <div class="square" data-toggle="modal" data-target="#modalGallery">
                                        <div class="square-content">
                                            <div class="content" style="background-image: url(<?=$gallery_images[1]?>);"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xs-3">
                                <a data-slide-to="2" href="#carousel-gallery" >
                                    <div class="square" data-toggle="modal" data-target="#modalGallery">
                                        <div class="square-content">
                                            <div class="content" style="background-image: url(<?=$gallery_images[2]?>);"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xs-3">
                                <a data-slide-to="3" href="#carousel-gallery" >
                                    <div class="square" data-toggle="modal" data-target="#modalGallery">
                                        <div class="square-content">
                                            <div class="content" style="background-image: url(<?=$gallery_images[3]?>);"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xs-6">
                                <a data-slide-to="4" href="#carousel-gallery" >
                                    <div class="square rectangle" data-toggle="modal" data-target="#modalGallery">
                                        <div class="square-content">
                                            <div class="content" style="background-image: url(<?=$gallery_images[4]?>);"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xs-3">
                                <a data-slide-to="5" href="#carousel-gallery" >
                                    <div class="square" data-toggle="modal" data-target="#modalGallery">
                                        <div class="square-content">
                                            <div class="content" style="background-image: url(<?=$gallery_images[5]?>);"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="row margin-top-40">
                    <div class="col-xs-12 text-center">
                        <a data-toggle="modal" data-target="#modalGallery" href="#" class="button button-pink button-fixed-width">Еще больше фотографий</a>
                    </div>
                </div>

<?php endif; ?>
            </div>
        </div>

<?php include 'footer.php' ?>