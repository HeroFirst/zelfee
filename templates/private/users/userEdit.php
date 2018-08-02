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

<?php if ($_GET['message']): ?>
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?=$_GET['message']?>
</div>
<?php endif; ?>

<form id="form-user-edit" action="/private/users/edit" method="post" class="form-horizontal">
    <div class="form-group">
        <div class="col-md-4">
            <input value="<?=$user['first_name']?>" type="text" class="form-control" name="first_name" placeholder="Имя" >
        </div>

        <div class="col-md-4">
            <input value="<?=$user['last_name']?>" type="text" class="form-control" name="last_name" placeholder="Фамилия">
        </div>

        <?php
        if ($AppUser->getRole()==1 || $user['role'] < $AppUser->getRole()):?>
            <div class="col-md-4">
                <select name="role" class="form-control select2">
                    <?php if ($roles) foreach ($roles as $index => $role): ?>
                        <option <?=$role['id']==$user['role'] ? 'selected' : ''?> value="<?=$role['id']?>"><?=$role['name']?></option>
                        <?php
                    endforeach; ?>
                </select>
            </div>
        <?php endif;  ?>
    </div>

    <div class="form-group">
        <div class="col-md-4">
            <div class="input-group">
                <input value="<?=$user['email']?>" type="email" class="form-control" name="email" placeholder="Email">
                <div class="input-group-btn">
                    <button form="form-user-email-check" type="submit" class="btn btn-warning">Сбросить информацию</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group">
                <input value="<?=$user['phone']?>" type="tel" class="form-control" name="phone" placeholder="Номер телефона">
                <div class="input-group-btn">
                    <button id="phone_check" type="button" class="btn btn-success">Подтвердить</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <select name="city" class="form-control select2">
                <?php if ($AppCities) foreach ($AppCities->getCities() as $index => $item): ?>
                    <div class="col-md-12">
                        <option <?=$item['id']==$user['residence'] ? 'selected' : ''?>  value="<?=$item['id']?>"><?=$item['name']?></option>
                    </div>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-3">
            <input value="<?=($_GET['rfidid'] ? $_GET['rfidid'] : $user['rfidid'])?>" type="text" class="form-control" name="rfidid" placeholder="RFIDID">
        </div>
        <div class="col-md-9">
            <input value="<?=$user['description']?>" type="text" class="form-control" name="description" placeholder="Описание">
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <?php if (!$user['active']): ?>
                <button type="submit" form="enableForm" class="btn btn-success pull-left">Включить</button>
            <?php else: ?>
                <button type="submit" form="disableForm" class="btn btn-danger pull-left">Отключить</button>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
        </div>
    </div>

    <input name="user_id" value="<?=$user['id']?>" type="hidden">
</form>
<form id="disableForm" action="/private/users/disable" method="post">
    <input name="user_id" value="<?=$user['id']?>" type="hidden">
</form>
<form id="enableForm" action="/private/users/enable" method="post">
    <input name="user_id" value="<?=$user['id']?>" type="hidden">
</form>
<form method="post" id="form-user-email-check" action="/private/users/reset">
    <input type="hidden" value="<?=$user['id']?>" name="user_id">
</form>
<?php require_once  __DIR__.'/../footer.php' ?>
