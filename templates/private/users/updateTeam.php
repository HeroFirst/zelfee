<?php require_once __DIR__.'/../header.php' ?>
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
<link href="/assets/js/autocomplete/styles.css" rel="stylesheet" />
<script type="text/javascript" src="/assets/js/autocomplete/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/assets/js/autocomplete/jquery.autocomplete.js"></script>


<div class="modal zf-modal fade" tabindex="-1" role="dialog" id="editBall">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="width: 400px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Изменение баллов</h4>
            </div>
            <div class="modal-body">

                <form action="/private/users/team/ball" method="post" enctype="multipart/form-data">
                    <div id="form-group" >


                        <div class="form-group">
                            <input type="text" name='editball' class="form-control" maxlength="4" style="width:250px;" value="<?=$team['point']?>" placeholder="Укажите количество баллов" required>
                            <input type="hidden" name='teamId' value="<?=$team['id']?>">
                        </div>
                        <hr>

                    </div>


                    <div class="form-group">
                        <button type="submit" class='btn btn-primary'>Изменить</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal zf-modal fade" tabindex="-1" role="dialog" id="editCity">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="width: 400px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Изменение города</h4>
            </div>
            <div class="modal-body">

                <form action="/private/users/team/changecity" method="post" enctype="multipart/form-data">
                    <div id="form-group" >


                        <div class="form-group">
                            <select name='city' required class="form-control" >
                                <option value="" disabled selected>Город команды</option>
                                <?php foreach ($cities as $city):?>
                                    <option value="<?=$city['id']?>"><?=$city['name']?></option>
                                <?php endforeach;?>
                            </select>
                            <input type="hidden" name='teamId' value="<?=$team['id']?>">
                        </div>
                        <hr>

                    </div>


                    <div class="form-group">
                        <button type="submit" class='btn btn-primary'>Изменить</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.moda2 -->
<div class="col-md-12">
    <a class="btn btn-primary" href="/private/users/teams/all">Все команды</a>
    <a class="btn btn-success" href="/private/users/teams/create">Создать команду</a>
    <a class="btn btn-danger pull-right" href="#" style='margin-left:5px;' data-toggle=modal data-target=#editBall>Редактировать баллы</a> <a class="btn btn-danger pull-right" href="#" data-toggle=modal data-target=#editCity>Изменить город</a>

    <br>
    <h2>Команда: <b><?=$team['name']?></b> </h2>
    <h5>Город: <b><?=$team_city?></b> </h5>
    <h5>Баллы: <b><?=$team['point']?></b> </h5>
    <br>
    <table  class="table table-hover" style="margin-bottom:30px;" id="tableMemberTeam">
        <?php foreach ($crew as $user): ?>

                <tr>
                    <td >
                        <?php if($user['photo_small']): ?>
                            <img  style="border-radius:50px; width:40px; " src=<?=$user['photo_small']?>
                        <?php else: ?>
                            <img  style="border-radius:50px; width:40px; " src="/../../../uploads/system/users/avatars/1/defult_user.jpg" >
                        <?php endif; ?>
                    </td>
                    <td>
                        <h5>
                            <?=$user['first_name']?>
                            <?=$user['last_name']?>
                        </h5>
                    </td>
                    <?php if($team['captain']==$user['id']): ?>

                        <td><h5>Капитан команды</h5></td>
                    <?php else: ?>
                        <td><h5>Участник<h5></td>
                    <?php endif; ?>
                    <td>
                        <?php if($team['captain']==$user['id']): ?>

                    <td><h5>Нельзя удалить</h5></td>
                <?php else: ?>
                    <td>        <a calss="btn btn-danger" href="/private/users/team/<?=$team['id']?>/edit?delete=<?=$user['id']?>" ><h5>Удалить из команды</h5></a></td>
                   
                <?php endif; ?>

                 </tr>



        <?php endforeach; ?>

    </table>
    <br>
    <h3>К добавлению возможно: <?=5-count($crew)?> участника</h3>
    <br>
</div>



<div class="col-md-6  text-rigth">
<form id="form-place-add" action="/private/users/team/update" method="post" class="form-horizontal">

    <input type="hidden" value="<?=$team['id']?>" name="crew">
    <div class="form-group">
        <?php for($i=1; $i <= 5-count($crew); $i++):?>
            <input type="text" id="name_sname<?=$i?>" style="margin-bottom:5px;"  placeholder="Участник <?=$i?>"
                <?php if($i == 1):?>
                    required
                <?php endif; ?>

                   class="form-control"   autocomplete="off">
            <input type="hidden" id="teammember<?=$i?>" name="teammember<?=$i?>">
        <?php endfor; ?>
        <input type="submit" class="btn btn-success" value="Внести изменения">
    </div>



</form>
</div>




<script>
    var countries = [
        <?php foreach ($users_autocomplete as $index => $user_ac): ?>
        {  value: '<?=$user_ac['first_name'].' '.$user_ac['last_name']?> | id: <?=$user_ac['id']?> ',  data:'<?=$user_ac['id']?>'},
        <?php endforeach; ?>

    ];
    <?php for($i=1; $i <= 5-count($crew); $i++):?>
    $('#name_sname<?=$i?>').autocomplete({
        lookup: countries,
        onSelect: function (suggestion) {
            $('#name_sname<?=$i?>').val(suggestion.value);
            $('#teammember<?=$i?>').val(suggestion.data);
        }
    });
    <?php endfor; ?>
</script>
<?php require_once  __DIR__.'/../footer.php' ?>
