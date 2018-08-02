<?php

/**
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *
 */

include __DIR__.'/../header-simple.php';

?>

    <link href="/assets/js/autocomplete/styles.css" rel="stylesheet" />
    <script type="text/javascript" src="/assets/js/autocomplete/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/assets/js/autocomplete/jquery.autocomplete.js"></script>

<?php if($is_search_user || $is_search_team): ?>

    <div class="modal zf-modal" tabindex="-1" role="dialog" id="isSearch">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="width: 700px">
                <div class="modal-header">
                    <button type="button" onclick="$('#isSearch').hide()" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Результаты поиска</h4>
                </div>
                <div class="modal-body">


                    <div class="col-xs-12 margin-bottom-40">

                        <?php if($is_search_user):?>
                            <div class="col-xs-3">
                                <?php if($is_search_user[0]['photo']): ?>
                                    <img class="img-circle" style=" width:100px;" src="<?=$is_search_user[0]['photo']?>" alt="">
                                <?php else:?>
                                    <img class="img-circle" style=" width:100px;" src="/uploads/system/teams/default.jpg" alt="">
                                <?php endif; ?>
                            </div>
                            <div class="col-xs-8 text-right">
                                <h3> <?=$is_search_user[0]['first_name'].' '. $is_search_user[0]['last_name']?> <span class="card-pink-bg"><?=$is_search_user['balls']?></span> </h3>
                                <h4>
                                    <?php if($is_search_user['is_team_name']):?>
                                        <?=$is_search_user['is_team_name']?>  <span class="card-pink-bg"><?=$is_search_user['is_team_point']?></span>
                                    <?php else: ?>
                                        Без команды
                                    <?php endif; ?>

                                </h4>
                                <h5 style="color:#4af9c2">Участник</h5>
                            </div>
                        <?php endif; ?>

                        <?php if($is_search_team):?>
                            <div class="col-xs-3">
                                <br>
                                <?php if($is_search_team['photo']): ?>
                                    <img class="img-circle" style=" width:100px;" src="<?=$is_search_team['photo']?>" alt="">
                                <?php else:?>
                                    <img class="img-circle" style=" width:100px;" src="/uploads/system/teams/default.jpg" alt="">
                                <?php endif; ?>
                            </div>

                            <div class="col-xs-8 text-right">
                                <h4 style="color:#4af9c2">Команда</h4>
                                <h2><?=$is_search_team['name']?></h2>
                                Общий балл команды: <span class="card-pink-bg"><?=$is_search_team['point']?></span>

                                <h5>Капитан команды: <b><?=$is_search_team['captain']?> </b><span class="card-pink-bg"><?=$is_search_team['captain_balls']?></span></h5>

                            </div>
                        <?php endif; ?>



                    </div>
                    <hr>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.moda3 -->
    <script>
        $('#isSearch').show();
    </script>
