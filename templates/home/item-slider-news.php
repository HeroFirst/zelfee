<div class="col-xs-6">
    <a href="/<?=$AppUser->getInfoItem('city_alias')?>/news/<?=$item['id']?>">
        <div class="caption">
            <span class="category">Новости</span>

            <div class="title">
                <?=$item['title']?>
            </div>
            <div class="info">
                <span class="zf-icon zf-icon-calendar"><?=\Zelfi\Utils\DateHelper::getDateFromDateTIme($item['date_publish'])?></span>
                <!--
                <span class="zf-icon zf-icon-comment">10 комментариев</span>
                -->
            </div>
        </div>
    </a>
</div>