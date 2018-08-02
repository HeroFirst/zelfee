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


<form id="form-place-add" action="/private/users/teams/create" method="post" class="form-horizontal">
<div class="container">
    <div class="row">
        <a class="btn btn-primary" href="/private/users/teams/all">Все команды</a>
        <br>
        <h2>Регистрация команды</h2>
        <br>
       <div class="col-md-10">
            <div class="form-group">
                <input type="text" maxlength="100" name="crew_name" placeholder="Название команды" required class="form-control">
                <select name='city' required class="form-control" >
                    <option value="" disabled selected>Город команды</option>
                    <?php foreach ($cities as $city):?>
                        <option value="<?=$city['id']?>"><?=$city['name']?></option>
                    <?php endforeach;?>
                </select>
            </div>


    <div class="row">
        <div class="col-md-5">

        <div class="form-group">
            <?php for($i=1; $i <= 5; $i++):?>
                <input type="text" id="name_sname<?=$i?>" style="margin-bottom:5px;"  placeholder="Участник <?=$i?>"
                    <?php if($i == 1):?>
                        required data-toggle="tooltip" data-placement="right" title="Поле капитана команды"

                    <?php endif; ?>
                    <?php if($i == 2):?>
                        required data-toggle="tooltip" data-placement="right" title="Баллы добавляются командам из 2-х участников"

                    <?php endif; ?>

                       class="form-control"   autocomplete="off">
                <input type="hidden" id="teammember<?=$i?>" name="teammember<?=$i?>">

            <?php endfor; ?>
            <input type="submit" class="btn btn-success" value="Внести изменения">
        </div>
    </div>


            <div class="col-md-3">

                <div class="form-group">
                <p style="margin-top:28px; margin-left:5px;"> Кпитан команды</p>
                </div>

            </div>
        <div class="col-md-4 text-left">
            <br>
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-info"></i> Внимание | Правила регистрации новых команд</h4>
                <p><b>1.</b> Участники добавляемые в команду должны быть зарегистрированы.</p>
                <p><b>2.</b> Капитан команды не может иметь вторую команду.</p>
                <p><b>3.</b> Указанные участники не должны состоять в другой команде.</p>
            </div>

        </div>

    </div>
</div>

</form>



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