<?php endif; ?>
    <div class="page-content">
        <div class="container">

            <div class="row margin-top-40">
                <div class="col-xs-6">
                    <div class="box-title-page">
                        <h1 class="zf-icon zf-icon-rating">Рейтинг ЗФ</h1>



                    </div>
                </div>
                <div class="col-xs-6 text-right">
                    <form action="/kazan/rating" method="get" class="form-inline ">
                        <div class="form-group zfautocomplete" >

                            <input  id="autocomplete" type="text"  name="search_name" class="form-control" placeholder="Поиск по командам и участникам" style="width:500px;">
                            <input  id="autocompletehiden" type="hidden"  name="hiden_team_id" >
                            <input  id="autocompletehiden_user" type="hidden"  name="hiden_user_id" >


                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Поиск</button>
                        </div>

                    </form>


                </div>
            </div>
            <script>
                var countries = [
                    <?php foreach ($users_autocomplete as $index => $user_ac): ?>
                    {  value: 'Участник: <?=$user_ac['first_name'].' '.$user_ac['last_name'].' | id '.$user_ac['id']?> ',  data:'<?=$user_ac['first_name'].' '.$user_ac['last_name']?>', value2: '<?=$team_ac['id']?>'},
                    <?php endforeach; ?>
                    <?php foreach ($teams_autocomplete as $index => $team_ac): ?>
                    { value: 'Команда: <?=$team_ac['name'].' | id'. $team_ac['id']?> ' , data:'<?=$team_ac['name']?>', value2: '<?=$team_ac['id']?>'  },
                    <?php endforeach; ?>
                ];

                $('#autocomplete').autocomplete({
                    lookup: countries,
                    onSelect: function (suggestion) {
                        $('#autocomplete').val(suggestion.data);
                        var value = suggestion.value;
                        var numInStringId = value.indexOf("id");


                        if(value.indexOf("Команда")){
                            var id = value.substr(numInStringId+2, 10);
                            $('#autocompletehiden_user').val(id)
                        }else{
                            var id = value.substr(numInStringId+2, 10);
                            $('#autocompletehiden').val(id);
                        }


                    }
                });

                //                $('#autocomplete').autocomplete({
                //                    serviceUrl: '/autocomplete',
                //                    onSelect: function (suggestion) {
                //                        alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
                //                    }
                //                });
            </script>
            <div class="row margin-top-40">
                <div class="col-xs-6 ">
                    <div class="rating-content" id="rating-content-users">
                        <div class="row">
                            <div class="col-xs-12">
                                <h1 class="rating-title">Самые активные участники</h1>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class="col-xs-12">
                                <div class="rating-table">
                                    <div class="rating-table-head">
                                        <div class="row-1">Место</div>
                                        <div class="row-2">Участник</div>
                                        <div class="row-3">Баллы</div>
                                    </div>
                                    <div class="rating-table-body">

                                        <?php if ($users) foreach ($users as $index => $user): ?>
                                            <div class="rating-table-item">
                                                <div class="row-1">
                                                    <span class="number"><?=$user['rating']['rank']?></span>
                                                </div>
                                                <div class="row-2">
                                                    <div class="avatar" style="background-image: url(<?=$user['photo_small']?>)"></div>
                                                    <div class="text">
                                                        <span class="title"><?=$user['first_name'].' '.$user['last_name']?></span>
                                                            <span class="subtitle">
                                                                <?php if($user['team']): ?>
                                                                    <?=$user['team']?>
                                                                <?php endif;?>
                                                            </span>
                                                    </div>
                                                </div>
                                                <div class="row-3"><span class="balls"><?=($user['rating']['balls'] ? $user['rating']['balls'] : 0)?></span></div>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6 " >
                    <div class="rating-content">
                        <div class="row">
                            <div class="col-xs-12" >
                                <h1 class="rating-title">Самые активные команды</h1>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class="col-xs-12">
                                <div class="rating-table">
                                    <div class="rating-table-head">
                                        <div class="row-1">Место</div>
                                        <div class="row-2">Команда</div>
                                        <div class="row-3">Баллы</div>
                                    </div>
                                    <div class="rating-table-body" id="rating-content-teams">

                                        <?php if ($teams) foreach ($teams as $index => $team): ?>
                                            <div class="rating-table-item">
                                                <div class="row-1">
                                                    <span class="number"><?=$team['rank']?></span>
                                                </div>
                                                <div class="row-2">
                                                    <?php if ($team['photo']): ?>
                                                        <div class="avatar" style=" background-image: url(<?=$team['photo']?>)"></div>
                                                    <?php else: ?>

                                                        <img class="img-circle" width="50" height="50" src="/uploads/system/teams/default.jpg" >
                                                    <?php endif; ?>


                                                    <div class="text">
                                                        <span class="title"><?=$team['name']?></span>
                                                        <span class="subtitle"> <?=$team['captain']?></span>
                                                    </div>
                                                </div>
                                                <div class="row-3"><span class="balls"><?=$team['point']?></span></div>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($users): ?>
                <div class="row margin-top-40">
                    <div class="col-xs-12 text-center">
                        <a href="#" id="action-more" class="button button-pink button-fixed-width">Показать еще</a>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

<?php include __DIR__.'/../footer.php' ?>