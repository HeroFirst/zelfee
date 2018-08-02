<?php
/**
 * @var $event
 */

$places = $event['places'];
?>
<script>
    $(document).ready(function() {
        var slider = $("#lightSlider").lightSlider({
            controls: false,
            pager: false,
            item: 4
        });

        $('.event-slider .control-left').click(function (event) {
            slider.goToPrevSlide();

            return false;
        });

        $('.event-slider .control-right').click(function (event) {
            slider.goToNextSlide();

            return false;
        });
    });

    $('.share').ShareLink();
    $('.counter').ShareCounter({
        url: 'http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>',
        increment: true
    });

</script>
<div class="modal zf-modal fade" id="modalPlaceSelect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                <h4 class="modal-title" id="myModalLabel">Выбор площадки</h4>
            </div>
            <div class="modal-body">
                <div class="place-selector">
                    <div class="row">

                        <?php foreach ($places as $index => $place): ?>
                            <div class="col-xs-6">
                                <div class="place-selector-item">
                                    <form method="post" action="/events/subscribe" id="formSelectPlace<?=$index?>">
                                        <input type="hidden" name="event_id" value="<?=$event['id']?>">
                                        <input type="hidden" name="place_id" value="<?=$place['id']?>">
                                    </form>

                                    <button type="submit" form="formSelectPlace<?=$index?>" class="button-link">
                                        <div class="square rectangle">
                                            <div class="square-content">
                                                <div class="place-selector-cover" style="background-image: url(<?=$place['cover']?>)">
                                                    <div class="place-selector-overlay">
                                                        <span class="button button-pink">Выбрать</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </button>

                                    <span class="place-selector-title"><?=$place['name']?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if ($event['gallery']['images']) $gallery_images = unserialize($event['gallery']['images']);

if ($gallery_images): ?>

    <div class="modal zf-modal zf-modal-wide-1000 zf-modal-border-10 fade" tabindex="-1" role="dialog" id="modalGallery">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-xs-12 text-center">

                            <div class="modal-gallery">
                                <div id="carousel-gallery" class="carousel slide" data-ride="carousel">

                                    <div class="carousel-inner" role="listbox">

                                        <?php foreach ($gallery_images as $index => $gallery_image): ?>
                                            <div class="item <?=$index == 0 ? 'active' : '' ?>">
                                                <div class="gallery-img" style="background-image: url(<?=$gallery_image?>)"></div>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>

                                    <a class="left carousel-control" href="#carousel-gallery" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left glyphicon-slider-left" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-gallery" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right glyphicon-slider-right" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php endif; ?>