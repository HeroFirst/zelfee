<?php
/* @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *  @var \Zelfi\Model\ZFCities $AppCities
 */

if ($AppRendererHelper != null){
    $FooterScripts = $AppRendererHelper->getFooterScripts();
    $FooterData = $AppRendererHelper->getFooterData();
}

require_once __DIR__.'/../header.php'
?>

<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="/private/users/all">Все</a></li>
                <li >  <a class="btn btn-success" href="/private/users/teams/create">Создать команду</a></li>
<!--                <li><a href="/private/users/disabled">Отключенные</a></li>-->
            </ul>

            <div class="tab-content">
                <table class="table table-bordered table-striped data-table-full">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название команды</th>
                        <th>Количество баллов</th>
                        <th>Количество участников</th>

                        <th></th>



                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($teams) foreach ($teams as $index => $teams): ?>
                        <div class="modal modal-danger fade in" id="deleteTeam<?=$teams['id']?>" tabindex="-1" role="dialog" style="display: none; padding-right: 19px;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title">Внимание</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Вы действительно хотите удалить команду: <h3><?=$teams['name']?></h3> </p>
                                    </div>
                                    <div class="modal-footer">
                                        <form id="formRemove" method="post" action="/private/events/members/remove">
                                            <input type="hidden" name="event_id" value="44">
                                            <input type="hidden" name="user_id" value="1">
                                        </form>
                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Отменить</button>
                                        <a href="/private/users/teams/all?delete=<?=$teams['id']?>"  class="btn btn-outline">Удалить</a>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <tr>
                            <td><?=$teams['id']?></td>
                            <td><?=$teams['name']?></td>
                            <td><?=$teams['point']?></td>
                            <td><?=$teams['count_team']?></td>
                            <td>
                                <a href="/private/users/team/<?=$teams['id']?>/edit" class="btn btn-success"><i class="fa fa-sliders" ></i></a>
                                <a  class="btn btn-danger" data-toggle="modal" data-target="#deleteTeam<?=$teams['id']?>"  ><i class="fa fa-close"></i></a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Название команды</th>
                        <th>Количество баллов</th>
                        <th>Количество участников</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
