<a href="/<?=$AppUser->getInfoItem('city_alias')?>/paper/<?=$item['id']?>">
    <div class="material-item material-item-wide col-xs-6 item">
        <div class="content" style="background-image: url(<?=($item['cover_big']!='' ? $item['cover_big'] : $item['cover'])?>);background-size: cover;">
            <div class="overlay"></div>

            <?php if ($item['type'] ):?>
                <span class="category"><?=$item['type_name']?></span>
            <?php endif; ?>

            <?php if ($item['is_hot'] == 1):?>
                <span class="icon-category icon-category-hot">Главное</span>
            <?php endif; ?>

            <div class="body-bottom">
                <div class="author">
                    <div style="background-image: url(<?=$item['user']['photo_small']?>)" class="author-cover"></div>
                    <span class="author-name"><?=$item['user']['first_name'].' '.$item['user']['last_name']?></span>
                </div>
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