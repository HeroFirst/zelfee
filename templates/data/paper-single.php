<?php
/**
 * @var $paper
 */

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