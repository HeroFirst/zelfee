<a href="/<?=$AppUser->getInfoItem('city_alias')?>/news/<?=$item['id']?>">
    <div class="material-item material-item-news material-item-wide col-xs-12 item">
        <div class="content" style="background-image: url(<?=($item['cover_big']!='' ? $item['cover_big'] : $item['cover'])?>);background-size: cover;">
            <div class="overlay"></div>

            <?php if ($item['type'] ):?>
                <span class="category"><?=$item['type_name']?></span>
            <?php endif; ?>

            <span class="icon-category icon-category-hot">Главное</span>

            <div class="body-bottom">
                <p class="title">
                    <?=$item['title']?>
                </p>
                <div class="info">
                    <span class="zf-icon zf-icon-calendar"><?=\Zelfi\Utils\DateHelper::getDateFromDateTIme($item['date_publish'])?></span>
                    <!--
                            <span class="zf-icon zf-icon-comment">10 комментариев</span>
                            -->
                </div>
            </div>
        </div>
    </div>
</a>