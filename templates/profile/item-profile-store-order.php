<div class="material-item material-item-store-order col-xs-3 item">
    <div class="square">
        <div class="square-content" style="background-image: url(<?=$item['cover']?>);background-size: cover;background-position: center;">
            <div class="overlay"></div>

            <span class="balls-count"><?=$item['price_print']?></span>

            <!--
                            <img class="icon" src="/assets/images/icon_gallery.png" />
            -->
            <div class="body-bottom">
                <p class="title">
                    <?=$item['title']?>
                </p>
                <div class="info">
                    <span class="zf-icon zf-icon-calendar"><?=\Zelfi\Utils\DateHelper::getTimeFromDateTime($item['date'])?> <?=\Zelfi\Utils\DateHelper::getDateFromDateTIme($item['date'])?></span>
                    <!--
                         <span class="zf-icon zf-icon-comment">10 комментариев</span>
                         -->
                </div>
            </div>
        </div>
    </div>
</div>