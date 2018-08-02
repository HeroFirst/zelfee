<a href="/<?=$AppUser->getInfoItem('city_alias')?>/paper/<?=$item['id']?>">
    <div class="material-item material-item-paper col-xs-4 item">
        <div class="square">
            <div class="square-content" style="background-image: url(<?=$item['cover']?>);background-size: cover;">
                <div class="overlay"></div>

                <?php if ($item['type'] != '' ):?>
                    <span class="category"><?=$item['type_name']?></span>
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
    </div>
</a>