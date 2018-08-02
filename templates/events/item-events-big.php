<a href="/<?=$AppUser->getInfoItem('city_alias')?>/events/<?=$item['id']?>">
    <div class="square">
        <div class="square-content">
            <div class="content" style="background-image: url(<?=$item['cover']?>);">
                <div class="overlay"></div>

                <?php if ($item['balls']>0):?>
                    <span class="balls-count"><?=$item['balls']?> баллов</span>
                <?php endif; ?>

                <?php if ($item['type'] ):?>
                    <span class="icon-category icon-category-<?=$item['type_icon']?>"></span>
                <?php endif; ?>

                <div class="title-container">
                    <h1><?=$item['title']?></h1>
                </div>

                <div class="info-container margin-top-30 margin-bottom-30">
                    <span class="time"><?=\Zelfi\Utils\DateHelper::getTimeFromDateTime($item['date_start'])?></span>
                    <span class="date"><?=\Zelfi\Utils\DateHelper::getDateFromDateTIme($item['date_start'])?></span>
                    <!--
                    <span class="comments">10 комментариев</span>
                    -->
                </div>
            </div>
        </div>
    </div>
</a>