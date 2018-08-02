<?php include 'header.php';

$count_min_items = count($slider['news']) > count($slider['paper']) ? count($slider['paper']) : count($slider['news']);

$sliderPerPage = $count_min_items > 3 ? 3 : $count_min_items;
$materialsCount = count($news) > 9 ? 9 : count($news);
?>

    <div class="home-slider">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <div class="container carousel-indicators-container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-6">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <?php for ($i=0;$i<$sliderPerPage;$i++):  ?>
                                <li data-target="#carousel-example-generic" data-slide-to="<?=$i?>" class="<?=$i==0 ? 'active' : '' ?>""></li>
                            <?php endfor;  ?>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="carousel-inner" role="listbox">
                <?php for ($i=0;$i<$sliderPerPage;$i++):  ?>
                    <div class="item <?=$i==0 ? 'active' : '' ?>">
                        <div class="container">
                            <div class="row slider-content">

                                <?php
                                $item = $slider['news'][$i];
                                require 'home/item-slider-news.php' ?>
                                <?php
                                $item = $slider['paper'][$i];
                                require 'home/item-slider-paper.php' ?>

                            </div>
                        </div>
                    </div>
                <?php endfor;  ?>

            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left glyphicon-slider-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right glyphicon-slider-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="container">
        <div class="home-content card shadow">

            <div class="row">
                <div class="col-xs-9">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box-title">
                                <span class="zf-icon zf-icon-hot-stuff"></span>
                                <h1>Свежие материалы</h1>
                            </div>
                        </div>
                    </div>

                    <div class="hot-stuff margin-top">
                        <div class="row">

                            <?php if ($feed) for ($i=0;$i<min(9, count($feed));$i++) {
                                $item = $feed[$i];

                                switch ($item['feed_type']){
                                    case 'paper':
                                        require __DIR__ . '/paper/item-paper-4.php';
                                        break;
                                    case 'news':
                                        require __DIR__ . '/news/item-news-4.php';
                                        break;
                                }
                            }?>

                        </div>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box-title">
                                <h1 class="zf-icon zf-icon-rating">Рейтинг ЗФ</h1>
                            </div>

                            <div class="rating margin-top">
                                <div class="rating-head">
                                    <div class="row">
                                        <div class="col-xs-9 name">Cамые активные участники</div>
                                        <div class="col-xs-3 balls">Баллы</div>
                                    </div>
                                </div>
                                <div class="rating-content">

                                    <?php if ($rating_users){
                                        foreach ($rating_users as $rating_user):?>

                                        <div class="rating-content-item">

                                            <div class="avatar" style="background-image: url(

                                            <?php if($rating_user['photo_small']): ?>
                                                <?=$rating_user['photo_small']?>
                                            <?php else: ?>
                                                '/uploads/system/users/avatars/1/defult_user.jpg'
                                            <?php endif; ?>



                                                )">
                                                <div class="avatar-rank"><?=$rating_user['rating']['rank']?></div>
                                            </div>

                                            <span class="name"><?=$rating_user['first_name'].' '.$rating_user['last_name']?></span>
                                            <span class="balls"><?=($rating_user['rating']['balls'] ? $rating_user['rating']['balls'] : 0)?></span>
                                        </div>
                                    <?php endforeach; } else { ?>
                                        <div class="rating-content-item empty">
                                            Недостаточно информации
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>

                            <div class="row margin-top">
                                <div class="col-xs-12 text-center">
                                    <a href="/<?=$AppUser->getInfoItem('city_alias')?>/rating" class="button button-pink button-full-width">Весь рейтинг </a>
                                </div>
                            </div>


                            <div class="rating margin-top-40 ">
                                <div class="rating-head">
                                    <div class="row">
                                        <div class="col-xs-9 name">Самые активные команды</div>
                                        <div class="col-xs-3 balls">Баллы</div>
                                    </div>
                                </div>
                                <div class="rating-content">
                                    <?php if ($teams){
                                        foreach ($teams as $team):?>
                                            <div class="rating-content-item">
                                                <div class="avatar" style="background-image: url(
                                                <?php if($team['photo']): ?>
                                                    <?=$team['photo']?>
                                                <?php else: ?>
                                                    '/uploads/system/teams/default.jpg'
                                                <?php endif; ?>

                                                    )">
                                                    <div class="avatar-rank"><?=$team['rank']?></div>
                                                </div>

                                                <span class="name"><?=$team['name']?></span>
                                                <span class="balls"><?=$team['point']?></span>
                                            </div>
                                        <?php endforeach; } else { ?>
                                        <div class="rating-content-item empty">
                                            Недостаточно информации
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>

                            <div class="row margin-top">
                                <div class="col-xs-12 text-center">
                                    <a href="/<?=$AppUser->getInfoItem('city_alias')?>/rating" class="button button-pink button-full-width">Весь рейтинг</a>
                                </div>
                            </div>
							<?php if($AppUser->getInfoItem('city_alias') === 'kazan'): ?>
							<div class="rating margin-top-40 ">
								<a href="http://www.kazved.ru" target='_blank'><img src="/uploads/system/kazan_ved.jpg"></a>
							</div>
							<?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

<?php
if ($gallery && $gallery['images']) $gallery_images = unserialize($gallery['images']);

if ($gallery_images && count($gallery_images)>5): ?>

            <div class="row margin-top-60">
                <div class="col-xs-12">
                    <div class="box-title">
                        <span class="zf-icon zf-icon-moments"></span>
                        <h1>Моменты зеленого фитнеса</h1>
                    </div>
                </div>
            </div>

            <div class="gallery-moments margin-top">
                <div class="row">
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
            </div>


            <div class="row margin-top">
                <div class="col-xs-12 text-center">
                    <a data-toggle="modal" data-target="#modalGallery" href="#" class="button button-pink button-wide">Еще больше фотографий</a>
                </div>
            </div>

<?php endif; ?>

        </div>
    </div>

    <div class="container">
        <div class="reviews">
            <div class="box-title">
                <h1>Отзывы о нас</h1>
                <a href="#" class="hide">Все отзывы</a>
            </div>

            <div class="row">
                <div class="col-xs-4 item">
                    <div class="card">
                        <div class="zf-icon-quotes text-center"></div>
                        <p>
                            ЗФ - это нужный социально-востребованный проект с большим будущим.
                        </p>
                    </div>
                    <div class="avatar" style="background-image: url(/uploads/system/reviews/default/1.jpg)"></div>
                    <p class="title">Марат Бариев</p>
                    <p class="subtitle">российский государственный и спортивный деятель</p>
                </div>

                <div class="col-xs-4 item">
                    <div class="card">
                        <div class="zf-icon-quotes text-center"></div>
                        <p>
                            "Зеленый Фитнес" - это яркий пример того,как инициативная молодежь может реализовывать важные социально-значимые задачи. 
                        </p>
                    </div>
                    <div class="avatar" style="background-image: url(/uploads/system/reviews/default/4.jpg)"></div>
                    <p class="title">Леонов Владимир</p>
                    <p class="subtitle">Министр по делам молодежи и спорту РТ</p>
                </div>

                <div class="col-xs-4 item">
                    <div class="card">
                        <div class="zf-icon-quotes text-center"></div>
                        <p>
                            Очень интересный и полезный проект. Был очень рад принять участие в нем.
                        </p>
                    </div>
                    <div class="avatar" style="background-image: url(/uploads/system/reviews/default/3.jpg)"></div>
                    <p class="title">Александр Бутько</p>
                    <p class="subtitle">Олимпийский чемпион, игрок ВК "Зенит"</p>
                </div>
            </div>

            <div class="row margin-top hide">
                <div class="col-xs-12 text-center">
                    <a href="#" class="button button-pink button-wide">Написать отзыв</a>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>


    <?php if ($partners){ ?>
    <div class="container">
        <div class="partners margin-top-50">
            <div class="box-title">
                <h1>Наши партнеры</h1>
                <a href="/<?=$AppUser->getInfoItem('city_alias')?>/partners">Все партнеры</a>
            </div>

            <div class="content">
                <?php if ($partners) foreach ($partners as $partner){ ?>
                    <div class="item">
                        <a href="<?=$partner['url']?>">
                            <img class="hover-gray" src="<?=$partner['cover']?>" />
                        </a>
                    </div>
                <?php } ?>

                <div class="clearfix"></div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
    <?php } ?>

        <?php include 'footer.php' ?>