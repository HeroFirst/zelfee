<?php require_once 'header.php' ?>

<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">

        <div class="small-box <?=$balls_users_video_not_approved_count ? 'bg-red' : 'bg-green' ?>">
            <div class="inner">
                <h3><?=$balls_users_video_not_approved_count ? $balls_users_video_not_approved_count : 0 ?></h3>

                <p>Заявок на подтверждение видео</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-videocam"></i>
            </div>
            <a href="/private/balls-system/bonuses/users-video/new" class="small-box-footer">Подробнее <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">

        <div class="small-box <?=$store_orders_count ? 'bg-red' : 'bg-light-blue' ?>">
            <div class="inner">
                <h3><?=$store_orders_count ? $store_orders_count : 0 ?></h3>

                <p>Заказано товаров</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-cart"></i>
            </div>
            <a href="/private/store/orders/new" class="small-box-footer">Подробнее <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<?php require_once 'footer.php' ?>
