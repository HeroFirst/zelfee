<?php
/**
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 * @var array $AppMenuCounter
 *
 */

include __DIR__.'/../header-simple.php'; ?>

        <div class="page-content">
            <div class="container">

                <div class="row margin-top-30">
                    <div class="col-xs-12">
                        <div class="zf-tabs">
                            <ul>
                                <?php if ($store_categories) foreach ($store_categories as $index => $category): ?>
                                    <li <?=($category_active == $category['id']) ? 'class="active"' : ''?>><a href="?category=<?=$category['id']?>"><?=$category['name']?></a></li>
                                <?php endforeach; ?>
                                <li <?=(!$category_active) ? 'class="active"' : ''?>><a href="?all">Все</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row margin-top-20">
                    <div class="store-items">

                        <?php if ($store_items) foreach ($store_items as $index => $store_item):
                            if ($store_item['count'] > 0){ ?>

                            <div class="store-item">
                                <div class="col-md-3">
                                    <div class="store-item-container">
                                        <div class="store-item-cover">
                                            <div class="square">
                                                <div class="square-content" style="background-image: url(<?=$store_item['cover']?>);background-size: cover;background-position: center;">
                                                    <div class="price">
                                                        <span class="price-title"><?=\Zelfi\Utils\AppUtils::plural_form($store_item['balls'], ['зелфи', 'зелфи', 'зелфи'])?></span>
                                                        <span class="price-subtitle"><?=\Zelfi\Utils\AppUtils::plural_form($store_item['price'], ['рубль', 'рубля', 'рублей'])?></span>
                                                    </div>
                                                    <div class="store-item-overlay">
                                                        <button
                                                            data-store-item-id="<?=$store_item['id']?>"
                                                            data-store-item-name="<?=$store_item['name']?>"
                                                            data-store-item-description="<?=$store_item['description']?>"
                                                            data-store-item-balls="<?=$store_item['balls']?>"
                                                            data-store-item-price="<?=$store_item['price']?>"
                                                            data-store-item-count="<?=$store_item['count']?>"
                                                            data-store-item-cover="<?=$store_item['cover']?>"
                                                            data-toggle="modal"
                                                            data-target="#<?=$AppUser->getRole()<6 ? 'modalStoreOrder': 'modalAuth'?>"
                                                            class="button button-pink">
                                                            Заказать
                                                        </button>
                                                    </div>
                                                    <div class="counter">
                                                        <div class="counter-container">
                                                            <div class="counter-text">
                                                                <?=$store_item['count']?>
                                                                <br />ед
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="store-item-info">
                                            <h3><?=$store_item['name']?></h3>
                                            <p>
                                                <?=$store_item['description']?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } endforeach; ?>

                    </div>
                </div>

                <div class="row margin-top-60 hide">
                    <div class="col-xs-12 text-center">
                        <a href="#" class="button button-pink button-fixed-width">Еще новости</a>
                    </div>
                </div>

            </div>
        </div>

<?php include __DIR__.'/../footer.php' ?>