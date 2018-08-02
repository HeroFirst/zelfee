<?php
/**
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 * @var array $AppMenuCounter
 *
 */

?>
<script>
    var page = 2;
    var mayLoading = true;

    $(document).ready(function() {
        $('#action-more').click(function (e) {
            e.preventDefault();

            if (mayLoading){
                mayLoading = false;

                $.get('/<?=$AppUser->getInfoItem('city_alias')?>/rating?items_only=true&page='+page, function (data) {

                    if (data!='')  {
                        
                        var usersdata = $.parseJSON(data);
                        $('#rating-content-users .rating-table-body').append(usersdata[1]); //участники
                        $('#rating-content-teams').empty(); // команды
                        $('#rating-content-teams').append(usersdata[2]); // команды

                        page++;
                    } else {
                        $('#action-more').hide();
                    }

                    mayLoading = true;
                });
            }
        });
    });
</script>