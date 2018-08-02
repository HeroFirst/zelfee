<div class="col-xs-6">
    <div class="card">
        <div class="content">
            <a href="/<?=$AppUser->getInfoItem('city_alias')?>/paper/<?=$item['id']?>">
                <div class="row slider-content">
                    <div class="col-xs-6">
                        <div class="cover" style="background-position:center; background-size:cover;background-image: url(<?=$item['cover']?>)">
                            <!--
                            <div class="overlay">
                                <img src="/assets/images/icon_video.png">
                            </div>
                            -->
                        </div>
                    </div>
                    <div class="col-xs-6 body">
                        <span class="category">Стань лучше</span>

                        <div class="body-bottom">
                            <p>
                                <?=$item['title']?>
                            </p>
                            <div class="info dark">
                                <span class="zf-icon zf-icon-calendar"><?=\Zelfi\Utils\DateHelper::getDateFromDateTIme($item['date_publish'])?></span>
                                <!--
                                <span class="zf-icon zf-icon-comment">10 комментариев</span>
                                -->
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="clearfix"></div>
    </div>
</div>