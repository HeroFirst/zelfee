<?php
/* @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *  @var \Zelfi\Model\ZFCities $AppCities
 */
if ($AppRendererHelper != null){
    $FooterScripts = $AppRendererHelper->getFooterScripts();
    $FooterData = $AppRendererHelper->getFooterData();
}

?>
<script>
    var cities_places = {
    <?php if ($AppCities) foreach ($AppCities->getCities() as $index => $item): ?>
    <?=$item['id']?>: [
        <?php if ($places) foreach ($places as $index => $place){
        if ($place['city'] == $item['id']){?>
        {id: <?=$place['id']?>, text: '<?=$place['name']?>'},
        <?php }} ?>
    ],
    <?php endforeach; ?>
    };

    $(document).ready(function(){
        $(".select2-dynamic").select2({
            data: cities_places[<?=$event['city']?>]
        });
        $("#city").on("change", function (e) {

            $(".select2-dynamic")
                .html('')
                .select2({
                data: cities_places[$(this).val()]
            });
        });
    });
</script>