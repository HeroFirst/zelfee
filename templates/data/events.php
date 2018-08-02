<?php
if ($gallery && $gallery['images']) $gallery_images = unserialize($gallery['images']);

if ($gallery_images && count($gallery_images)>5): ?>

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