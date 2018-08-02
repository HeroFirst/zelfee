<?php

include 'header-simple.php';

/**
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *
 */
?>

    <link href="/assets/js/autocomplete/styles.css" rel="stylesheet" />
    <script type="text/javascript" src="/assets/js/autocomplete/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/assets/js/autocomplete/jquery.autocomplete.js"></script>

    <div class="modal zf-modal fade" tabindex="-1" role="dialog" id="modalTeam">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="width: 400px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Регистрация команды</h4>
                </div>
                <div class="modal-body">

                    <form action="/kazan/team/create" method="post" enctype="multipart/form-data">
                        <div id="form-group" >


                            <div class="form-group">
                                <h5 style="color:blue;" onclick="$('#editAvatarTeam').show()"><a href="#">Выберите аватар команды</a></h5>
                                <input name="team_photo" class="form-control" id="editAvatarTeam" style="display: none" type="file">
                                <input type="text" name='name' class="form-control"  placeholder="Название команды" required>
                                <select name='city' required class="form-control" >
                                    <option value="" disabled selected>Город команды</option>
                                    <?php foreach ($cities as $city):?>
                                        <option value="<?=$city['id']?>"><?=$city['name']?></option>
                                    <?php endforeach;?>                                    
                                </select>
                            </div>
                            <hr>

                        </div>


                        <div class="form-group">
                            <button type="submit" class='btn btn-primary '>Создать</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal zf-modal" tabindex="-1" role="dialog" id="updateTeam">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="width: 500px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                    <h4 class="modal-title change-title" id="gridSystemModalLabel">Редактирование команды

                    </h4>

                </div>
                <div class="modal-body">


                    <div id="tableMemberTeam">
                        <form action="/kazan/team/addPhoto" method="post" id="updatePhotoName" enctype="multipart/form-data">

                                <div class="form-group">
                                        <h5 style="color:blue;" onclick="$('#editAvatarTeamUp').show()"><a href="#">Изменить аватар команды</a></h5>
                                        <input name="team_photo" class="form-control" id='editAvatarTeamUp' style="display: none" type="file">
                                        <input name="team_name" class="form-control" required type="text" value="<?=$team['name']?>">
                                        <select name='city'  class="form-control" >
                                            <option value="" disabled selected>Город</option>
                                            <?php foreach ($cities as $city):?>
                                                <option value="<?=$city['id']?>"><?=$city['name']?></option>
                                            <?php endforeach;?>
                                        </select>
                                </div>
                            <br>
                                <div class="form-group">
                                    <button class="btn btn-success ">Изменить</button>
                                    <bottom class="btn btn-success"  data-toggle=modal data-target=#updateTeamCapitan>Сменить капитана</bottom>
                                    <bottom class="btn btn-danger"  data-toggle=modal data-target=#deleteTeam>Удалить</bottom>
                                </div>
                        </form>

                        <table  class="table table-hover" style="margin-bottom:30px;" id="">
                            <?php foreach ($crew as $user): ?>
                                <hr>
                                <?php if($user['captain'] != $user['id']): ?>


                                    <tr>
                                        <td >
                                            <?php if($user['photo_small']): ?>
                                                <img  style="border-radius:50px; width:40px; " src=<?=$user['photo_small']?>
                                            <?php else: ?>
                                                <img  style="border-radius:50px; width:40px; " src="/uploads/system/users/avatars/1/defult_user.jpg" >
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <h5>
                                                <?=$user['first_name']?>
                                                <?=$user['last_name']?>
                                            </h5>
                                        </td>
                                        <?php if($user['captain']==$user['user_id']): ?>

                                            <td><h5>Капитан команды</h5></td>
                                        <?php else: ?>
                                            <td><h5>Участник<h5></td>
                                        <?php endif; ?>
                                        <td><a calss="btn btn-danger" href="/users/me/team/<?=$user['user_id']?>/out" ><h5>Удалить из команды</h5></a></td>
                                    </tr>
                                <?php endif; ?>


                            <?php endforeach; ?>
                        </table>
                    </div>




                    <form action="/users/me/addmember" method="post" id="addMemberTeam" style="display: none;">

                        <div class="form-group " >
                            <?php for($i=1; $i <= 5-count($crew); $i++):?>
                                <label style="float:left"><?=$i?>. Участник</label>

                                <input type="text" id="name_sname<?=$i?>" style="margin-bottom:5px;" name="teammate_mail<?=$i?>" placeholder="Введите имя участника; ID; E-mail"
                                    <?php if($i == 1):?>
                                        required
                                    <?php endif; ?>

                                       class="form-control"   autocomplete="off">
                                <input type="hidden" id="teammember<?=$i?>" name="teammember<?=$i?>">

                            <?php endfor; ?>
                        </div><br>
                        <div>
                            <input type="submit" class="btn btn-success" value='Пригласить участников'>
                        </div>

                    </form>
                    <script>
                        var countries = [
                            <?php foreach ($users_autocomplete as $index => $user_ac): ?>
                            {  value: '<?=$user_ac['first_name'].' '.$user_ac['last_name']?> | id - <?=$user_ac['id']?>',  data:'<?=$user_ac['id']?>'},
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
                    <script>
                        $(document).on('click', '#addMember', function(){

                            $('#addMemberTeam').show();
                            $('#tableMemberTeam').hide();
                            $('.change-title').html('Добавление участников');

//                            $('#addMember').hide();




                        });
                        $(document).on('click', '#listMembers', function(){
                            $('.change-title').html('Редактирование команды');
                            $('#addMemberTeam').hide();
                            $('#tableMemberTeam').show();
//                            $('#addMember').show();


                        });
                    </script>

                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.moda2 -->
    <div class="modal zf-modal" tabindex="-1" role="dialog" id="updateTeamCapitan">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="width: 500px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Выберите нового капитана</h4>
                </div>
                <div class="modal-body">

                    <div class="col-xs-12">
                        <table class="table table-hover" style="margin-bottom:30px" >

                            <?php foreach ($crew as $user): ?>

                                <?php if($user['captain'] != $user['id']): ?>
                                    <tr>
                                        <td >
                                            <?php if($user['photo_small']): ?>
                                                <img  style="border-radius:50px; width:40px; " src=<?=$user['photo_small']?>
                                            <?php else: ?>
                                                <img  style="border-radius:50px; width:40px; " src="/uploads/system/users/avatars/1/defult_user.jpg" >
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <h5><?=$user['first_name']?>
                                                <?=$user['last_name']?></h5>

                                        </td>
                                        <?php if($user['captain']==$user['user_id']): ?>

                                            <td><h5>Капитан команды</h5></td>
                                        <?php else: ?>
                                            <td><h5>Участник<h5></td>
                                        <?php endif; ?>
                                        <td><a calss="btn btn-warning" href="/users/me/<?=$user['user_id']?>/changelider" ><h5>Выбрать</h5></a></td>
                                    </tr>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.moda3 -->
    <div class="modal zf-modal" tabindex="-1" role="dialog" id="teamAlert">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="width: 500px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                    <?php if(count($teams_alert)>1): ?>
                        <h4 class="modal-title" id="gridSystemModalLabel">Вас приглашают команды </h4>
                    <?php else: ?>
                        <h4 class="modal-title" id="gridSystemModalLabel">Вас приглашает команда </h4>
                    <?php endif; ?>


                </div>
                <div class="modal-body">

                    <div class="col-xs-12">
                        <table class="table table-hover" style="margin-bottom:30px" >

                            <?php foreach ($teams_alert as $team_alert): ?>
                                <?php if($team_alert['name']): ?>

                                    <tr>
                                        <td >
                                            <?php if($team_alert['photo']): ?>
                                                <img  style="border-radius:50px; width:30px; height:30px" src=<?=$team_alert['photo']?>
                                            <?php else: ?>
                                                <img  style="border-radius:50px; width:40px; " src="/uploads/system/teams/default.jpg" >
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <h5><?=$team_alert['name']?></h5>

                                        </td>
                                        <td>
                                            <h5><span class="card-pink-bg"><?=$team_alert['point']?></span></h5>

                                        </td>

                                        <td><a calss="btn btn-warning" href="/users/me/team/<?=$team_alert['id']?>/accede" ><h5>Вступить</h5></a></td>
                                    </tr>


                                <?php endif; ?>
                            <?php endforeach; ?>

                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.moda3 -->
    <div class="modal zf-modal" tabindex="-1" role="dialog" id="updateTeamPhoto">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="width: 500px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Изображение команды</h4>
                </div>
                <div class="modal-body">

                    <form action="/kazan/team/addPhoto" method="post" enctype="multipart/form-data">
                        <input name="team_photo" class="form-control" type="file"><br>
                        <button class="btn btn-success ">Изменить</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.moda4 -->
    <div class="modal zf-modal" tabindex="-1" role="dialog" id="deleteTeam">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="width: 500px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Вы действительно хотите удалить команду ?</h4>
                </div>
                <div class="modal-body">

                    <div class="col-xs-12 text-left" style="margin-bottom:30px;">
                        <a href="/users/me/team/<?= $team['id']?>/teamdelete" class="btn btn-danger ">Да</a>
                        <a  class="btn btn-success " data-dismiss="modal" aria-label="Close" >Нет</a>

                    </div>


                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.moda4 -->

        <div class="page-content">
            <div class="container">
                <div class="row margin-top-40">
                    <div class="col-xs-12">
                        <div class="box-title-page">
                            <h1>Личный кабинет</h1>
                        </div>
                    </div>
                </div>
                <div class="row margin-top-40">
                    <div class="col-xs-3">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="profile-avatar" style="background-image: url(<?=$AppUser->getInfo()['photo']?>)">
                                    <div <?=$AppUser->getInfo()['photo'] ? 'style="opacity:0;"': '' ?> class="profile-avatar-overlay">
                                        <button data-toggle="modal" data-target="#modalAvatarChange" class="button button-pink">
                                            <?=$AppUser->getInfo()['photo'] ? 'Изменить': 'Добавить' ?>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 margin-top-40">
                                <a href="/users/me/settings" class="button button-pink button-full-width">Редактировать</a>
                            </div>

                            <div class="col-xs-12 margin-top-40">
                                <div class="profile-rating">
                                    <p>Ваш рейтинг</p>
                                    <span class="card-pink-bg">№<?=$rank['rank']?></span>
                                </div>
                            </div>

                            <div class="col-xs-12 margin-top-40">
                                <div class="profile-rating">
                                    <p>Сумма баллов</p>
                                    <span class="card-pink-bg"><?=$balls_all['balls']?></span>
                                </div>
                            </div>

                            <div class="col-xs-12 margin-top-40">
                                <div class="profile-rating">
                                    <p>Баланс (Зелфи)</p>
                                    <span class="card-pink-bg"><?=$balls_all['zelfi']?> <span class="hide zf-icon zf-icon-arrow-right"></span></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-9">
                        <div class="row margin-top-20">
                            <div class="col-xs-5">
                                <div class="profile-header">
                                    <h1><?=$AppUser->getInfoItem('first_name')?> <?=$AppUser->getInfoItem('last_name')?> <span class="profile-badge hide"></span></h1>
                                    <span class="subtitle">id <?=sprintf('%06d', $AppUser->getInfoItem('id')) ?></span>

                                </div>
                            </div>


                            <?php if(!empty($teams_alert[1][0]) || $teams_alert[0]['name']): ?>
                                <div class="col-xs-4">
                                    <div class="profile-header">
                                        <a href="#" class="button button-pink button-full-width" data-toggle="modal" data-target=#teamAlert>Приглашения в команду</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="row margin-top-20">
                                    <div class="profile-info">
                                        <div class="col-xs-12">
                                            <div class="profile-info">
                                                <h2 class="title-decorated title-decorated-cyan"><span>Основная информация</span></h2>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12">
                                        <div class="row info-item">
                                            <div class="col-xs-3">
                                                <div class="info-label">Город</div>
                                            </div>
                                            <div class="col-xs-9">
                                                <div class="info-labeled">
                                                    <span class="info-text"><?=$AppUser->getInfoItem('residence_name')?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 hide">
                                        <div class="row info-item">
                                            <div class="col-xs-3">
                                                <div class="info-label">Клубы</div>
                                            </div>
                                            <div class="col-xs-9">
                                                <div class="info-labeled">
                                                    <span class="info-text">Сообщество бегунов</span>
                                                    <br />
                                                    <span class="info-text">Воркаут Альметьевск</span>
                                                    <br /><br />
                                                    <a href="#" class="info-link">Добавить клуб +</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <div class="row margin-top-20">
                                    <div class="col-xs-12">
                                        <div class="profile-info">
                                            <h2 class="title-decorated title-decorated-cyan"><span>Баллы по сезонам</span></h2>
                                        </div>
                                    </div>

                                    <?php foreach ($seasons as $index => $season): ?>
                                        <div class="col-xs-12">
                                            <div class="row info-item">
                                                <div class="col-xs-3">
                                                    <div class="info-label"><?=$season['name']?> </div>
                                                </div>
                                                <div class="col-xs-2">
                                                    <div class="info-labeled">
                                                        <span class="info-text"><?=$season['user_balls'] ? $season['user_balls'] : 0 ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-7">
                                                    <div class="info-labeled">
                                                        <div class="seasons-diagram-item" style="width: <?=(100/$balls_all['balls']*($season['user_balls'] ? $season['user_balls'] : 0) )?>%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>

                        <!-- team block -->
                        <div class="row margin-top-20">

                            <div class="col-xs-12">
                                <div class="row">

                                    <div class="col-xs-12">
                                        <div class="profile-info">
                                            <h2 class="title-decorated title-decorated-cyan"><span>Моя команда</span></h2>
                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <?php if (!$team): // нет команды ?>
                                        <!--                                    <div class="col-xs-6">-->
                                        <!--                                        <div class="row info-item">-->
                                        <!--                                            <div class="col-xs-9">-->
                                        <!---->
                                        <!---->
                                        <!---->
                                        <!---->
                                        <!--                                                <div class="info-label">-->
                                        <div class="col-xs-12 margin-top-20">
                                            <div class="profile-info">
                                                <div class="profile-info-video-empty">
                                                    <img src="/assets/images/zelfi.jpg" />

                                                    <a href="#" id='create-team' class="margin-left-15" data-toggle=modal data-target=#modalTeam>

                                                        <div>
                                                            Создать команду
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>



                                        <!---->
                                        <!--                                                </div>-->
                                        <!---->
                                        <!--                                            </div>-->
                                        <!---->
                                        <!--                                        </div>-->
                                        <!---->
                                        <!--                                    </div>-->

                                    <?php else: // есть команда ?>
                                        <div class="col-xs-12">
                                            <img style="width:895px; margin:10px" src="/uploads/system/teams/ifelse.jpg" >
                                        </div>
                                        <hr>
                                        <div class="col-xs-12">

                                            <div class="col-xs-2">

                                                <?php if ($team_photo): ?>
                                                    <img class="img-circle" width="80" height="80" style="margin:10px"  src="<?=$team_photo?>"/>
                                                <?php else: ?>

                                                    <img class="img-circle" width="80" height="80" style="margin:10px" src="/uploads/system/teams/default.jpg" >

                                                <?php endif; ?>
                                                
                                            </div>
                                            <div class="col-xs-3">
                                                <h3> <?=$team['name']?></h3>
                                                <p>Город: <b><?=$team_city?></b></p>
                                            </div>
                                            <div class="col-xs-6 text-right">
                                                <h4 style="padding-top:20px"> Рейтинг команды <span class="card-pink-bg" style="padding:20px"><?=$team['point']?></span></h4>
                                            </div>


                                        </div>

                                        <div class="col-xs-12">
                                            <table class="table table-hover">

                                                <?php foreach ($crew as $user): ?>
                                                    <tr>
                                                        <td width="160">
                                                            <?php if($user['photo_small']): ?>
                                                                <img  style="border-radius:50px; width:40px; margin-left:35px" src=<?=$user['photo_small']?>
                                                            <?php else: ?>
                                                                <img  style="border-radius:50px; width:40px; margin-left:35px" src="/uploads/system/users/avatars/1/defult_user.jpg" >
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <h5><?=$user['first_name']?>
                                                                <?=$user['last_name']?></h5>

                                                        </td>
                                                        <?php if($user['captain']==$user['user_id']): ?>

                                                            <td><h5>Капитан команды</h5></td>
                                                        <?php else: ?>
                                                            <td><h5>Участник<h5></td>
                                                        <?php endif; ?>
                                                        <td></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>
                                        </div>
                                        <div class="col-xs-12">
                                            <?php if($user['captain']==$zfUser->getId()): ?>
                                               <div class="col-xs-4"><a href="/users/me/changelider" id="listMembers" class="button button-pink button-full-width"  data-toggle=modal data-target=#updateTeam>Редактировать команду</a></div>
                                               <div class="col-xs-4"><a href="#" id="addMember" class="button button-pink button-full-width"  data-toggle=modal data-target=#updateTeam>Добавить участников</a></div>

                                            <?php else: ?>
                                                <div class="col-xs-4"><a href="/users/me/team/<?=$zfUser->getId()?>/out" class="button button-pink button-full-width" >Выйти из команды</a></div>

                                            <?php endif; ?>

                                            <div class="col-xs-4"></div>
                                        </div>





                                    <?php endif; ?>
                                </div>

                            </div>

                        </div>
                        <!-- team block end -->

                        <div class="row margin-top-20">

                            <div class="col-xs-12">
                                <div class="profile-info">
                                    <h2 class="title-decorated title-decorated-cyan"><span>Полученные баллы</span></h2>
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <?php if (!$balls_history): ?>
                                <div class="row info-item">
                                    <div class="col-xs-3">
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="info-labeled">
                                            <span class="info-text">Данных нет</span>
                                        </div>
                                    </div>
                                </div>
                                <?php else: ?>
                                    <?php for ($i=0;$i<min(3, count($balls_history)); $i++): ?>
                                    <div class="row info-item">
                                        <div class="col-xs-3">
                                            <div class="info-label"><?=\Zelfi\Utils\DateHelper::getDateFromDateTIme($balls_history[$i]['date_created'])?></div>
                                        </div>
                                        <div class="col-xs-9">
                                            <div class="info-labeled">
                                                <span class="info-text"><?=$balls_history[$i]['type_name']?><span class="info-balls">+<?=$balls_history[$i]['balls']?></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endfor; ?>
                                <?php endif; ?>

                                <?php if (count($balls_history)>3): ?>
                                    <div class="row">
                                    <div class="col-xs-9 col-xs-offset-3">
                                        <div class="info-labeled">
                                            <br />
                                            <a data-toggle="modal" data-target="#modalBalls" href="#" class="info-link">Показать всю историю</a>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>

                            </div>

                        </div>

                        <div class="row margin-top-20">

                            <div class="col-xs-12">
                                <div class="profile-info">
                                    <h2 class="title-decorated title-decorated-cyan"><span>Видео моих занятий спортом</span></h2>
                                </div>
                            </div>

                            <div class="col-xs-12 margin-top-20">
                                <div class="profile-info">
                                    <div class="profile-info-video-empty">
                                        <img src="/assets/images/video_empty.png" />
                                        <?php if ($balls_users_video_may_upload): ?>
                                            <a data-toggle="modal" data-target="#modalVideoAdd"  href="#">
                                        <?php else:?>
                                            <a  data-toggle="modal" data-target="#modalMessage" data-message="Видео можно присылать только один раз в сутки. Возвращайтесь сюда завтра!" href="#">
                                        <?php endif;?>
                                                <div>
                                                    Прикрепить ссылку
                                                </div>
                                            </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 margin-top-20">
                                <div class="profile-info">
                                    <div class="profile-info-video-item">
                                        <div class="row">

                                            <?php if ($balls_users_video_not_approved) foreach ($balls_users_video_not_approved as $index => $video): ?>

                                            <div class="col-xs-6">
                                                <div class="cover">
                                                    <div class="overlay">
                                                        <form method="post" action="/users/balls/videos/remove">
                                                            <input type="hidden" name="user_video_id" value="<?=$video['id']?>">

                                                            <button title="Отменить проверку видео" type="submit" class="close">
                                                                <img src="/assets/images/icon_close.png">
                                                            </button>
                                                            <img src="/assets/images/icon_video.png">
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="info dark margin-top">
                                                    <p class="margin-top"><?=$video['name']?></p>
                                                    <span class="zf-icon zf-icon-calendar"><?=\Zelfi\Utils\DateHelper::getDateFromDateTIme($video['date_created'])?></span>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="row ">
                    <div class="col-xs-12 margin-top-40 hide">
                        <h2 class="profile-part-title">Как получить больше баллов</h2>
                    </div>
                </div>

                <div class="row profile-how-get-balls margin-top-20 hide">
                    <div class="col-xs-4 item">
                        <div class="counter">
                            1.
                        </div>
                        <div class="text">
                            Заполни до конца <br />
                            свой профиль
                        </div>
                        <div class="balls">+150</div>
                    </div>

                    <div class="col-xs-4 item">
                        <div class="counter">
                            3.
                        </div>
                        <div class="text">
                            Вступи в наши группы <br />
                            в социальных сетях
                        </div>
                        <div class="balls">+230</div>
                    </div>

                    <div class="col-xs-4 item">
                        <div class="counter">
                            5.
                        </div>
                        <div class="text">
                            Сними и выложи видео <br />
                            своих занятий спортом
                        </div>
                        <div class="balls">+130</div>
                    </div>

                    <div class="col-xs-4 item">
                        <div class="counter">
                            2.
                        </div>
                        <div class="text">
                            Пригласи друга <br />
                            на сайт
                        </div>
                        <div class="balls">+115</div>
                    </div>

                    <div class="col-xs-4 item">
                        <div class="counter">
                            4.
                        </div>
                        <div class="text">
                            Создай свою <br />
                            команду
                        </div>
                        <div class="balls">+195</div>
                    </div>

                    <div class="col-xs-4 item">
                        <div class="counter">
                            6.
                        </div>
                        <div class="text">
                            Зарегистрируйся <br />
                            на мероприятие online
                        </div>
                        <div class="balls">+115</div>
                    </div>
                </div>

                <div class="row margin-top-60">
                    <div class="col-xs-12">
                        <div class="profile-events-controls">
                            <ul class="profile-tabs" role="tablist">
                                <li class="active">
                                    <a href="#tab0" aria-controls="tab0" role="tab" data-toggle="tab" aria-expanded="true">Мои мероприятия</a>
                                </li>
                                <li>
                                    <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab" aria-expanded="true">Покупки</a>
                                </li>
                                <li class="hide">
                                    <a href="#">Конкурсы</a>
                                </li>
                            </ul>

                            <ul class="profile-toggles hide">
                                <li class="active">
                                    <a href="#">Планируемое</a>
                                </li>
                                <li>
                                    <a href="#">Прошедшее</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row margin-top-20">
                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane fade active in" id="tab0">
                            <div class="profile-events-items">
                                <?php if ($events_now) foreach ($events_now as $index => $item): ?>
                                    <?php require 'profile/item-profile-event.php'; ?>
                                <?php endforeach; ?>

                                <div class="material-item-action col-xs-3 item">
                                    <div class="square">
                                        <div class="square-content">
                                            <a href="/<?=$AppUser->getInfoItem('city_alias')?>/events">Узнать о новых <br /> мероприятиях</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade in" id="tab1">
                            <div class="profile-events-items">
                                <?php if ($store_orders_active) foreach ($store_orders_active as $index => $order_item): ?>
                                    <?php
                                    $item = [];
                                    $item['balls'] =  $order_item['store_item']['balls'];
                                    $item['cover'] = $order_item['store_item']['cover'];
                                    $item['title'] = $order_item['store_item']['name'];
                                    $item['price_print'] = $order_item['price_print'];
                                    $item['date'] = $order_item['date_created'];
                                    require 'profile/item-profile-store-order.php'; ?>
                                <?php endforeach; ?>

                                <div class="material-item-action col-xs-3 item">
                                    <div class="square">
                                        <div class="square-content">
                                            <a href="/<?=$AppUser->getInfoItem('city_alias')?>/store">Совершить <br /> покупку</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>

<?php include 'footer.php' ?>